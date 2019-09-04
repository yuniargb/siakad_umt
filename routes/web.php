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

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/loginpost', 'AuthController@loginpost');
Route::get('/logout', 'AuthController@logout');

Route::group(['middleware' => ['auth', 'checkRole:1,2']], function () {
    Route::get('/', 'DashboardController@dashboard');
    Route::get('/user', 'DashboardController@user');
    // pembayaran
    Route::get('/pembayaran', 'PembayaranController@index');
    Route::post('/pembayaran', 'PembayaranController@store');
});

Route::group(['middleware' => ['auth', 'checkRole:1']], function () {
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

});
