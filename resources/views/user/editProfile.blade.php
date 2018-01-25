@extends('layouts.master')

@section('content')
    <div class="section linesection">
        <h3>Edit profil</h3>
        <form method="post" action="{{ route('user.editProfile') }}" class="regularForm halfForm">
            {{ csrf_field() }}
            <div>
                <div>Nama</div>
                <div>
                    <input type="text" name="name" value="{{ $user->name }}">
                </div>
            </div>
            <div>
                <div>Email</div>
                <div>
                    <input type="email" name="email" value="{{ $user->email }}">
                </div>
            </div>
            <div>
                <div>Username</div>
                <div>
                    <input type="text" name="username" value="{{ $user->username }}">
                </div>
            </div>
            <div>
                <div>Ganti password</div>
                <div>
                    <input type="password" name="password" value="">
                </div>
            </div>
            <div>
                <div>Ulangi password</div>
                <div>
                    <input type="password" name="password_confirmation" value="">
                </div>
            </div>
            <div>
                <div>Password lama</div>
                <div>
                    <input type="password" name="password_old" value="">
                </div>
            </div>
            <div>
                <div>Jenis kelamin</div>
                <div>
                    <input type="radio" name="gender" value="M" id="male" @if($user->getOriginal('gender') == 'M') checked @endif>
                    <label for="male">Laki-laki</label>
                    <input type="radio" name="gender" value="F" id="female" @if($user->getOriginal('gender') == 'F') checked @endif>
                    <label for="female">Perempuan</label>
                </div>
            </div>
            <div>
                <div>Alamat</div>
                <div><textarea name="address">{{ $user->address }}</textarea></div>
            </div>
            <div>
                <div><a href="{{ route('telegramIntegration') }}" class="btn btnTelegram btnanimation" target="_blank"><i class="fa fa-telegram fa-fw"></i></a></div>
            </div>
            <div>
                <input type="submit" value="Edit profil">
            </div>
        </form>
    </div>
@endsection
