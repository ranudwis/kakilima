<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $items = \App\Item::orderBy('sold','desc')->with('reviews')->take(5)->get();
        $categories = \App\Category::all();
        $sliders = \DB::table('sliders')->select('filename')->get();
        if(!is_null($user = auth()->user())){
            $favorites = $user->favorite;
        }else{
            $favorites = collect([]);
        }
        return view('home',compact('items','favorites','categories','sliders'));
    }
}
