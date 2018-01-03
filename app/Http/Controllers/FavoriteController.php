<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function store(){
        $item = \App\Item::where('slug',request('item'));
        auth()->user()->favorites()->attach($item);
        return "1";
    }
}
