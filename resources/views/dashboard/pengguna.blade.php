<h2>Pengguna</h2>
<div class="table">
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Item</th>
            <th>Pembelian</th>
            <th>Penjualan</th>
            <th>Aksi</th>
        </tr>
        @foreach($data as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->items->count() }}</td>
                <td>{{ $user->invoice->count() }}</td>
                <td>{{ $user->disposal->count() }}</td>
                <td>
                    <a href="{{ route('dashboard.user.destroy',['user' => $user->id]) }}" class="btn btnRed btnanimation" onclick="return confirm('Hapus pengguna?')">
                        <i class="fa fa-trash fa-fw"></i>
                    </a>
                    @if($user->banned)
                        <a href="{{ route('dashboard.user.unban',['user' => $user->id]) }}" class="btn btnGreen btnanimation" onclick="return confirm('Buka blokir penguna?')">
                            <i class="fa fa-check fa-fw"></i>
                        </a>
                    @else
                        <a href="{{ route('dashboard.user.ban',['user' => $user->id]) }}" class="btn btnRed btnanimation" onclick="return confirm('Blokir penguna?')">
                            <i class="fa fa-ban fa-fw"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>
