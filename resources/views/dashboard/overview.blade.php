<h2>Ringkasan</h2>
<div class="flexWrapper dashboardWrapper">
    <div class="dashboardCard">
        <div class="icon"><i class="fa fa-users fa-fw"></i></div>
        <div class="text">Pengguna<br><b>{{ $overview->user }}</b></div>
    </div>
    <div class="dashboardCard">
        <div class="icon"><i class="fa fa-cubes fa-fw"></i></div>
        <div class="text">Produk<br><b>{{ $overview->item }}</b></div>
    </div>
    <div class="dashboardCard">
        <div class="icon"><i class="fa fa-shopping-cart fa-fw"></i></div>
        <div class="text">Transaksi<br><b>{{ $overview->transaction }}</b></div>
    </div>
    <div class="dashboardCard">
        <div class="icon"><i class="fa fa-clock-o fa-fw"></i></div>
        <div class="text">Uptime<br><b>{{ $overview->uptime }}</b></div>
    </div>
</div>
