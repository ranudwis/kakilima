<div id="navbar">
    <div>
        <div>
            <a href="{{ route('home') }}">
                <img src="{{ url('/images/logo.png') }}" id="logo">
            </a>
        </div>
        <div class="link">
            <a style="color: black" href="{{ route('home') }}">Kategori</a>
        </div>
    </div>
    <div class="link">
        <div class="iconcounter">
            <img src="{{ url('images/cart.png') }}">
            <div class="counter">1</div>
        </div>
        @if(Auth::check())
            <a href="{{ route('logout') }}" class="back">Keluar</a>
        @else
            <a href="{{ route('login') }}">Masuk</a>
            <a href="{{ route('register') }}" class="back">Daftar</a>
        @endif
    </div>
</div>