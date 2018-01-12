@extends('layouts.master')

@section('content')
    <div class="section">
        <h2>Edit jumlah barang</h2>
        <form method="post" action="{{ route('cart.edit',['item' => $cart->id])}}" class="regularForm">
            {{ csrf_field() }}
            <div>
                <div>Jumlah barang</div>
                <div><input type="number" value="{{ $cart->pivot->quantity }}" name="quantity"></div>
            </div>
            <div>
                <input type="submit" value="Edit">
            </div>
        </form>
    </div>
@endsection
