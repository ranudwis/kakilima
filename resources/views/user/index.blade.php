@extends('backend.layout')

@section('content')
    <div>
        Nama: {{ $user->name }}
    </div>
    <div>
        Email: {{ $user->email }}
    </div>
    <div>
        Username: {{ $user->username }}
    </div>
    <div>
        Jenis kelamin: {{ $user->gender }}
    </div>
    <div>
        <form method="post" action="{{ route('user') }}">
            {{ csrf_field() }}
            Alamat
            <textarea name="address">{{ $user->address }}</textarea>
            <input type="submit" value="Simpan">
        </form>
    </div>
@endsection