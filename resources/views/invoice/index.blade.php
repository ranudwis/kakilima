@extends('layouts.master')

@section('content')
    <div class="section linesection">
        <h2>Pembelian</h2>
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
                <div class="totalPrice">{{ $invoice->totalPrice }}</div>
                <div class="subSectionItem column">
                    <div class="smallImages">
                        @foreach($invoice->transaction as $transaction)
                            @foreach($transaction->item as $item)
                                <a href="{{ route('item.show',['item' => $item->slug]) }}">
                                    <img src="{{ url(Storage::url($item->photo[0])) }}">
                                </a>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
