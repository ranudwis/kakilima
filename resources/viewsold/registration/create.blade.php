@extends('layouts.master')

@section('content')
<div class="central">
    <div class="container">
        <form method="post" class="form" action="{{ url('/daftar') }}">
            {{ csrf_field() }}
            <div>
                <div>Nama</div>
                <div><input type="text" name="name" values="{{ old('name') }}" autofocus></div>
            </div>
            <div>
                <div>Email</div>
                <div><input type="email" name="email" values="{{ old('email') }}"></div>
            </div>
            <div>
                <div>Username</div>
                <div><input type="text" name="username" value="{{ old('username') }}"></div>
            </div>
            <div>
                <div>Password</div>
                <div><input type="password" name="password"></div>
            </div>
            <div>
                <div>Ulangi Password</div>
                <div><input type="password" name="password_confirmation"></div>
            </div>
            <div>
                <input type="submit" value="Daftar" class="btnmedium">
            </div>
        </form>
    </div>
</div>
 @endsection