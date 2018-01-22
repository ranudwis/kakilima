@extends('layouts.master')

@section('content')
    <div class="flexWrapper">
        <div class="sideSection">
            <form class="regularForm singleForm smallForm" method="get" action="{{ route('item') }}">
                <input type="hidden" name="q" value="{{ $query['q']}}">
                <div>Kategori</div>
                <div>
                    <div>
                        <select name="category">
                            <option value="">Semua kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($query["category"] == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <div class="h-separator"></div>
                </div>
                <div>Kondisi</div>
                <div>
                    <div>
                        <select name="condition">
                            <option value="" @if(is_null($query['condition'])) selected @endif>Semua kondisi</option>
                            <option value="1" @if($query['condition'] === '1') selected @endif>Baru</option>
                            <option value="0" @if($query['condition'] === '0') selected @endif>Bekas</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="h-separator"></div>
                </div>
                <!-- <div>Urutkan</div>
                <div>
                    <div>
                        <select name="order">
                        </select>
                    </div>
                </div>
                <div>
                    <div class="h-separator"></div>
                </div> -->
                <div>Rentang harga</div>
                <div>
                    <div>
                        <input type="text" name="minPrice" placeholder="Minimal" value="{{ $query['minPrice'] }}">
                    </div>
                </div>
                <div>
                    <div>
                        <input type="text" name="maxPrice" placeholder="Maksimal" value="{{ $query['maxPrice'] }}">
                    </div>
                </div>
                <div>
                    <div class="h-separator"></div>
                </div>
                <div>
                    <button class="applyButton">Terapkan</button>
                </div>
            </form>
        </div>
        <div class="section">
            @if($items->isEmpty())
                Tidak ada barang
            @endif
            <div class="productWrapper left">
                @foreach($items as $item)
                    <div class="product" id="{{ $item->slug }}">
                        <a href="{{ route('item.show',['item'=>$item->slug]) }}"><img class="productImage" src="{{ url(Storage::url($item->photo[0])) }}">@if($item->getOriginal('condition') == 0) <span class="usedCondition">Bekas</span>@endif</a>
                        <div class="productDescription">
                            <div class="productStars">
                                @php $stars = $item->calculateStars() @endphp
                                @for($i = 0; $i < $stars; $i++)
                                    <i class="fa fa-star fa-fw yellow"></i>
                                @endfor
                                @for($j = $i; $j < 5; $j++)
                                    <i class="fa fa-star-o fa-fw"></i>
                                @endfor
                                <span class="starsReviews">
                                    ({{ $stars ?? 0 }})
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
        </div>
    </div>
@endsection
