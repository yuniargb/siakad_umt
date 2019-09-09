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

// Route::get('/', 'DashboardController@dashboard');

// Route::resource('siswa', 'SiswaController');
// Route::get('/siswa', 'SiswaController@index');
// Route::post('/siswa', 'SiswaController@store');
// Route::get('/siswa/{id}/edit', 'SiswaController@edit');
// Route::put('/siswa/{id}/update', 'SiswaController@update');

// Kelas;
// Route::get('/kelas', 'KelasController@index');
// Route::post('/kelas', 'KelasController@store');
// Route::get('/kelas/{id}/edit', 'KelasController@edit');
// Route::put('/kelas/{id}/update', 'KelasController@update');

// spp
// Route::get('/spp', 'AngkatanController@index');
// Route::post('/spp', 'AngkatanController@store');
// Route::get('/spp/{id}/edit', 'AngkatanController@edit');
// Route::put('/spp/{id}/update', 'AngkatanController@update');

// pembayaran
// Route::get('/pembayaran', 'PembayaranController@index');
// Route::post('/pembayaran', 'PembayaranController@store');

// pembayaran Admin
// Route::get('/accpembayaran', 'AccPembayaranController@index');
// Route::get('/accpembayaran/{id}/{tipe}', 'AccPembayaranController@update');
// Route::get('/cetakpembayaran/{id}', 'AccPembayaranController@cetak');

// laporan bulan
// Route::get('/laporanbulan', 'LaporanController@bulan');
// Route::post('/cetaklaporanbulan', 'LaporanController@cetakbulan');
// Route::post('/cetaklaporanbulan', 'LaporanController@cetakbulan');
// Route::post('/pembayaran', 'PembayaranController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/loginpost', 'AuthController@loginpost');
Route::get('/logout', 'AuthController@logout');

Route::get('/cetakpembayaran/{id}', 'AccPembayaranController@cetak');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@dashboard');
    Route::get('/user', 'DashboardController@user');
    // pembayaran
    Route::get('/pembayaran', 'PembayaranController@index');
    Route::post('/pembayaran', 'PembayaranController@store');
});

Route::group(['middleware' => 'auth'], function () {
    // Route::resource('siswa', 'SiswaController');
    Route::get('/siswa', 'SiswaController@index');
    Route::post('/siswa', 'SiswaController@store');
    Route::get('/siswa/{id}/edit', 'SiswaController@edit');
    Route::put('/siswa/{id}/update', 'SiswaController@update');

    // Kelas;
    Route::get('/kelas', 'KelasController@index');
    Route::post('/kelas', 'KelasController@store');
    Route::get('/kelas/{id}/edit', 'KelasController@edit');
    Route::put('/kelas/{id}/update', 'KelasController@update');

    // spp
    Route::get('/spp', 'AngkatanController@index');
    Route::post('/spp', 'AngkatanController@store');
    Route::get('/spp/{id}/edit', 'AngkatanController@edit');
    Route::put('/spp/{id}/update', 'AngkatanController@update');

    // pembayaran Admin
    Route::get('/accpembayaran', 'AccPembayaranController@index');
    Route::get('/accpembayaran/{id}/{tipe}', 'AccPembayaranController@update');

    // laporan bulan
    Route::get('/laporanbulan', 'LaporanController@bulan');
    Route::post('/cetaklaporanbulan', 'LaporanController@cetakbulan');
    // Route::post('/cetaklaporanbulan', 'LaporanController@cetakbulan');
    // Route::post('/pembayaran', 'PembayaranController@store');

    // admin
    Route::get('/admin', 'AdminController@index');
    Route::post('/admin', 'AdminController@store');

    // user
    Route::get('/user/{id}/edit', 'UserController@edit');
    Route::put('/user/{id}/update', 'UserController@update');
    Route::get('/user/siswa/{id}/edit', 'UserController@editusersiswa');
});
