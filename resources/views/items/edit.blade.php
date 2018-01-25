@extends('layouts.master')

@section('content')
<div class="section linesection">
    <h2>Edit Barang</h2>
    <div class="flexWrapper">
        <form method="post" class="regularform" action="{{ route('item.update',['item' => $item->slug]) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            <div>
                <div>Nama Barang</div>
                <div><input type="text" name="name" autofocus value="{{ $item->name }}"></div>
            </div>
            <div>
                <div>Kategori</div>
                <div><select name="category">
                    <option value="0" @if($item->category_id == 0) selected @endif>Pilih kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($item->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <div>Stok</div>
            <div><input type="text" name="stock" value="{{ $item->stock }}"></div>
        </div>
        <div>
            <div>Harga</div>
            <div><span class="inputlabel">Rp.</span><input type="text" name="price" value="{{ $item->getOriginal('price') }}"></div>
        </div>
        <div>
            <div>Kondisi</div>
            <div>
                <input id="new" type="radio" name="condition" value="new" @if($item->getOriginal('condition') == 1) checked @endif>
                <label for="new">Baru</label>
                <input id="used" type="radio" name="condition" value="used" @if($item->getOriginal('condition') == 0) checked @endif>
                <label for="used">Bekas</label>
            </div>
        </div>
        <div>
            <div>Gambar</div>
            <div class="imageUploadContainer">
                <div>
                    Ganti gambar
                </div>
                <div>
                    <input type="file" name="photo[]" id="imageUpload" accept="images/*">
                </div>
                <span class="addImageUpload">+Tambah</span>
            </div>
        </div>
        <div>
            <div>Deskripsi Barang</div>
            <div><textarea name="description">{{ $item->description }}</textarea></div>
        </div>
        <div>
            <inputt type="submit" value="Simpan">
        </div>
    </form>
</div>
</div>
@endsection
