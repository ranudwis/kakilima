@extends('backend.layout')

@section('content')
@if(Auth::check())
        <input type="number" min="1" max="{{ $item->stock }}" value="1"><a href="{{ route('addcart',['item' => $item->id]) }}" class="addToCart">Tambah ke keranjang</a>
@endif
<h1>{{ $item->name }}</h1>
<div>Stok: {{ $item->stock }}</div>
<div>Terjual: {{ $item->sold }}</div>
<div>Harga: {{ $item->price }}</div>
<div>Kondisi: {{ $item->condition }}</div>
<div>Kategori: {{ $item->category->name }}</div>
<div>{{ $item->description }}</div>
<div>
    @foreach($item->photo as $phot)
        <img src="{{ url(Storage::url($phot)) }}">
    @endforeach
</div>
@endsection