@extends('layouts.master')

@section('content')
    <div class="section linesection">
        <h2>Penjualan</h2>
        @if($disposals->isEmpty())
            Kamu belum punya riwayat penjualan
        @endif
        @foreach($disposals as $disposal)
            <div class="subSectionWrapper">
                <h4>Transaksi <code>#{{ $disposal->id }}</code>
                    @switch($disposal->getOriginal('status'))
                        @case('saved')
                            <span class="status btn btnGray"><i class="fa fa-refresh fa-fw"></i>
                            @break
                        @case('wait')
                            <span class="status btn btnBlue"><i class="fa fa-hourglass-half fa-fw"></i>
                            @break
                        @case('paid')
                            <span class="status btn btnGreen"><i class="fa fa-credit-card fa-fw"></i>
                            @break
                        @case('reject')
                            <span class="status btn btnRed"><i class="fa fa-times fa-fw"></i>
                            @break
                    @endswitch
                    {{ $disposal->status }}
                </h4>
                <a href="{{ route('disposal.show',['disposal' => $disposal->id]) }}" class="btn btnBlue btnanimation">Selengkapnya <i class="fa fa-chevron-right"></i></a>
                <div class="totalPrice">{{ $disposal->totalPrice }}</div>
                <div class="subSectionItem column">
                    <div class="smallImages">
                        @foreach($disposal->item as $item)
                            <a href="{{ route('item.show',['item' => $item->slug]) }}"><img src="{{ url(Storage::url($item->photo[0])) }}"></a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </dv>
@endsection
