@extends('backend.layout')

@section('content')
    @foreach($invoices as $invoice)
        <div>
            <a href="{{ route('showinvoice',['invoice' => $invoice->invoiceId]) }}">{{ $invoice->invoiceId }}</a> {{ $invoice->status }}
        </div>
    @endforeach
@endsection