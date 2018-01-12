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
        Route::get('/tambah','ItemController@create')->name('item.add');
        Route::get('/kelola','ItemController@manage')->name('item.manage');
        Route::post('/tambah','ItemController@store');
        Route::get('/edit/{item}','ItemController@edit')->name('item.edit');
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

    Route::prefix('/invoice')->group(function(){
        Route::get('/{invoice}', 'InvoiceController@show')->name('invoice.show');
    });

    Route::prefix('/ulasan')->group(function(){
        Route::post('/{item}','ReviewController@store')->name('review.add');
    });

    //TODO

    Route::get('/backend/tambahkeranjang', 'CartController@store')->name('addcart');
    Route::get('/backend/keranjang', 'CartController@index')->name('viewcart');
    Route::post('/coupon', 'CouponController@use')->name('usecoupon');

    Route::get('/backend/penjualan', 'TransactionController@disposal')->name('disposal');
    Route::get('/backend/penjualan/{disposal}', 'TransactionController@showDisposal')->name('showdisposal');
    Route::post('/backend/penjualan/{disposal}/konfirmasi', 'TransactionController@confirmDisposal')->name('confirmdisposal');
    Route::get('/backend/penjualan/{disposal}/tolak', 'TransactionController@rejectDisposal')->name('rejectdisposal');
    Route::get('/backend/pembelian', 'TransactionController@purchase')->name('purchase');
    Route::get('/backend/pembelian/{purchase}', 'TransactionController@showPurchase')->name('showpurchase');
    Route::get('/backend/pembelian/{purchase}/konfirmasi', 'TransactionController@confirmPurchase')->name('confirmpurchase');
    Route::get('/invoice', 'InvoiceController@index')->name('invoice');
    Route::get('/invoice/add', 'InvoiceController@add')->name('addinvoice');
    Route::get('/invoice/{invoice}/bayar', 'InvoiceController@pay')->name('pay');
    Route::get('/invoice/{invoice}/konfirmasi', 'DashboardController@confirminvoice')->name('confirminvoice');
    Route::get('/invoice/{invoice}/tolak', 'DashboardController@rejectinvoice')->name('rejectinvoice');

    Route::get('/notifikasi', 'NotificationController@index')->name('notification');
    Route::get('/notifikasi/{notification}', 'NotificationController@show')->name('shownotification');
});

Route::middleware(['auth','admin'])->group(function(){
    Route::post('/dashboard/coupon', 'DashboardController@addCoupon')->name('addcoupon');
    Route::post('/dashboard/pengaturan/slider','DashboardController@storeSlider')->name('dashboard.slider.store');
    Route::get('/dashboard/pengaturan/slider/{slider}/hapus','DashboardController@destroySlider')->name('dashboard.slider.destroy');
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::get('/dashboard/{board}/{subboard?}/{param?}','DashboardController@dashboard')->name('board');
});


Route::get('/kategori', 'CategoryController@index')->name('category');
Route::post('/kategori', 'DashboardController@addCategory');

Route::post('/cari', 'ItemController@search')->name('search');



Route::get('/backend/produk', 'BackendController@itemIndex')->name('items');
Route::get('/backend/produk/tambah', 'BackendController@itemCreate');//->name('additem');
Route::get('/barang/{item}', 'ItemController@show')->name('item.show');

Route::get('/category/{category}','ItemController@showByCategory')->name('showcategory');

Route::post('/addfavorites', 'FavoriteController@store');
