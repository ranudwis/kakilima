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
        <div id="notificationSection" class="dropdownSection">
            <a href="{{ route('notification') }}" id="notifications">
                <i class="fa fa-bell fa-fw navicon"></i>
                <div class="counter">
                    {{ is_numeric($notification_count) ? $notification_count : 0 }}
                </div>
            </a>
            <div class="dropdownList">
                @if($notification_navbar->isEmpty())
                    <div class="dropdownListEmpty">Kamu belum punya notifikasi</div>
                @else
                    @foreach($notification_navbar as $notif)
                        <div>
                            <a href="{{ route('notification.show',['notification' => $notif->id]) }}">{{ $notif->text }}</a>
                        </div>
                    @endforeach
                    <a href="{{ route('notification') }}">Lihat semua</a>
                @endif
            </div>
        </div>
        <div id="cartSection" class="dropdownSection">
            <a href="{{ route('viewcart') }}" id="cart">
                <i class="fa fa-shopping-cart fa-fw navicon"></i>
                <!-- <img src="{{ url('/images/cart.png') }}"> -->
                <div id="cartCounter" class="counter">
                    {{ is_numeric($cart_count) ? $cart_count : 0 }}
                </div>
            </a>
            <div id="cartList" class="dropdownList">
                @if($carts_navbar->isEmpty())
                    <div class="dropdownListEmpty">Kamu belum punya barang apapun di keranjang</div>
                @else
                    @foreach($carts_navbar as $cart)
                        <div class="cartItem">
                            <img src="{{ url(Storage::url($cart->photo[0])) }}">
                            <div class="information">
                                <span class="name"><a href="{{ route('item.show',['item' => $cart->slug])}}">{{ $cart->name }}</a></span>
                                <span class="price">{{ $cart->price }}</span>
                                <span class="quantity">{{ $cart->pivot->quantity }} Barang</span>
                            </div>
                            <a href="{{ route('cart.remove',['item' => $cart->id]) }}" class="removeFromCart"><i class="fa fa-times"></i></a>
                        </div>
                    @endforeach
                    <a href="{{ route('cart') }}">Lihat semua</a>
                @endif
            </div>
        </div>
        @endunless
        @if(Auth::check())
            <div id="userButton" class="dropdownSection">
                <!-- <a href="{{ route('user') }}"><img src="{{ url('/images/user'.$white.'.png') }}"></a> -->
                <a href="{{ route('user') }}"><i class="fa fa-user navicon"></i>{{ explode(" ",auth()->user()->name)[0] }}</a>
                <div class="dropdownList" id="userList">
                    @if($admin)
                        <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i>Dashbor</a>
                    @else
                        <a href="{{ route('favorite') }}"><i class="fa fa-heart fa-fw"></i> Barang favorit</a>
                        <a href="{{ route('item.add') }}"><i class="fa fa-plus fa-fw"></i> Jual barang</a>
                        <a href="{{ route('item.manage') }}"><i class="fa fa-tasks fa-fw"></i> Kelola barang</a>
                        <a href="{{ route('invoice') }}"><i class="fa fa-credit-card fa-fw"></i> Pembelian</a>
                        <a href="{{ route('disposal') }}"><i class="fa fa-credit-card-alt fa-fw"></i> Penjualan</a>
                        <a href="{{ route('user') }}"><i class="fa fa-cog fa-fw"></i> Informasi akun</a>
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
