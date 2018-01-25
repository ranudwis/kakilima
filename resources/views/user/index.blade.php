@extends('layouts.master')

@section('content')
<div class="section accountInformation linesection">
    <h2>Informasi akun</h2>
    <div class="flexWrapper">
        <div class="profilePhoto">
            <img src="{{ $user->photo }}">
            <a href="{{ route("user.editPhoto") }}" class="btn btnBlue btnanimation"><i class="fa fa-pencil fa-fw"></i>Edit foto</a>
        </div>
        <table class="userInformation">
            <tr>
                <td>Nama</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td>Username</td>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <td>Jenis kelamin</td>
                <td>{{ $user->gender }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>{{ $user->address }}</td>
            </tr>
            @if(is_null($user->telegram_id))
                <tr>>
                    <td>
                        <a href="{{ route('telegramIntegration') }}" class="btn btnTelegram btnanimation btnLarge" target="_blank">
                            <i class="fa fa-telegram fa-fw"></i> Hubungkan dengan akun Telegram
                        </a>
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="2"><a href="{{ route('user.editProfile') }}" class="btn btnBlue btnanimation"><i class="fa fa-pencil fa-fw"></i>Edit profil</a>
        </table>
    </div>
</div>
@endsection
