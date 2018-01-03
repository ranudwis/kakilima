<div class="offer">
    <div id="offerWrapper">
        <div>
            <img src="{{ url('/images/logoSmall.png') }}">
            <span>Aman</span>
            <span>Jaminan uang kembali untuk Anda</span>
        </div>
        <div>
            <img src="{{ url('/images/logoSmall.png') }}">
            <span>Mudah</span>
            <span>Belanja dengan mudah tanpa beban</span>
        </div>
        <div>
            <img src="{{ url('/images/logoSmall.png') }}">
            <span>Layanan Pelanggan</span>
            <span>Layanan pelanggan 24 jam untuk kenyamanan Anda</span>
        </div>
        <div>
            <img src="{{ url('/images/logoSmall.png') }}">
            <span>Gratis Ongkir</span>
            <span>Gratis ongkos kirim selama masa promosi</span>
        </div>
        <div>
            <img src="{{ url('/images/logoSmall.png') }}">
            <span>Akses Dimana Saja</span>
            <span>Kemudahan akses dari mana saja dengan tampilan mobile</span>
        </div>
    </div>
    <div id="linkWrapper">
        <div>
            <h3>Berlangganan</h3>
            <form method="post" action="">
                {{ csrf_field() }}
                <input type="text" name="email" id="subscribe" placeholder="Masukkan surel Anda">
                <input type="submit" id="subscribeButton" value="Berlangganan">
            </form>
        </div>
        <div>
            <h3>Layanan Pelanggan</h3>
            <a href="">Hubungi kami</a>
            <a href="">FAQ</a>
            <a href="">Dasar pengetahuan</a>
        </div>
        <div>
            <h3>Temukan kami</h3>
        </div>
    </div>
</div>
