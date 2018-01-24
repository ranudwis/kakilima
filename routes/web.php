<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('guest')->group(function(){
    Route::get('/masuk', 'SessionController@create')->name('login');
    Route::post('/masuk', 'SessionController@store');
    Route::get('/daftar', 'RegistrationController@create')->name('register');
    Route::post('/daftar', 'RegistrationController@store');
});

Route::prefix('/b')->group(function(){
    Route::get('/','ItemController@index')->name('item');
});

Route::middleware('auth')->group(function(){
    Route::get('/keluar', 'SessionController@destroy')->name('logout');

    Route::prefix('/user')->group(function(){
        Route::get('','UserController@index')->name('user');
        Route::get('/photo','UserController@editPhoto')->name('user.editPhoto');
        Route::post('/photo','UserController@updatePhoto');
        Route::get('/profil','UserController@editProfile')->name('user.editProfile');
        Route::post('/profil','UserController@updateProfile');
    });

    Route::prefix('/barang')->group(function(){
        Route::get('/','ItemController@manage')->name('item.manage');
        Route::get('/tambah','ItemController@create')->name('item.add');
        Route::post('/tambah','ItemController@store');
        Route::get('/edit/{item}','ItemController@edit')->name('item.edit');
        Route::patch('/{item}','ItemController@update')->name('item.update');
        Route::get('/hapus/{item}','ItemController@destroy')->name('item.destroy');
    });

    Route::prefix('/favorit')->group(function(){
        Route::get('/','UserController@showFavorite')->name('favorite');
        Route::get('/add/{item}','ItemController@addToFavorite')->name('favorite.add');
        Route::get('/remove/{item}','ItemController@removeFromFavorite')->name('favorite.remove');
    });

    Route::prefix('/keranjang')->group(function(){
        Route::get('/','UserController@showCart')->name('cart');
        Route::get('/edit/{item}','CartController@edit')->name('cart.edit');
        Route::post('/edit/{item}','CartController@store');
        Route::get('/tambah/{item?}/{quantity?}','ItemController@addToCart')->name('cart.add');
        Route::get('/hapus/{item}','ItemController@removeFromCart')->name('cart.remove');
        Route::get('/proses/{user}','CartController@process')->name('cart.process');
        Route::get('/prosessemua','CartController@processAll')->name('cart.processAll');
    });

    Route::prefix('/pembelian')->group(function(){
        Route::get('/', 'InvoiceController@index')->name('invoice');
        Route::post('/{invoice}/kupon','InvoiceController@useCoupon')->name('invoice.usecoupon');
        Route::get('/{invoice}', 'InvoiceController@show')->name('invoice.show');
        Route::get('/bayar/{invoice}','InvoiceController@pay')->name('invoice.pay');
        Route::post('/pembayaran/{invoice}','InvoiceController@uploadPayment')->name('invoice.uploadPayment');
        Route::get('/terima/{transaction}','TransactionController@done')->name('transaction.done');
    });

    Route::prefix('/pemjualan')->group(function(){
        Route::get('/','TransactionController@index')->name('disposal');
        Route::get('/{disposal}', 'TransactionController@show')->name('disposal.show');
        Route::get('/{disposal}/tolak', 'TransactionController@reject')->name('disposal.reject');
        Route::post('/{disposal}/kirim','TransactionController@send')->name('disposal.send');
    // Route::get('/backend/penjualan', 'TransactionController@disposal')->name('disposal');
    // Route::post('/backend/penjualan/{disposal}/konfirmasi', 'TransactionController@confirmDisposal')->name('confirmdisposal');
    // Route::get('/backend/penjualan/{disposal}/tolak', 'TransactionController@rejectDisposal')->name('rejectdisposal');
    });

    Route::prefix('/ulasan')->group(function(){
        Route::post('/{item}','ReviewController@store')->name('review.add');
    });

    Route::get('/notifikasi', 'NotificationController@index')->name('notification');
    Route::get('/notifikasi/tandaibaca', 'NotificationController@read')->name('notification.read');
    Route::get('/notifikasi/{notification}', 'NotificationController@show')->name('notification.show');


    //TODO

    Route::get('/backend/tambahkeranjang', 'CartController@store')->name('addcart');
    Route::get('/backend/keranjang', 'CartController@index')->name('viewcart');
    Route::post('/coupon', 'CouponController@use')->name('usecoupon');

    Route::get('/backend/pembelian', 'TransactionController@purchase')->name('purchase');
    Route::get('/backend/pembelian/{purchase}', 'TransactionController@showPurchase')->name('showpurchase');
    Route::get('/backend/pembelian/{purchase}/konfirmasi', 'TransactionController@confirmPurchase')->name('confirmpurchase');
    Route::get('/invoice/add', 'InvoiceController@add')->name('addinvoice');
    Route::get('/invoice/{invoice}/bayar', 'InvoiceController@pay')->name('pay');

});

Route::middleware(['auth','admin'])->group(function(){
    Route::post('/dashboard/coupon', 'DashboardController@addCoupon')->name('addcoupon');
    Route::post('/dashboard/pengaturan/slider','DashboardController@storeSlider')->name('dashboard.slider.store');
    Route::post('/dashboard/pengaturan/rekening','DashboardController@storePayment')->name('dashboard.payment.store');
    Route::get('/dashboard/pengaturan/slider/{slider}/hapus','DashboardController@destroySlider')->name('dashboard.slider.destroy');
    Route::get('/dashboard/kategori/{category}/hapus','DashboardController@destroyCategory')->name('dashboard.category.destroy');
    Route::get('/dashboard/kupon/{coupon}/hapus','DashboardController@destroyCoupon')->name('dashboard.coupon.destroy');
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::get('/dashboard/{board}/{subboard?}/{param?}','DashboardController@dashboard')->name('board');

    Route::get('/invoice/{invoice}/konfirmasi', 'InvoiceController@confirm')->name('invoice.confirm');
    Route::get('/invoice/{invoice}/tolak', 'InvoiceController@reject')->name('invoice.reject');
});


Route::get('/kategori', 'CategoryController@index')->name('category');
Route::post('/kategori', 'DashboardController@addCategory');

Route::post('/cari', 'ItemController@search')->name('search');



Route::get('/backend/produk', 'BackendController@itemIndex')->name('items');
Route::get('/backend/produk/tambah', 'BackendController@itemCreate');//->name('additem');
Route::get('/barang/{item}', 'ItemController@show')->name('item.show');

Route::get('/category/{category}','ItemController@showByCategory')->name('showcategory');

Route::post('/addfavorites', 'FavoriteController@store');
