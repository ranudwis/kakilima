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
            'photo.*' => 'required|image'
        ]);

        auth()->user()->addItem(request()->all());

        return back();
    }

    public function show(Item $item){
        $photos = $item->photo;
        return view('items.show',compact('item','photos'));
    }
}
