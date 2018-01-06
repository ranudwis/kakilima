<h2>Tambah slider</h2>
<form method="post" enctype="multipart/form-data" action="{{ route('dashboard.slider.store') }}" class="regularform halfForm">
    {{ csrf_field() }}
    <div>
        <div>Upload gambar</div>
        <div>
            <input type="file" name="photo">
        </div>
    </div>
    <div>
        <input type="submit" value="Simpan">
    </div>
</form>
