@extends('layouts.master',['dialog' => true])

@section('content')
<div class="central">
    @include('layouts.singleLogo')
    <h1>Masuk</h1>
    <form class="form" method="post" action="{{ route('login') }}">
        {{ csrf_field() }} 
        <div>
            <div class="formlabel">Username atau Email</div>
            <div><input autofocus type="text" name="username" value="{{ old('username') }}"></div>
        </div>
        <div>
            <div class="formlabel">Password</div>
            <div><input type="password" name="password"></div>
        </div>
        <div>
            <input type="submit" value="Masuk">
        </div>
    </form>
    <div>Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></div>
</div>
@endsection