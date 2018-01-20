<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Notification;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function disposal(){
        $disposals = auth()->user()->disposals()->where('status', '!=', 'saved')->orderBy('updated_at','desc')->with('user')->get();
        return view('backend.disposal.index',compact('disposals'));
    }

    public function showDisposal(){
        $disposal = Transaction::where('id',request('disposal'))->where('seller_id',auth()->id())->with('user','item')->first();
        return view('backend.disposal.show',compact('disposal'));
    }

    public function confirmDisposal(Transaction $disposal){
        $this->validate(request(),[
            'receipt' => 'required'
        ]);
        $disposal->receiptNumber = request('receipt');
        $disposal->status = 'sent';
        $disposal->save();

        session()->flash('cm', 'Barang telah dikirim');
        return back();
    }

    public function rejectdisposal(Transaction $disposal){
        $disposal->status = 'reject';
        $disposal->save();

        session()->flash('cm', 'Transaksi telah ditolak');
        return back();
    }

    public function purchase(){
        $purchases = auth()->user()->transactions()->where('status','!=','saved')->orderBy('updated_at','desc')->with('items','seller')->get();

        return view('purchase.index',compact('purchases'));
    }

    public function showPurchase(Transaction $purchase){
        $purchase->load('items', 'seller');
        return view('purchase.show',compact('purchase'));
    }

    public function confirmPurchase(Transaction $purchase){
        $purchase->status = 'done';
        $purchase->save();
        session()->flash('cm', 'Anda telah melakukan konfirmasi');
        return back();
    }

    public function index(){
        $disposals = auth()->user()->disposal()->whereIn('status',['paid','reject','sent','done'])->where('invoiceReject','false')->with('user','item')->orderBy('id','desc')->get();
        return view('disposal.index',compact('disposals'));
    }

    public function show(Transaction $disposal){
        $disposal->load('user','item');
        $statusText = [
            'paid' => 'credit-card',
            'sent' => 'truck',
            'done' => 'check',
        ];
        return view('disposal.show',compact('disposal','statusText'));
    }

    public function reject(Transaction $disposal){
        $disposal->status = 'reject';
        $disposal->save();

        $data = [
            'invoice' => $disposal->invoice->invoiceId
        ];
        $notification = new Notification();
        $notification->user_id = $disposal->user->id;
        $notification->text = 'Pesanan kamu telah ditolak';
        $notification->action = 'invoice.show';
        $notification->data = json_encode($data);
        $notification->save();
        return back()->with('cm','Pesanan ditolak');
    }

    public function send(Transaction $disposal){
        $this->validate(request(),[
            'receiptNumber' => 'required|min:10'
        ]);

        $disposal->receiptNumber = request('receiptNumber');
        $disposal->status = 'sent';
        $disposal->sent_at = new \carbon\Carbon();
        $disposal->save();
        $data = [
            'invoice' => $disposal->invoice->invoiceId
        ];
        $notification = new Notification();
        $notification->user_id = $disposal->user->id;
        $notification->text = 'Pesanan kamu telah dikirim';
        $notification->action = 'invoice.show';
        $notification->data = json_encode($data);
        $notification->save();

        return back()->with('cm','Pesanan dikirim');
    }

    public function done(Transaction $transaction){
        $transaction->status = 'done';
        $transaction->done_at = new \Carbon\Carbon();
        $transaction->save();
        $data = [
            'disposal' => $transaction->id
        ];

        $notification = new Notification();
        $notification->user_id = $transaction->seller->id;
        $notification->text = 'Pesanan telah diterima';
        $notification->action = 'disposal.show';
        $notification->data = json_encode($data);
        $notification->save();

        return back()->with('cm','Pesanan diterima');
    }
}
