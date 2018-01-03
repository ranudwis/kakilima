@extends('backend.layout')

@section('content')
    @if($carts->isEmpty())
        Anda belum punya barang dalam keranjang anda 
    @else
        @php $last = 0;$total = 0; @endphp
        @foreach($carts as $item)
            @php
                $user = $item->user;
                $now = $item->price * $item->pivot->quantity;
                $total += $now;
                if($last != $user->id){
                    $last = $user->id;
                    echo "<br>".e($user->name)."<br>";
                }
            @endphp
            {{ $item->name }} {{ $item->price }} x {{ $item->pivot->quantity }} {{ $item->price * $item->pivot->quantity }} <br>
        @endforeach
        <br><br><br>
        Total belanja Anda {{ $total }}<br>
        <a href="{{ route('addinvoice') }}">Proses</a>
    @endif
@endsection