@extends('layouts.master')

@section('content')
<div class="section linesection">
    <h2>Edit foto profil</h2>
    <div class="flexWrapper" style="justify-content: left">
        <img src="{{ $photo }}" class="profilePhoto" style="margin-right: 8px">
        <form method="post" enctype="multipart/form-data" class="regularForm" action="{{ route('user.editPhoto') }}">
            {{ csrf_field() }}
            <div>
                <div>Unggah foto</div>
                <div>
                    <input type="file" name="photo">
                </div>
            </div>
            <div>
                <input type="submit" value="simpan">
            </div>
        </form>
    </div>
</div>
@endsection
