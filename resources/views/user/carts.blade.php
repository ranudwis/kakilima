@extends('layouts.master')

@section('content')
    <div class="section linesection">
        <h2>Keranjang belanja</h2>
        <a href="{{ route('cart.processAll') }}" class="btn btnBlue btnanimation" style="margin-bottom: 16px"><i class="fa fa-cogs fa-fw"></i> Proses semua</a>
        @if($carts->isEmpty())
            <div class="emptyCart">Kamu belum memiliki barang di keranjang</div>
        @endif
        @foreach($carts as $user)
            @php $total = 0; @endphp
            <div class="subSectionWrapper">
                <h4>Penjual: {{ $user[0]->seller->name }}</h4>
                @foreach($user as $item)
                    <div class="subSectionItem">
                        <img src="{{ url(Storage::url($item->photo[0])) }}" class="image">
                        <div class="description">
                            <a href="{{ route('item.show',['item' => $item->slug]) }}" class="name">{{ $item->name }}</a>
                            <div class="price">{{ $item->price }}</div>
                        </div>
                        <div class="times">
                            x {{ $item->pivot->quantity }}
                        </div>
                        <div class="totalItem">
                            {{ $item->calculateTotal() }}
                            @php $total += $item->calculateTotalOriginal(); @endphp
                        </div>
                    </div>
                @endforeach
                <div class="totalPerCart">
                    <span>Total: Rp{{ number_format($total,0,',','.') }}</span>
                    <a href="{{ route('cart.process',['cart' => $item->seller->id]) }}" class="btn btnBlue btnanimation">
                        <i class="fa fa-cog fa-fw"></i> Proses transaksi
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
