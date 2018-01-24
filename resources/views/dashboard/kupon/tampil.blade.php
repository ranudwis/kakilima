<h2>Tampil Kupon</h2>
<div class="table">
    <table>
        <tr>
            <th>Kode</th>
            <th>Minimal</th>
            <th>Potongan</th>
            <th>Maksimal potongan</th>
            <th>Digunakan</th>
            <th>Aksi</th>
        </tr>
        @foreach($data as $dat)
            <tr>
                <td>{{ $dat->code }}</td>
                <td>{{ $dat->minimum }}</td>
                <td>{{ $dat->discount }}%</td>
                <td>{{ $dat->maximum }}</td>
                <td>{{ $dat->used }}</td>
                <td><a class="btn btnred btnanimation" href="{{ route('dashboard.coupon.destroy',[$dat->id]) }}" onclick="return confirm('Hapus kupon?')"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
</table>
