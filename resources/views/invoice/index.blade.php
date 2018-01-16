@extends('layouts.master')

@section('content')
    <div class="section linesection">
        <h2>Transaksi</h2>
        @if($invoices->isEmpty())
            Kamu belum memilki transaksi apapun
        @endif
        @foreach($invoices as $invoice)
            <div class="subSectionWrapper">
                <h4>Invoice: <code>{{ $invoice->invoiceId }}</code>
                    @switch($invoice->getOriginal('status'))
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
                    {{ $invoice->status }}
                 </h4>
                <a href="{{ route('invoice.show',['invoice' => $invoice->invoiceId]) }}" class="btn btnBlue btnanimation">Selengkapnya <i class="fa fa-chevron-right"></i></a>
                @foreach($invoice->transaction as $transaction)
                    <div class="subSectionItem column">
                        <h4>Transaksi: #{{ $transaction->id }}</h4>
                        <div class="name">Penjual: {{ $transaction->seller->name }}</div>
                        <div class="smallImages">
                            @foreach($transaction->item as $item)
                                <a href="{{ route('item.show',['item' => $item->slug]) }}">
                                    <img src="{{ url(Storage::url($item->photo[0])) }}">
                                </a>
                            @endforeach
                        </div>
                        <div class="price">{{ $transaction->totalPrice }}</div>
                    </div>
                @endforeach
                <div class="totalPerCart">
                    <span>{{ $invoice->totalPrice }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endsection
