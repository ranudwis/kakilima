<h2>Ringkasan</h2>
<div class="flexWrapper dashboardWrapper">
    <div class="dashboardCard">
        <div class="icon"><i class="fa fa-users fa-fw"></i></div>
        <div class="text">Pengguna<br><b>{{ $overview->user }}</b></div>
    </div>
    <div class="dashboardCard">
        <div class="icon"><i class="fa fa-circle-o fa-fw"></i></div>
        <div class="text">Kategori<br><b>{{ $overview->category }}</b></div>
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
        <div class="icon"><i class="fa fa-hourglass-half fa-fw"></i></div>
        <div class="text">Menunggu konfirmasi<br><b>{{ $overview->waitTransaction }}</b></div>
    </div>
    <div class="dashboardCard">
        <div class="icon"><i class="fa fa-check fa-fw"></i></div>
        <div class="text">Transaksi sukses<br><b>{{ $overview->doneTransaction }}</b></div>
    </div>
</div>
