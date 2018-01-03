<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Transaction;
use App\Cart;
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
        $invoices = auth()->user()->invoices()->orderBy('id','desc')->get();
        return view('backend.invoice.index',compact('invoices'));
    }

    public function show(Invoice $invoice){
        $invoice->load('transactions.items','transactions.seller');
        $userlogin = auth()->user();
        return view('backend.invoice.show',compact('invoice','userlogin'));
    }

    public function pay(Invoice $invoice){
        $payPrice = $invoice->totalPrice - $invoice->cutoffPrice.','.rand(111,555);
        $invoice->payPrice = $payPrice;
        $invoice->status = 'wait';
        $invoice->save();

        if(!empty($invoice->cutoffPrice)){
            foreach($invoice->transactions as $transaction){
                $percentage = $transaction->totalPrice * 100 / $invoice->totalPrice;
                $transactionCut = $percentage / 100 * $invoice->cutoffPrice;
                $transactionCut = round($transactionCut,3);
                $transaction->cutoffPrice = $transactionCut;
                $transaction->save();
            }
        }

        $userlogin = auth()->user();
        return redirect()->route('showinvoice',['invoice' => $invoice->invoiceId]);
    }
}
