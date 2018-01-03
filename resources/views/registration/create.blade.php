@extends('layouts.master',["dialog" => true])

@section('content')
<div class="central">
    @include('layouts.singleLogo')
    <h1>Daftar Baru</h1>
    <form class="form" method="post" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div>
            <div class="formlabel">Nama</div>
            <div><input type="text" name="name" value="{{ old('name') }}" autofocus></div>
        </div>
        <div>
            <div class="formLabel">Email</div>
            <div><input type="email" name="email" value="{{ old('email') }}"></div>
        </div>
        <div>
            <div>Jenis Kelamin</div>
            <div>
                <input type="radio" name="gender" value="M" id="male" checked>
                <label for="male">Laki-laki</label>
                <input type="radio" name="gender" values="F" id="female">
                <label for="female">Perempuan</label>
            </div>
        </div>
        <div>
            <div class="formLabel">Username</div>
            <div><input type="text" name="username" value="{{ old('username') }}"></div>
        </div>
        <div>
            <div class="formLabel">Password</div>
            <div><input type="password" name="password"></div>
        </div>
        <div>
            <div class="formLabel">Ulangi Password</div>
            <div><input type="password" name="password_confirmation"></div>
        </div>
        <div>
            <input type="submit" value="Daftar">
        </div>
    </form>
    <div>Sudah punya akun? <a href="{{ route('login') }}">Masuk disini</a></div>
</div>
@endsection