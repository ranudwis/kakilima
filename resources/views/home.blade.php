@extends('layouts.master')

@section('content')
    <div id="welcomeWrapper">
        <div id="welcomeCategory">
            <h2>Kategori</h2>
            <div id="welcomeCategoryList">
                @foreach($categories as $category)
                    <a href="{{ route('showcategory',['category' => $category->id]) }}">{{ $category->name }}</a>
                @endforeach
                <a href="">Kategori Lainnya</a>
            </div>
        </div>
        <div id="slider">
            @foreach($sliders as $slider)
                <img src="{{ url(Storage::url($slider->filename)) }}" @if($loop->first) class="active" @endif>
            @endforeach
            <div class="control control-left"><i class="fa fa-chevron-left fa-fw"></i></div>
            <div class="control control-right"><i class="fa fa-chevron-right fa-fw"></i></div>
        </div>
    </div>
    <div class="section">
        <h2>Produk Pilihan</h2>
        <div class="productWrapper">
            @foreach($items as $item)
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
                        <div class="productPrice">{{ $item->price }}</div>
                    </div>
                    <div class="addToFav">
                        @if($favorites->contains($item->id))
                            <a href="{{ route('favorite.remove',['item' => $item->id])}}"<i class="fa fa-heart"></i></a>
                        @else
                            <a href="{{ route('favorite.add',['item' => $item->id])}}"<i class="fa fa-heart-o"></i></a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <a class="sectionButton" href="">Selengkapnya <i class="fa fa-chevron-right"></i></a>
    </div>
@endsection
@section('footer')
    @include('layouts/offer')
@endsection
