@extends('layouts.master')

@section('content')
<div class="central">
    <div class="container">
        <form method="post" class="form" action="{{ url('/masuk') }}">
            {{ csrf_field() }}
            <div>
                <div>Username atau Email</div>
                <div><input type="text" name="username" autofocus></div>
            </div>
            <div>
                <div>Password</div>
                <div><input type="password" name="password"></div>
            </div>
            <div>
                <input type="submit" value="Masuk" class="btnmedium">
            </div>
        </form>
    </div>
</div>
@endsection