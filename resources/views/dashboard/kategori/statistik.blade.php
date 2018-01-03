<h2>Kategori</h2>
<div class="table">
    <table>
        <tr>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
        @foreach($data as $dat)
            <tr>
                <td>{{ $dat->name }}</td>
                <td><a class="btn btnblue btnanimation" href="">Edit</a>
                    <a class="btn btnred btnanimation" href="">Hapus</a>
                </td>
            </tr>
        @endforeach
    </table>
</table>
