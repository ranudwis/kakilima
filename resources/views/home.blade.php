@extends('layouts.master')

@section('content')
    <div id="welcomeWrapper">
        <div id="welcomeCategory">
            <h2>Kategori</h2>
            <div id="welcomeCategoryList">
                <a href="">Perabot</a>
                <a href="">Perabot</a>
                <a href="">Perabot</a>
                <a href="">Perabot</a>
                <a href="">Perabot</a>
                <a href="">Perabot</a>
                <a href="">Perabot</a>
                <a href="">Perabot</a>
                <a href="">Perabot</a>
                <a href="">Kategori Lainnya</a>
            </div>
        </div>
        <div id="slider">
            slider
        </div>
    </div>
    <div class="section">
        <h2>Produk Pilihan</h2>
        <div class="productWrapper">
            @foreach($items as $item)
                <div class="product" id="{{ $item->slug }}">
                    <a href="{{ route('showitem',['item'=>$item->slug]) }}"><img class="productImage" src="{{ url(Storage::url($item->photo[0])) }}"></a>
                    <div class="productDescription">
                        <div class="productStars">
                            @php $stars = $item->calculateStars() @endphp
                            @for($i = 0; $i < $stars; $i++)
                                <img src="{{ url('/images/star.png') }}">
                            @endfor
                            @for($j = $i; $j < 5; $j++)
                                <img src="{{ url('/images/starBlack.png') }}">
                            @endfor
                            <span class="starsReviews">
                                ({{ $stars }})
                            </span>
                        </div>
                        <div class="productName"><a href="{{ route('showitem',['item'=>$item->slug]) }}">{{ $item->name }}</a></div>
                        <div class="productPrice">Rp. {{ $item->price }}</div>
                    </div>
                    <div class="addToFav">
                        @if(in_array($item->id,$favorites))
                            <img src="{{ url('/images/favActive.png') }}" class="active">
                        @else
                            <img src="{{ url('/images/fav.png') }}">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <a class="sectionButton" href="">Selengkapnya</a>
    </div>
    <div class="section">
        <h2>Brand Resmi</h2>
        <div class="officialProduct">
            <a href=""><img src="{{ url('/images/brand.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand2.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand2.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand2.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand2.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand2.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand2.png') }}"></a>
            <a href=""><img src="{{ url('/images/brand.png') }}"></a>
        </div>
        <a class="sectionButton" href="">Selengkapnya</a>
    </div>
@endsection
@section('footer')
    @include('layouts/offer')
@endsection