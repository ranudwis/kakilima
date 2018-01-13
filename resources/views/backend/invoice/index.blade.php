@extends('backend.layout')

@section('content')
    @foreach($invoices as $invoice)
        <div>
            <a href="{{ route('invoice.show',['invoice' => $invoice->invoiceId]) }}"><code>{{ $invoice->invoiceId }}</code></a> {{ $invoice->status }}
        </div>
    @endforeach
@endsection
