<h2>Transaksi</h2>
<div class="table">
    <table>
        <tr>
            <th>Invoice</th>
            <th>Pembayaran</th>
            <th>Pengguna</th>
            <th>Dibayar</th>
            <th>Aksi</th>
        </tr>
        @foreach($data as $invoice)
            <tr>
                <td>{{ $invoice->invoiceId }}</td>
                <td>{{ $invoice->payPrice }}</td>
                <td>{{ $invoice->user->email }}</td>
                <td>{{ $invoice->updated_at }}</td>
                <td>
                    <a href="{{ route('confirminvoice',['invoice' => $invoice->invoiceId]) }}" class="btn btnblue btnanimation">Konfirmasi</a>
                    <a href="{{ route('rejectinvoice',['invoice' => $invoice->invoiceId]) }}" class="btn btnred btnanimation">Tolak</a>
                </td>
            </tr>
        @endforeach
    </table>
</div>