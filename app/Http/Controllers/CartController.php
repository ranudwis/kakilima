<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Cart;
use App\User;
use App\Invoice;

class CartController extends Controller
{
    public function index(){
        $carts = auth()->user()->cart()->with('user')->orderBy('user_id')->get();
        return view('backend.carts.index',compact('carts'));
    }

    public function edit($item){
        $cart = auth()->user()->cart()->where('item_id',$item)->firstOrFail();
        return view('carts.edit',compact('cart'));
    }

    public function store($item){
        $this->validate(request(),[
            'quantity' => 'required|integer|min:0'
        ]);
        auth()->user()->cart()->updateExistingPivot($item,['quantity' => request('quantity')]);
        return redirect()->route('cart')->with('cm','Jumlah barang berhasil diedit');
    }

    public function process($user){
        $carts = auth()->user()->cart()->where('items.user_id',$user)->get();
        \DB::update("update items inner join carts on carts.item_id=items.id inner join users on users.id=items.user_id set items.stock=items.stock-carts.quantity,items.sold=items.sold+carts.quantity");
        auth()->user()->cart()->detach($carts->pluck('id')->toArray());
        $total = 0;
        $attaches = [];
        foreach($carts as $item){
            $attaches[$item->id] = ['quantity' => $item->pivot->quantity];
            $total += $item->calculateTotalOriginal();
        }
        do{
            $invoiceId = 'KL'.strtoupper(str_random(10));
            $check = Invoice::where('invoiceId',$invoiceId)->first();
        }while(!is_null($check));

        $invoice = auth()->user()->invoice()->create([
            'totalPrice' => $total,
            'invoiceId' => $invoiceId,
        ]);

        $transaction = auth()->user()->transaction()->create([
            'seller_id' => $user,
            'invoice_id' => $invoice->id,
            'totalPrice' => $total
        ]);
        $transaction->item()->attach($attaches);

        return redirect()->route('invoice.show',['invoice' => $invoiceId]);
    }

    public function processAll(){
        $carts = auth()->user()->cart()->with('user')->get();
        \DB::update("update items inner join carts on carts.item_id=items.id inner join users on users.id=items.user_id set items.stock=items.stock-carts.quantity,items.sold=items.sold+carts.quantity");
        auth()->user()->cart()->detach($carts->pluck('id')->toArray());
        $attaches = [];
        $total = 0;
        $price = [];
        foreach($carts as $item){
            $attaches[$item->user_id][$item->id] = ['quantity' => $item->pivot->quantity];
            $temp = $item->calculateTotalOriginal();
            $total += $temp;
            @$price[$item->user_id] += $temp;
        }
        do{
            $invoiceId = 'KL'.strtoupper(str_random(10));
            $check = Invoice::where('invoiceId',$invoiceId)->get();
        }while(!$check->isEmpty());

        $invoice = auth()->user()->invoice()->create([
            'totalPrice' => $total,
            'invoiceId' => $invoiceId
        ]);

        foreach($price as $user => $pric){
            $transaction = auth()->user()->transaction()->create([
                'seller_id' => $user,
                'invoice_id' => $invoice->id,
                'totalPrice' => $pric
            ]);

            $transaction->item()->attach($attaches[$user]);
        }

        return redirect()->route('invoice.show',['invoice' => $invoiceId]);
    }
}
