@extends('layouts.master')

@section('content')
<div class="section linesection">
<h2>Tambah Barang</h2>
<div class="flexWrapper">
<form method="post" class="regularform" action="{{ route('additem') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <div>Nama Barang</div>
        <div><input type="text" name="name" autofocus value="{{ old('name') }}"></div>
    </div>
    <div>
        <div>Kategori</div>
        <div><select name="category" value="{{ old('category') }}">
                <option value="0" selected>Pilih kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <div>Stok</div>
        <div><input type="text" name="stock" value="{{ old('stock') }}"></div>
    </div>
    <div>
        <div>Harga</div>
        <div><span class="inputlabel">Rp.</span><input type="text" name="price" value="{{ old('price') }}"></div>
    </div>
    <div>
        <div>Kondisi</div>
        <div>
            <input id="new" type="radio" name="condition" value="new" checked>
            <label for="new">Baru</label>
            <input id="used" type="radio" name="condition" value="used">
            <label for="used">Bekas</label>
        </div>
    </div>
    <div>
        <div>Gambar</div>
        <div class="imageUploadContainer">
            <div>
                <input type="file" name="photo[]" id="imageUpload" accept="images/*">
            </div>
            <span class="addImageUpload">+Tambah</span>
        </div>
    </div>
    <div>
        <div>Deskripsi Barang</div>
        <div><textarea name="description">{{ old('description') }}</textarea></div>
    </div>
    <div>
        <button class="btnanim btnanimation" type="submit">Simpan</button>
    </div>
</form>
<!-- <div class="largeImageUpload">
    <div>
        <span class="plus">+</span>
        <div>Unggah gambar</div>
    </div>
</div> -->
</div>
</div>
@endsection