@extends('layouts.master')

@section('content')
<div class="section linesection">
    <div class="flexWrapper">
        <div class="imageViewer">
            <div class="otherImages">
                @foreach($photos as $photo)
                    <img src="{{ url(Storage::url($photo)) }}">
                @endforeach
            </div>
            <div class="mainImage">
                <img src="{{ url(Storage::url($photos[0])) }}">
            </div>
        </div>
        <div class="productDescription">
            <h2 class="productTitle">{{ $item->name }}</h2>
            <span class="price">{{ $item->price }}</span>
            <table>
                <tr>
                    <td><i class="fa fa-tag fa-fw"></i> Kondisi</td>
                    <td> {{ $item->condition }}</td>
                    <td><i class="fa fa-cubes fa-fw"></i> Stok</td>
                    <td> {{ $item->stock }}</td>
                    <td><i class="fa fa-shopping-cart fa-fw"></i> Terjual</td>
                    <td> {{ $item->sold }}</td>
                </tr>
                <tr>
                    <td><i class="fa fa-eye fa-fw"></i> Dilihat</td>
                    <td> {{ $item->view }}</td>
                    <td><i class="fa fa-heart fa-fw"></i> Peminat</td>
                    <td> {{ $item->favorites->count() }}</td>
                    <td><i class="fa fa-comments fa-fw"></i> Ulasan</td>
                    <td> {{ $item->reviews->count() }}</td>
                </tr>
            </table>
            @unless($item->seller->id == auth()->id())
                <div class="productButton">
                    @if(auth()->check() && auth()->user()->cart->contains($item->id))
                        <a href="#" onclick="return false" class="btn btnGray"><i class="fa fa-shopping-cart fa-fw fa-lg"></i> Barang Sudah Di Keranjang</a>
                    @else
                        <div class="cartCountModWrapper">
                            <a href="#" onclick="return false" class="cartCountMod decCartCount"><i class="fa fa-minus fa-fw"></i></a>
                            <input type="text" value="1" max="{{ $item->stock }}" class="cartCount">
                            <a onclick="return false" href="#" class="cartCountMod incCartCount"><i class="fa fa-plus fa-fw"></i></a>
                        </div>
                        <a onclick="return addCart()" href="{{ route('cart.add',['item' => $item->id]) }}" class="btn btnGreen btnCart btnanimation"><i class="fa fa-cart-plus fa-fw fa-lg"></i> Tambah Ke Keranjang</a>
                    @endif
                    @if(auth()->check() && auth()->user()->favorite->contains($item->id))
                        <a href="{{ route('favorite.remove',['item' => $item->id]) }}" class="btn btnRed btnanimation"><i class="fa fa-trash-o fa-fw fa-lg"></i> Hapus Dari Favorit</a>
                    @else
                        <a href="{{ route('favorite.add',['item' => $item->id]) }}" class="btn btnBlue btnLarge btnFav btnanimation"><i class="fa fa-heart fa-lg fa-fw"></i> Tambah Ke Favorit</a>
                    @endif
                </div>
            @endunless
            <div class="sellerInformation">
                <div>
                    <div class="image">
                        <img src="{{ $item->seller->photo }}">
                    </div>
                    <span class="name">{{ $item->seller->name }}</span>
                </div>
                <div>
                    <div class="information">
                        {{ $item->seller->itemCount() }}
                        <div>Barang Dijual</div>
                    </div>
                </div>
                <div>
                    <div class="information">
                        {{ $percentage['percentage'] }}% ({{ $percentage['done'] }} / {{ $percentage['done'] + $percentage['reject']}})
                        <div>Pesanan Diterima</div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="productInformation">
            <div class="description">
                <h2>Deskripsi Barang</h2>
                {!! nl2br(e($item->description)) !!}
            </div>
            <div class="comments">
                <h2>Ulasan</h2>
                <div class="reviewWrapper">
                    @foreach($item->reviews as $review)
                        <div class="review">
                            <img src="{{ $review->photo }}" class="photo">
                            <div>
                                <div class="name">{{ $review->name }}</div>
                                <div class="stars">
                                    @for($i = 0; $i < $review->pivot->stars; $i++)
                                        <i class="fa fa-star yellow"></i>
                                    @endfor
                                    @for($j = $i; $j < 5; $j++)
                                        <i class="fa fa-star-o"></i>
                                    @endfor
                                </div>
                                <div class="reviewContent">{!! nl2br(e($review->pivot->review)) !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @unless($item->seller->id == auth()->id())
                    <form method="post" action="{{ route('review.add',['item' => $item->id ])}}" class="regularForm singleForm halfForm">
                        {{ csrf_field() }}
                        <div>
                            Tambah ulasan
                        </div>
                        <div>
                            <div>
                                <textarea name="review"></textarea>
                            </div>
                        </div>
                        <div>
                            <div class="starsButton">
                                @for($i = 1;$i < 6; $i++)
                                <input type="radio" name="stars" value="{{ $i }}" id="stars-{{ $i }}">
                                <label for="stars-{{ $i }}"><i class="fa fa-star-o"></i></label>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <input type="submit" value="Tambah ulasan">
                        </div>
                    </form>
                @endunless
            </div>
        </div>
    </div>
</div>
@endsection
