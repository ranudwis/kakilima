@extends('layouts.master')

@section('content')
<div class="section linesection">
    <h2>Kelola barang</h2>
    <a href="{{ route('item.add') }}" class="btn btnBlue btnanimation"><i class="fa fa-plus"></i> Tambah barang</a>
    @if($items->isEmpty())
        <div>
            Kamu belum memiliki barang
        </div>
    @endif
    <div class="flexWrapper productWrapper productManage">
        @foreach($items as $item)
            <div class="product" id="{{ $item->slug }}">
                <div class="itemButton">
                    <a href="{{ route('item.edit',['item' => $item->slug]) }}" class="btn btnBlue btnanimation">
                        <i class="fa fa-pencil fa-fw"></i>
                    </a>
                    <a href="{{ route('item.destroy',['item' => $item->slug]) }}" class="btn btnRed btnanimation" onclick="return confirm('Hapus barang?')">
                        <i class="fa fa-trash fa-fw"></i>
                    </a>
                </div>
                <img class="productImage" src="{{ url(Storage::url($item->photo[0])) }}">
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
                            ({{ $stars ?? 0}})
                        </span>
                    </div>
                    <div class="productName"><a href="{{ route('item.show',['item'=>$item->slug]) }}">{{ $item->name }}</a></div>
                    <div class="productPrice">Rp. {{ $item->price }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
