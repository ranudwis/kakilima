@extends('layouts.master')

@section('content')
    <div class="section linesection">
        <h2>Barang Favorit</h2>
        <div class="productWrapper left">
            @if($favorites->isEmpty())
                <div class="emptyFav">Kamu belum memiliki barang favorit</div>
            @endif
            @foreach($favorites as $item)
                <div class="product" id="{{ $item->slug }}">
                    <a href="{{ route('item.show',['item'=>$item->slug]) }}"><img class="productImage" src="{{ url(Storage::url($item->photo[0])) }}"></a>
                    <div class="productDescription">
                        <div class="productStars">
                            @php $stars = $item->calculateStars() @endphp
                            @for($i = 0; $i < $stars; $i++)
                                <i class="fa fa-star fa-fw"></i>
                            @endfor
                            @for($j = $i; $j < 5; $j++)
                                <i class="fa fa-star-o fa-fw"></i>
                            @endfor
                            <span class="starsReviews">
                                ({{ $stars }})
                            </span>
                        </div>
                        <div class="productName"><a href="{{ route('item.show',['item'=>$item->slug]) }}">{{ $item->name }}</a></div>
                        <div class="productPrice">Rp. {{ $item->price }}</div>
                    </div>
                    <div class="addToFav">
                        <a href="{{ route('favorite.remove',['item' => $item->id])}}"<i class="fa fa-heart"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endsection
