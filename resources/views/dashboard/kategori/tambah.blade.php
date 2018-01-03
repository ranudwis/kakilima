<h2>Tambah Kategori</h2>
<form class="regularform fullform" action="{{ route('category') }}" method="post">
    {{ csrf_field() }}
    <div>
        <div>Nama</div>
        <div><input type="text" name="name" autofocus value="{{ old('name') }}"></div>
    </div>
    <div>
        <div></div>
        <div><input type="submit" value="Simpan" class="smallbutton"></div>
    </div>
</form>