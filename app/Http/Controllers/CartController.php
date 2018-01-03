<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Cart;

class CartController extends Controller
{
    public function index(){
        $carts = auth()->user()->cart()->with('user')->orderBy('user_id')->get();
        return view('backend.carts.index',compact('carts'));
    }

    public function store(){
        if(auth()->user()->cart->contains(request('item'))){
            return back();
        }
        auth()->user()->cart()->attach([request('item') => ['quantity' => request('quantity')]]);
        return "Barang ditambahkan ke keranjang";
    }
}
