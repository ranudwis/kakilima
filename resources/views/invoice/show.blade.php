@extends('layouts.master')

@section('content')
    <div class="flexWrapper">
        <div class="sideSection">
            <h2>{{ $invoice->invoiceId }}</h2>
            <div class="invoiceInformation">
                <div class="status">
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
                    {{ $invoice->status }}</span>
                </div>
                <div class="address">
                    @if(empty($userAddress))
                        Kamu belum memiliki alamat
                        <a href="{{ route('user.editProfile') }}" class="btn btnBlue btnanimation"><i class="fa fa-plus fa-fw"></i> Tambah alamat</a>
                    @else
                        <div>
                            Alamat penerima:
                        </div>
                        <div>
                            {{ $userAddress }}
                        </div>
                    @endif
                </div>
                @if(empty($invoice->coupon))
                    <div class="totalPrice">{{ $invoice->totalPriceCut() }}</div>
                @else
                    <div class="totalPrice cut">{{ $invoice->totalPrice }}</div>
                    <div class="cutPrice">-{{ 'Rp'.number_format($invoice->cutoffPrice,0,',','.') }}</div>
                    <div class="totalPrice">{{ $invoice->totalPriceCut() }}</div>
                @endif
                @if($userAddress)
                    <div class="coupon">
                        @if($invoice->getOriginal('status') == 'saved' && empty($invoice->coupon))
                            <form method="post" action="{{ route('invoice.usecoupon',['invoice' => $invoice->invoiceId]) }}" class="regularForm singleForm">
                                {{ csrf_field() }}
                                <div>
                                    <div>
                                        <input type="text" name="code" placeholder="Punya kode kupon?">
                                    </div>
                                </div>
                                <div>
                                    <input type="submit" value="Gunakan">
                                </div>
                            </form>
                        @endif
                        @if($invoice->coupon)
                            <div class="code">Kode kupon <b>{{ $invoice->coupon->code }}</b></div>
                        @endif
                    </div>
                    <div class="h-separator"></div>
                    <div class="continueButton">
                        @if($invoice->getOriginal('status') == 'saved')
                            <a href="{{ route('invoice.pay',['invoice' => $invoice->invoiceId]) }}" class="btn btnFull btnBlue btnanimation">Lanjut ke pembayaran <i class="fa fa-chevron-right"></i></a>
                        @elseif($invoice->getOriginal('status') == 'wait')
                            <div>Transfer sesuai nominal ke rekening</div>
                            <div class="paymentNumber">1234567890</div>
                            <div>Atas nama PT Kaki Lima</div>
                            <div style="margin-top: 16px">
                                @if(!is_null($invoice->paymentInfo))
                                    <a href="{{ url(Storage::url($invoice->paymentInfo)) }}" target="_blank" class="btn btnBlue btnanimation">Bukti pembayaran terunggah</a>
                                @endif
                                <form method="post" enctype="multipart/form-data" action="{{ route('invoice.uploadPayment',['invoice' => $invoice->invoiceId]) }}" class="regularForm singleForm">
                                    {{ csrf_field() }}
                                    <div>Unggah foto bukti pembayaran</div>
                                    <div>
                                        <div>
                                            <input type="file" name="payment">
                                        </div>
                                    </div>
                                    <div>
                                        <input type="submit" value="Unggah">
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="section">
            @foreach($invoice->transaction as $transaction)
                <div class="subSectionWrapper">
                    <h2>Transaksi #{{ $transaction->id }}</h2>
                    <div class="processWrapper">
                        @php $pass = false; @endphp
                        @foreach($statusText as $statusTex => $icon)
                            @if($pass)
                                @if($statusTex == 'done' && ($transaction->invoiceReject || $transaction->getOriginal('status') == 'reject'))
                                    <div class="reject"><i class="fa fa-times fa-fw"></i></div>
                                @else
                                    <div><i class="fa fa-{{ $icon }} fa-fw"></i></div>
                                @endif
                            @else
                                <div class="active"><i class="fa fa-{{ $icon }} fa-fw"></i></div>
                                @php if($statusTex == $transaction->getOriginal('status') || ($transaction->getOriginal('status') == 'reject' && $statusTex == 'paid')){ $pass = true; } @endphp
                            @endif
                        @endforeach
                    </div>
                    @if($transaction->invoiceReject)
                        <div class="status">Ditolak</div>
                    @else
                        <div class="status">{{ $transaction->status }}</div>
                    @endif
                    @if($transaction->getOriginal('status') == 'sent' || $transaction->getOriginal('status') == 'done')
                        <div class="subSectionItem column receipt">
                            <div class="receiptNumber">
                                <div>
                                    Dikirim pada {{ $transaction->sent_at->formatLocalized('%d %B %Y %k:%M') }}
                                </div>
                                <div>
                                    Nomor resi {{ $transaction->receiptNumber }}
                                </div>
                            </div>
                            @if($transaction->getOriginal('status') == 'sent')
                                <div>
                                    <a href="{{ route('transaction.done',['transaction' => $transaction->id])}}" onclick="return confirm('Konfirmasi terima barang? dengan ini maka uang pembayaran akan diteruskan ke penjual')" class="btn btnBlue btnanimation"><i class="fa fa-check fa-fw"></i> Terima barang</a>
                                </div>
                            @endif
                        </div>
                    @endif
                    <h3>{{ $transaction->seller->name }}</h3>
                    <div class="items">
                        @foreach($transaction->item as $item)
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

                    @if(empty($transaction->getOriginal('cutoffPrice')))
                        <div class="totalPrice">{{ $transaction->totalPrice }}</div>
                    @else
                        <div class="totalPrice cut">{{ $transaction->totalPrice }}</div>
                        <div class="cutPrice">-{{ 'Rp'.number_format($transaction->cutoffPrice,0,',','.') }}</div>
                        <div class="totalPrice">{{ $transaction->totalPriceCut() }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
