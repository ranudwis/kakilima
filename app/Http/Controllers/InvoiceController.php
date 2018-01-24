<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Transaction;
use App\Cart;
use App\Notification;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function add(){
        $items = auth()->user()->cart()->with('user')->get();
        $price = [];
        $totalPrice = 0;
        $attaches = [];
        foreach($items as $item){
            $totalPrice += $item->price * $item->pivot->quantity;
            @$attaches[$item->user_id][$item->id] = ['quantity' => $item->pivot->quantity];
            @$price[$item->user_id] += $item->price * $item->pivot->quantity;
            // foreach($item as $itemuser){
            //     $totalPrice += $itemuser->price * $itemuser->pivot->quantity;
            //     @$attaches[$user][] = $itemuser->id;
            //     @$price[$user] += $itemuser->price * $itemuser->pivot->quantity;
            // }
        }
        do{
            $invoiceId = 'KL'.strtoupper(str_random(10));
            $check = Invoice::where('invoiceId',$invoiceId)->get();
        }while(!$check->isEmpty());

        $invoice = new Invoice();
        $invoice->user_id = auth()->id();
        $invoice->totalPrice = $totalPrice;
        $invoice->invoiceId = $invoiceId;
        $invoice->save();

        $data = "";
        foreach($price as $user => $pric){
            $data .= $pric;
        }
        foreach($price as $user => $pric){
            $transaction = new Transaction();
            $transaction->invoice_id = $invoice->id;
            $transaction->user_id = auth()->id();
            $transaction->seller_id = $user;
            $transaction->totalPrice = $pric;
            $transaction->save();

            $transaction->items()->attach($attaches[$user]);
        }
        $carts = Cart::where('user_id',auth()->id())->get();
        $case = "";
        $case2 = "";
        $id = "";
        foreach($carts as $cart){
            $case .= " when {$cart->item_id} then stock-{$cart->quantity}";
            $case2 .= " when {$cart->item_id} then sold+{$cart->quantity}";
            $id .= "{$cart->item_id},";
        }
        $id = substr($id,0,-1);
        DB::update("update items set stock = case id $case end,sold = case $case2 end where id in($id)");

        Cart::truncate();
        return redirect()->route('showinvoice',['invoice' => $invoiceId]);
    }

    public function index(){
        $invoices = auth()->user()->invoice()->orderBy('id','desc')->with(['transaction.item:id,price,slug,photo','transaction.seller:id,name'])->get();
        return view('invoice.index',compact('invoices'));
    }

    public function show(Invoice $invoice){
        $invoice->load('transaction','coupon:id,code');
        $invoice->transaction->load('item:id,name,slug,photo,price','seller:id,name');
        $userAddress = auth()->user()->address;
        $statusText = [
            'saved' => 'refresh',
            'wait' => 'hourglass-half',
            'paid' => 'credit-card',
            'sent' => 'truck',
            'done' => 'check',
        ];
        return view('invoice.show',compact('invoice','userAddress','statusText'));
    }

    public function pay($invoice){
        $invoice = auth()->user()->invoice()->where('invoiceId',$invoice)->firstOrFail();
        $payPrice = $invoice->getOriginal('totalPrice') - $invoice->cutoffPrice.'.'.rand(111,555);
        $invoice->payPrice = $payPrice;
        $invoice->status = 'wait';
        $invoice->save();

        $invoice->transaction()->update(['status' => 'wait']);

        return back();
    }

    public function useCoupon($invoice){
        $this->validate(request(),[
            'code' => 'required|exists:coupons,code'
        ]);
        $coupon = \App\Coupon::where('code',request('code'))->first();
        $invoice = auth()->user()->invoice()->where('invoiceId',$invoice)->firstOrFail();

        $total = $invoice->getOriginal('totalPrice');
        $discount = ($coupon->discount/100)*$total;
        $discount = $discount < $coupon->getOriginal('maximum') ? $discount : $coupon->getOriginal('maximum');
        if($total < $coupon->getOriginal('minimum')){
            return back()->withError('code','Minimal transaksi adalah '.$coupon->minimum);
        }
        $invoice->cutoffPrice = $discount;
        $invoice->coupon()->associate($coupon);
        $invoice->save();

        $coupon->increment('used');

        foreach($invoice->transaction as $transaction){
            $totalPrice = $transaction->getOriginal('totalPrice');
            $transactionDiscount = $discount * ($totalPrice / $total);
            $transaction->cutoffPrice = round($transactionDiscount,3);
            $transaction->save();
        }
        return back()->with('cm','Kode kupon digunakan');
    }

    public function uploadPayment($invoice){
        $this->validate(request(),[
            'payment' => 'required|image'
        ]);
        $invoice = auth()->user()->invoice()->where('invoiceId',$invoice)->firstOrFail();
        if(!is_null($invoice->paymentInfo)){
            \Storage::delete($invoice->paymentInfo);
        }
        $invoice->paymentInfo = request('payment')->store('public/payment');
        $invoice->save();
        return back()->with('cm','Mohon tunggu konfirmasi pembayaran Anda oleh admin');
    }

    public function confirm(Invoice $invoice){
        $invoice->load('transaction.seller');
        $insert = [];
        foreach($invoice->transaction as $transaction){
            $data = [
                'disposal' => $transaction->id
            ];

            $notification = new Notification();
            $notification->user_id = $transaction->seller->id;
            $notification->text = 'Kamu mendapatkan pesanan baru';
            $notification->action = 'disposal.show';
            $notification->data = json_encode($data);
            $notification->save();
        }

        $invoice->transaction()->update([
            'status' => 'paid',
            'paid_at' => new \Carbon\Carbon()
        ]);

        $data = [
            'invoice' => $invoice->invoiceId
        ];
        $notification = new Notification();
        $notification->user_id = $invoice->user->id;
        $notification->text = 'Pembayaran kamu telah dikonfirmasi';
        $notification->action = 'invoice.show';
        $notification->data = json_encode($data);
        $notification->save();

        $invoice->status = 'paid';
        $invoice->save();

        return back()->with('cm', 'Transaksi berhasil dikonfirmasi');;
    }

    public function reject(Invoice $invoice){
        $invoice->status = 'reject';
        $invoice->transaction()->update([
            'invoiceReject' => '1'
        ]);
        $invoice->save();
        $data = [
            'invoice' => $invoice->invoiceId
        ];
        $notification = new Notification();
        $notification->user_id = $invoice->user->id;
        $notification->text = 'Pembayaran kamu telah ditolak';
        $notification->action = 'invoice.show';
        $notification->data = json_encode($data);
        $notification->save();

        return back()->with('cm', 'Transaksi berhasil ditolak');
    }
}
