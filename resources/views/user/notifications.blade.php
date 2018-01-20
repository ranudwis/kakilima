@extends('layouts.master')

@section('content')
    <div class="section linesection">
        <h2>Notifikasi</h2>
        @if($notification_count != 0)
            <a href="{{ route('notification.read') }}" class="btn btnBlue btnanimation"><i class="fa fa-eye"></i> Tandai sudah dibaca</a>
        @endif
        @foreach($notifications as $notification)
            <div class="notificationItem @if(!$notification->viewed) read @endif">
                <a href="{{ route('notification.show',['notification' => $notification->id])}}">{{ $notification->text }}</a>
            </div>
        @endforeach
    </div>
@endsection
