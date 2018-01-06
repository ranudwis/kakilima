<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['index','store']);
    }

    public function index(){
        $user = auth()->user();
        return view('user.index',compact('user'));
    }

    public function editPhoto(){
        $photo = auth()->user()->photo;
        return view('user.editPhoto',compact('photo'));
    }

    public function updatePhoto(){
        $this->validate(request(),[
            'photo' => 'required|image'
        ]);

        $photo = auth()->user()->getOriginal('photo');
        if(!empty($photo)){
            \Storage::delete($photo);
        }
        $user = auth()->user();
        $user->photo = request('photo')->store('/public/users');
        $user->save();
        return redirect()->route('user')->with('cm', 'Foto profil sukses diubah');
    }

    public function editProfile(){
        $user = auth()->user();
        return view('user.editProfile',compact('user'));
    }

    public function updateProfile(){
        $this->validate(request(),[
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required|in:M,F',
            'username' => 'required',
            'address' => 'required|min:10'
        ]);
        $email = User::select('id')->where('id','!=',auth()->id())->where('email',request('email'))->first();
        $username = User::select('id')->where('id','!=',auth()->id())->where('username',request('username'))->first();
        if(!empty($email)){
            return back()->withErrors(['email' => 'Email sudah digunakan']);
        }
        if(!empty($username)){
            return back()->withErrors(['username' => 'Username sudah digunakan']);
        }
        auth()->user()->update(request()->all());

        return redirect()->route('user')->with('cm','Profil berhasil diedit');
    }
}
