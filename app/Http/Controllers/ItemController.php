<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Category;

class ItemController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only('create','store','edit','update');
    }

    public function index(){
        $this->validate(request(),[
            'category' => 'nullable|exists:categories,id',
            'condition' => 'nullable|in:1,0',
            'minPrice' => 'nullable|integer|min:0',
            'maxPrice' => 'nullable|integer|min:0',
        ]);
        $categories = Category::all();
        $items = Item::where('stock','>','0')->where('user_id','!=',auth()->id());
        $query = [
            'q' => request()->query('q',null),
            'condition' => request()->query('condition',null),
            'category' => request()->query('category',null),
            'minPrice' => request()->query('minPrice',null),
            'maxPrice' => request()->query('maxPrice',null),
        ];

        if(!is_null($query['q'])){
            $items->where('name','like','%'.$query['q'].'%');
        }

        if(!is_null($query['category'])){
            $items->where('category_id',$query['category']);
        }
        if(!is_null($query['condition'])){
            $items->where('condition',$query['condition']);
        }
        if(!is_null($query['minPrice'])){
            $items->where('price','>',$query['minPrice']);
        }
        if(!is_null($query['maxPrice'])){
            $items->where('price','<',$query['maxPrice']);
        }

        $items = $items->with('reviews:item_id,stars')->get();
        if(!is_null($user = auth()->user())){
            $favorites = $user->favorite;
        }else{
            $favorites = collect([]);
        }
        return view('items.index',compact('categories','items','favorites','query'));
    }

    public function create(){
        $categories = Category::all();
        return view('items.create',compact('categories'));
    }

    public function store(){
        $this->validate(request(),[
            'name' => 'required|min:5|max:191',
            'price' => 'required|integer',
            'stock' => 'required|integer|min:1',
            'condition' => 'required|in:new,used',
            'category' => 'required|exists:categories,id',
            'description' => 'required|min:10',
            'photo' => 'required',
            'photo.*' => 'image'
        ]);

        auth()->user()->addItem(request()->all());

        return back()->with('cm','Barang berhasil ditambahkan');
    }

    public function show(Item $item){
        $item->view++;
        $item->save();
        $item->load('favorites','reviews','seller');
        $photos = $item->photo;
        $percentage = $item->seller->acceptPercentage();
        return view('items.show',compact('item','photos','percentage'));
    }

    public function manage(){
        $items = auth()->user()->items;
        return view('items.manage',compact('items'));
    }

    public function addToCart($item,$quantity){
        if(auth()->user()->cart->contains($item)){
            return back()->withErrors(['cm' => 'Barang sudah ada di keranjang']);
        }
        auth()->user()->cart()->attach($item,['quantity' => $quantity]);
        return back()->with('cm','Barang berhasil ditambahkan ke keranjang');
    }

    public function removeFromCart($item){
        if(!auth()->user()->cart->contains($item)){
            return back()->withErrors(['cm' => 'Barang tidak ada di keranjang']);
        }
        auth()->user()->cart()->detach($item);
        return back()->with('cm','Barang dihapus dari keranjang');
    }

    public function addToFavorite($item){
        if(auth()->user()->favorite->contains($item)){
            return back()->withErrors(['cm' => 'Barang sudah ada di favorit']);
        }
        auth()->user()->favorite()->attach($item);
        return back()->with('cm','Barang ditambahkan ke favorit');
    }

    public function removeFromFavorite($item){
        if(!auth()->user()->favorite->contains($item)){
            return back()->withErrors(['cm' => 'Barang tidak ada di favorit']);
        }
        auth()->user()->favorite()->detach($item);
        return back()->with('cm','Barang dihapus dari favorit');
    }
}
