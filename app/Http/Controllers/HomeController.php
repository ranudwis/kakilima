<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $items = \App\Item::orderBy('sold','desc')->with('reviews')->take(5)->get();
        if(!is_null($user = auth()->user())){
            $favorites = $user->favorites->toArray();
        }else{
            $favorites = [];
        }
        return view('home',compact('items','favorites'));
    }
}
