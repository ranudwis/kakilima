<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    protected $redirectPath = '/beranda';

    public function __construct(){
        $this->middleware('guest')->except('destroy');
    }

    public function create(){
        return view('session.create');
    }

    public function store(){
        if(filter_var(request('username'),FILTER_VALIDATE_EMAIL)){
            $use = 'email';
        }else{
            $use = 'username';
        }

        $auth = auth()->attempt([
            $use => request('username'),
            "password" => request('password')
        ]);

        if(!$auth){
            return back()->withErrors(['cm' => 'Username atau password salah']);
        }

        session()->flash('cm','Selamat datang');
        $user = \App\User::where('username',request('username'))->first();

        if($user->banned){
            auth()->logout();
            return redirect()->route('login')->withErrors(['cm' => 'Akun kamu diblokir']);
        }
        if($user->level == 0){
            return redirect()->route('home');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function destroy(){
        auth()->logout();
        session()->flash('cm','Berhasil keluar');
        return redirect()->route('home');
    }
}
