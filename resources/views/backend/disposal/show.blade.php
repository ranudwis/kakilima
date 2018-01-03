@extends('backend.layout')

@section('content')
    Pembelian oleh: {{ $disposal->user->name }}
    <br>Total belanja: {{ $disposal->totalPrice }}
    <br>Potongan: {{ $disposal->cutoffPrice }}
    <br>Status: {{ $disposal->status }}
    <br>
    <br>
    @foreach($disposal->items as $item)
        <div>{{ $item->pivot->quantity }} x {{ $item->name }} {{ $item->pivot->quantity * $item->price }}</div>
    @endforeach
    @if($disposal->getOriginal('status') == 'paid')
        <form method="post" action="{{ route('confirmdisposal',['disposal' => $disposal->id]) }}">
            {{ csrf_field() }}
            <input type="text" name="receipt" placeholder="Nomor resi">
            <input type="submit" value="Kirim barang">
        </form>
        <a href="{{ route('rejectdisposal',['disposal' => $disposal->id]) }}">Tolak pesanan</a>
    @endif
@endsection