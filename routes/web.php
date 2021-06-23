<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('item', 'BarangController')->middleware('auth');

Route::resource('user', 'UserController')->middleware('auth');

Route::resource('sampah', 'SampahController')->middleware('auth');

Route::resource('transaksi', 'TransaksiController')->middleware('auth');

Route::resource('pembelian', 'PembelianController')->middleware('auth');

Route::resource('penjualan', 'PenjualanController')->middleware('auth');

Route::resource('supplier', 'SupplierController')->middleware('auth');
