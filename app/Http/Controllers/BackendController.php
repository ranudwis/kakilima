<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function itemIndex(){
        $items = \App\Item::where('stock', '>', 0)->where('user_id','<>',auth()->id())->orderBy('created_at','desc')->with('category')->get();
        return view('backend.items.index',compact('items'));
    }

    public function itemCreate(){
        $categories = \App\Category::all();
        return view('backend.items.create',compact('categories'));
    }

    public function itemStore(){
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

    public function itemShow(\App\Item $item){
        return view('backend.items.show',compact('item'));
    }
}
