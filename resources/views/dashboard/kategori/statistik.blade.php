<h2>Kategori</h2>
<div class="table">
    <table>
        <tr>
            <th>Nama</th>
            <th>Jumlah Barang</th>
            <th>Aksi</th>
        </tr>
        @foreach($data as $dat)
            <tr>
                <td>{{ $dat->name }}</td>
                <td>{{ $dat->calculateTotal() }}</td>
                <td><a class="btn btnred btnanimation" href="{{ route('dashboard.category.destroy',[$dat->id]) }}" onclick="return confirm('Hapus kategori?')"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
</table>
