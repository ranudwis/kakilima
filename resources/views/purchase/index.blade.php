@extends('backend.layout')

@section('content')
    @foreach($purchases as $purchase)
        <div>
            <a href="{{ route('showpurchase',['purchase' => $purchase->id]) }}">{{ $purchase->seller->name }}</a>
        </div>
    @endforeach
@endsection