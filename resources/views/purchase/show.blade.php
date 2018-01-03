@extends('backend.layout')

@section('content')
    Transaksi
    Penjual: {{ $purchase->seller->name }}
    <br>Status: {{ $purchase->status }}
    @foreach($purchase->items as $item)
        <div>{{ $item->pivot->quantity }} x {{ $item->name }} {{ $item->price * $item->pivot->quantity }}</div>
    @endforeach
    @if($purchase->getOriginal('status') == 'sent')
        <a href="{{ route('confirmpurchase',['purchase' => $purchase->id]) }}">Konfirmasi terima barang</a>
    @endif
@endsection