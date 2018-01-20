<h2>Transaksi</h2>
<div class="table">
    <table>
        <tr>
            <th>Invoice</th>
            <th>Pembayaran</th>
            <th>Bukti pembayaran</th>
            <th>Pengguna</th>
            <th>Dibayar</th>
            <th>Aksi</th>
        </tr>
        @foreach($data as $invoice)
            <tr>
                <td>{{ $invoice->invoiceId }}</td>
                <td>{{ $invoice->payPrice }}</td>
                <td><a href="{{ url(Storage::url($invoice->paymentInfo)) }}" target="_blank" class="btn btnBlue"><i class="fa fa-external-link fa-fw"></i></a></td>
                <td>{{ $invoice->user->email }}</td>
                <td>{{ $invoice->updated_at }}</td>
                <td>
                    <a href="{{ route('invoice.confirm',['invoice' => $invoice->invoiceId]) }}" onclick="return confirm('Terima transaksi?')" class="btn btnblue btnanimation"><i class="fa fa-check fa-fw"></i> Konfirmasi</a>
                    <a href="{{ route('invoice.reject',['invoice' => $invoice->invoiceId]) }}" onclick="return confirm('Tolak transaksi?')" class="btn btnred btnanimation"><i class="fa fa-times fa-fw"></i> Tolak</a>
                </td>
            </tr>
        @endforeach
    </table>
</div>
