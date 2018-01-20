@extends('backend.layout')

@section('content')
    @foreach($notifications as $notification)
        <a href="{{ route('shownotification',$notification->id) }}">{{ $notification->text }}</a><br>
    @endforeach
@endsection
