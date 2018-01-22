<h2>Slider</h2>
<a href="{{ route('board',['board' => 'pengaturan','subboard' => 'tambahslider']) }}" class="btn btnBlue btnanimation btnSpace btnPadding"><i class="fa fa-plus fa-lg"></i></a>
<div class="table sliderTable">
    <table>
        <tr>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        @foreach($data as $dat)
            <tr>
                <td><img src="{{ url(Storage::url($dat->filename)) }}"></td>
                <td><a href="{{ route('dashboard.slider.destroy',['slider' => $dat->id]) }}" class="btn btnRed btnanimation" onclick="return confirm('Yakin akan hapus slider?')"><i class="fa fa-trash"></i></a></td>
            </tr>
        @endforeach
</div>
