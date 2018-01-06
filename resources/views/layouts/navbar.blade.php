<div id="navbar" @if($white) class="dashboard" @endif>
    <div>
        <a href="{{ route('home') }}" id="logo">
            <img src="{{ url('images/logo'.$white.'.png') }}">
        </a>
        @unless(request()->route()->getName() == "home" || $admin)
        <div id="categorySection" class="dropdownSection">
            <a href="{{ route('category') }}" id="category">Kategori</a>
            <!-- <ul id="categoryList">
                <li><a href="">Perlengkapan rumah tangga</a></li>
            </ul> -->
            <div id="categoryList" class="dropdownList">
                <a href="">Perlengkapan rumah tangga</a>
                <a href="">Komputer</a>
                <a href="">Baju</a>
                <a href="">Sepatu</a>
            </div>
        </div>
        @endunless
        @unless($admin)
        <div id="searchBar">
            <form method="post" action="{{ route('search') }}">
                <input type="text" name="query" placeholder="Aku mau beli...">
                <i class="fa fa-search"></i>
            </form>
        </div>
        @endunless
    </div>
    <div id="rightMenu">
        @unless($admin)
        <div id="cartSection" class="dropdownSection">
            <a href="{{ route('viewcart') }}" id="cart">
                <i class="fa fa-shopping-cart fa-fw navicon"></i>
                <!-- <img src="{{ url('/images/cart.png') }}"> -->
                <div id="cartCounter" class="counter">
                    99
                </div>
            </a>
            <div id="cartList" class="dropdownList">
                <a href="">aaa</a>
                <a href="">aaa</a>
            </div>
        </div>
        @endunless
        @if(Auth::check())
            <div id="userButton" class="dropdownSection">
                <!-- <a href="{{ route('user') }}"><img src="{{ url('/images/user'.$white.'.png') }}"></a> -->
                <a href="{{ route('user') }}"><i class="fa fa-user navicon"></i>{{ explode(" ",auth()->user()->name)[0] }}</a>
                <div class="dropdownList" id="userList">
                    @if($admin)
                        <a href="{{ route('dashboard') }}">Administrasi</a>
                    @else
                        <a href="{{ route('additem') }}"><i class="fa fa-plus fa-fw"></i>Jual barang</a>
                        <a href="{{ route('user') }}"><i class="fa fa-cog fa-fw"></i>Informasi akun</a>
                    @endif
                    <a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i>Keluar</a>
                </div>
            </div>
            <!-- <a href="{{ route('logout') }}" id="register">Keluar</a> -->
        @else
            <div id="loginButton">
                <a href="{{ route('login') }}" id="login">Masuk</a>
                <a href="{{ route('register') }}" id="register">Daftar</a>
            </div>
        @endif
    </div>
</div>
