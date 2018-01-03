<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Coupon;
use App\Invoice;
use App\Notification;
use App\Transaction;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(){
        return view('dashboard.index',['linkName' => 0,'subLink' => 0]);
    }

    public function dashboard($dash, $subdash = 0){
        $data = false;
        switch($dash){
            case "kategori":
                switch($subdash){
                    case "statistik":
                        $data = \App\Category::all();
                        break;
                }
                break;
            case "transaksi":
                $data = Invoice::where('status','wait')->with('user')->orderBy('updated_at','desc')->get();
                break;
        }
        return view('dashboard.index',['linkName' => $dash,'subLink' => $subdash, 'data' => $data]);
    }

    public function addCategory(){
        $this->validate(request(),[
            'name' => 'required|min:2|unique:categories,name'
        ]);
        Category::create(request()->all());

        session()->flash('cm','Kategori telah ditambahkan');

        return redirect()->route('board',['board' => 'kategori','subboard' => 'statistik']);
    }

    public function addCoupon(){
        $this->validate(request(),[
            'code' => 'required|min:3|max:10|unique:coupons',
            'minimum' => 'required',
            'discount' => 'required',
            'maximum' => 'required'
        ]);
        Coupon::create(request()->all());

        session()->flash('cm','Kupon telah ditambahkan');

        return redirect()->route('board', ['board' => 'coupon', 'subboard' => 'tampil']);
    }

    public function confirminvoice(Invoice $invoice){
        $invoice->load('transactions.seller');
        $insert = [];
        $transactionIds = [];
        foreach($invoice->transactions as $transaction){
            $transactionIds[] = $transaction->id;

            $data = [
                'disposal' => $transaction->id
            ];

            $notification = new Notification();
            $notification->user_id = $transaction->seller->id;
            $notification->text = 'Kamu mendapatkan pesanan baru';
            $notification->action = 'showdisposal';
            $notification->data = json_encode($data);
            $notification->save();
        }

        Transaction::whereIn('id',$transactionIds)->update([
            'status' => 'paid'
        ]);

        // Notification::create($insert);

        $invoice->status = 'paid';
        $invoice->save();

        session()->flash('cm', 'Transaksi berhasil dikonfirmasi');

        return back();
    }

    public function rejectinvoice(Invoice $invoice){
        $invoice->status = 'reject';
        $invoice->save();

        session()->flash('cm', 'Transaksi berhasil ditolak');

        return back();
    }
}
