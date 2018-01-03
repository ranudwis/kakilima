@extends('backend.layout')

@section('content')
<form method="post" action="{{ route('additem') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <div>Nama</div>
        <div><input type="text" name="name" value="{{ old('name') }}"></div>
    </div>
    <div>
        <div>Harga</div>
        <div><input type="text" name="price" value="{{ old('price') }}"></div>
    </div>
    <div>
        <div>Stok</div>
        <div><input type="text" name="stock" value="{{ old('stock') }}"></div>
    </div>
    <div>
        <div>Kondisi</div>
        <div><input id="inputNew" type="radio" name="condition" value="new" checked>
            <label for="inputNew">Baru</label>
            <input id="inputUsed" type="radio" name="condition" value="used">
            <label for="inputUsed">Bekas</label>
        </div>
    </div>
    <div>
        <div>Kategori</div>
        <div><select name="category">
                <option value="0">Pilih kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <div>Deskripsi</div>
        <div><textarea name="description">{{ old('description') }}</textarea>
        </div>
    </div>
    <div>
        <div>Gambar</div>
        <div><span id="addImage">tambah</span><input type="file" name="photo[]"></div>
    </div>
    <div>
        <input type="submit" value="simpan">
    </div>
</form>
@endsection