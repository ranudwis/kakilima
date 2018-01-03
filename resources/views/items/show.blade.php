@extends('layouts.master')

@section('content')
<div class="section">
    <div class="flexWrapper">
        <div class="imageViewer">
            <div class="mainImage">
                <img src="{{ url(Storage::url($photos[0])) }}">
            </div>
            <div class="otherImages">
                @foreach($photos as $photo)
                    <img src="{{ url(Storage::url($photo)) }}">
                @endforeach
            </div>
        </div>
        <div class="productDescription">
            <h2>{{ $item->name }}</h2>
            <table>
                <tr>
                    <td>Stok {{ $item->stock }}</td>
                    <td>Terjual {{ $item->sold }}</td>
                </tr>
            </table>
        </div>
    </div>
    @if(Auth::check())
            <input type="number" min="1" max="{{ $item->stock }}" value="1"><a href="{{ route('addcart',['item' => $item->id]) }}" class="addToCart">Tambah ke keranjang</a>
    @endif
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
</div>
@endsection