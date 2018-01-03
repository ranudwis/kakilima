<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegistrationController extends Controller
{
    // protected $redirectTo = route('home');

    public function __construct(){
        $this->middleware('guest');
    }

    public function create(){
        return view('registration.create');
    }

    public function store(){
        $this->validate(request(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'gender' => 'required|in:M,F',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create(request()->all());

        session()->flash('cm','Selamat datang '.request('name'));

        auth()->login($user);

        return redirect()->route('home');
    }
}
