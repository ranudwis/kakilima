@extends('backend.layout')

@section('content')
    <h1>{{ $invoice->invoiceId }}</h1>
    <div>{{ $invoice->status }}</div>
    <br>
    @foreach($invoice->transactions as $transaction)
        <b>{{ $transaction->seller->name }} {{ $transaction->totalPrice }}</b>
        @foreach($transaction->items as $item)
            <div>{{ $item->pivot->quantity}} <a href="{{ route('showitem', ['item' => $item->slug]) }}">{{ $item->name}}</a> {{ $item->price * $item->pivot->quantity }}</div>
        @endforeach
        <br>
    @endforeach

    Barang akan dikirmkan ke alamat: {{ $userlogin->address }}
    @empty($userlogin->address)
        <a href="{{ route('user') }}">Tambah alamat</a>
    @endempty
         <br><br><br>
        Total belanja {{ $invoice->totalPrice }}<br>
        @if(empty($invoice->cutoffPrice) && $invoice->getOriginal('status') == 'saved')
            <form method="post" action="{{ route('usecoupon') }}">
                {{ csrf_field() }}
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <input type="text" name="code" placeholder="Punya kode kupon">
            </form>
        @else
            @if($invoice->cutoffPrice)
                Potongan {{ $invoice->cutoffPrice }}<br>
            @endif
            Pembayaran {{ $invoice->totalPrice - $invoice->cutoffPrice }}
        @endif
    @switch($invoice->getOriginal('status'))
        @case('saved')
            @unless(empty($userlogin->address))
                <a href="{{ route('pay',['invoice' => $invoice->invoiceId]) }}">Lanjut ke pembayaran</a>
            @endunless
            @break
        @case('wait')
            <br>Bayar dengan nominal {{ $invoice->payPrice }}
            @break
        @case('paid')
            <br>Silahkan tunggu pesanan anda untuk dikirim
            @break
        @case('reject')
            <br>Pesanan Anda ditolak
            @break
        @case('sent')
            <br>Pesanan telah dikirim
            @break
        @case('done')
            <br>Selesai
            @break
    @endswitch
@endsection