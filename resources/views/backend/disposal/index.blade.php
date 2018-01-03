@extends('backend.layout')

@section('content')
    @foreach($disposals as $disposal)
        <a href="{{ route('showdisposal',['disposal' => $disposal->id]) }}">{{ $disposal->user->name }}</a> {{ $disposal->totalPrice }}
        <br>
    @endforeach
@endsection