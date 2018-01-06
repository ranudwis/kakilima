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

Route::get('/masuk', 'SessionController@create')->name('login');
Route::post('/masuk', 'SessionController@store');
Route::get('/keluar', 'SessionController@destroy')->name('logout');
Route::get('/daftar', 'RegistrationController@create')->name('register');
Route::post('/daftar', 'RegistrationController@store');

Route::get('/kategori', 'CategoryController@index')->name('category');
Route::post('/kategori', 'DashboardController@addCategory');
Route::post('/dashboard/coupon', 'DashboardController@addCoupon')->name('addcoupon');


Route::get('/user','UserController@index')->name('user');
Route::get('/user/photo','UserController@editPhoto')->name('user.editPhoto');
Route::post('/user/photo','UserController@updatePhoto');
Route::get('/user/profil','UserController@editProfile')->name('user.editProfile');
Route::post('/user/profil','UserController@updateProfile');
Route::post('/cari', 'ItemController@search')->name('search');

Route::get('/produk/tambah','ItemController@create')->name('additem');
Route::post('/produk/tambah','ItemController@store');

Route::get('/dashboard','DashboardController@index')->name('dashboard');
Route::get('/dashboard/{board}/{subboard?}','DashboardController@dashboard')->name('board');

Route::get('/backend/produk', 'BackendController@itemIndex')->name('items');
Route::get('/backend/produk/tambah', 'BackendController@itemCreate');//->name('additem');
Route::post('/backend/produk/tambah', 'BackendController@itemStore');
Route::get('/produk/{item}', 'ItemController@show')->name('showitem');

Route::get('/category/{category}','ItemController@showByCategory')->name('showcategory');

Route::post('/addfavorites', 'FavoriteController@store');

Route::get('/backend/keranjang', 'CartController@index')->name('viewcart');
Route::get('/backend/tambahkeranjang', 'CartController@store')->name('addcart');

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
Route::get('/invoice/{invoice}', 'InvoiceController@show')->name('showinvoice');
Route::get('/invoice/{invoice}/bayar', 'InvoiceController@pay')->name('pay');
Route::get('/invoice/{invoice}/konfirmasi', 'DashboardController@confirminvoice')->name('confirminvoice');
Route::get('/invoice/{invoice}/tolak', 'DashboardController@rejectinvoice')->name('rejectinvoice');

Route::get('/notifikasi', 'NotificationController@index')->name('notification');
Route::get('/notifikasi/{notification}', 'NotificationController@show')->name('shownotification');
