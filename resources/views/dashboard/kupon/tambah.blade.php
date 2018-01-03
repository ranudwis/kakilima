<h2>Tambah Kupon</h2>
<form class="regularform fullform" action="{{ route('addcoupon') }}" method="post">
    {{ csrf_field() }}
    <div>
        <div>Kode Kupon</div>
        <div><input type="text" name="code" autofocus value="{{ old('code') }}"></div>
    </div>
    <div>
        <div>Minimum pembelian</div>
        <div><span class="inputLabel">Rp.</span><input type="text" name="minimum" value="{{ old('minimum') }}"></div>
    </div>
    <div>
        <div>Diskon</div>
        <div><input type="text" name="discount" value="{{ old('discount') }}" placeholder="dalam %"></div>
    </div>
    <div>
        <div>Maksimal potongan</div>
        <div><span class="inputLabel">Rp.</span><input type="text" name="maximum" value="{{ old('maximum') }}"></div>
    </div>
    <div>
        <div></div>
        <div><input type="submit" value="Simpan" class="smallbutton"></div>
    </div>
</form>