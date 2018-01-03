<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index','store']);
    }

    public function index(){
        $user = auth()->user();
        return view('user.index',compact('user'));
    }

    public function store(){
        auth()->user()->update(request()->all());
        return back();
    }
}
