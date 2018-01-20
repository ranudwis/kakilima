@extends('layouts.master')

@section('content')
    <div class="flexWrapper">
        <div class="sideSection">
            <h2>#{{ $disposal->id }}</h2>
            <div class="invoiceInformation">
                <div class="totalPrice">{{ $disposal->totalPrice }}</div>
                <div class="userInformation">
                    <img class="image" src="{{ $disposal->user->photo }}">
                    <span class="name">{{ $disposal->user->name }}</span>
                </div>
                <div class="date">
                    Dibayar {{ $disposal->paid_at->formatLocalized('%d %B %Y %k:%M') }}
                    @if(!is_null($disposal->getOriginal('sent_at')))
                        Dikirim {{ $disposal->sent_at->formatLocalized('%d %B %Y %k:%M') }}
                    @endif
                    @if(!is_null($disposal->getOriginal('done_at')))
                        Diterima {{ $disposal->done_at->formatLocalized('%d %B %Y %k:%M') }}
                    @endif
                </div>
                <div class="h-separator"></div>
                @if($disposal->getOriginal('status') == 'paid')
                    <div class="disposalButton">
                        <a href="#" class="btn btnGreen btnanimation" onclick="return preSend()"><i class="fa fa-check fa-fw fa-lg"></i> Terima</a>
                        <a href="{{ route('disposal.reject',['disposal' => $disposal->id]) }}" onclick="return confirm('Yakin akan menolak pesanan?')" class="btn btnRed btnanimation"><i class="fa fa-times fa-fw fa-lg"></i> Tolak</a>
                    </div>
                    <div class="receiptForm" style="display:none">
                        <form method="post" action="{{ route('disposal.send',['disposal' => $disposal->id]) }}" class="regularForm singleForm">
                            {{ csrf_field() }}
                            <div>
                                <div>
                                    <input type="text" name="receiptNumber" placeholder="Nomor resi">
                                </div>
                            </div>
                            <div>
                                <input type="submit" value="Kirim">
                            </div>
                        </form>
                    </div>
                @elseif($disposal->getOriginal('status') == 'sent')
                    <div class="receiptNumber">Nomor resi {{ $disposal->receiptNumber }}</div>
                @endif
            </div>
        </div>
        <div class="section">
            <div class="subSectionWrapper">
                <div class="processWrapper">
                    @php $pass = false; @endphp
                    @foreach($statusText as $statusTex => $icon)
                        @if($pass)
                            @if($statusTex == 'done' && ($disposal->invoiceReject || $disposal->getOriginal('status') == 'reject'))
                                <div class="reject"><i class="fa fa-times fa-fw"></i></div>
                            @else
                                <div><i class="fa fa-{{ $icon }} fa-fw"></i></div>
                            @endif
                        @else
                            <div class="active"><i class="fa fa-{{ $icon }} fa-fw"></i></div>
                            @php if($statusTex == $disposal->getOriginal('status') || ($disposal->getOriginal('status') == 'reject' && $statusTex == 'paid')){ $pass = true; } @endphp
                        @endif
                    @endforeach
                </div>
                <div class="status">{{ $disposal->status }}</div>
                <div class="items">
                    @foreach($disposal->item as $item)
                        <div class="subSectionItem">
                            <img class="image" src="{{ url(Storage::url($item->photo[0]))}}">
                            <div class="description">
                                <a href="{{ route('item.show',['item' => $item->slug]) }}" class="name">{{ $item->name }}</a>
                                <div class="price">{{ $item->price }}</div>
                            </div>
                            <div class="times">
                                x {{ $item->pivot->quantity }}
                            </div>
                            <div class="totalItem">
                                {{ $item->calculateTotal() }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </divv>
    </div>
@endsection
