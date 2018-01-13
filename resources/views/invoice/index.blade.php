@extends('layouts.master')

@section('content')
    <div class="section linesection">
        <h2>Transaksi</h2>
        @if($invoices->isEmpty())
            Kamu belum memilki transaksi apapun
        @endif
        @foreach($invoices as $invoice)
            @php $total = 0; @endphp
            <div class="subSectionWrapper">
                <h4>Invoice: <code>{{ $invoice->invoiceId }}</code></h4>
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
                        @php $temp = $transaction->calculateTotal(); $total += $temp @endphp
                        <div class="price">{{ 'Rp'.number_format($temp,0,',','.') }}</div>
                    </div>
                @endforeach
                <div class="totalPerCart">
                    <span>Total: {{ 'Rp'.number_format($total,0,',','.') }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endsection
