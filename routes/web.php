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
Route::get('/presensi', 'AbsensiController@rfid');


Route::get('/cetakpembayaran/{id}', 'AccPembayaranController@cetak');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@dashboard');
    Route::get('/user', 'DashboardController@user');
    // pembayaran
    Route::get('/historypembayaran', 'PembayaranController@index');
    Route::get('/tagihanbiaya', 'PembayaranController@tagihan');
    Route::get('/cetakpembayaran', 'PembayaranController@cetaksemua');
    Route::post('/pembayaran', 'PembayaranController@store');
});

Route::group(['middleware' => 'auth'], function () {
    // Siswa;
    Route::get('/siswa', 'SiswaController@index');
    Route::post('/siswa', 'SiswaController@store');
    Route::get('/siswa/{id}/edit', 'SiswaController@edit');
    Route::get('/siswa/{id}/bayar', 'SiswaController@getPembayaran');
    Route::put('/siswa/{id}/update', 'SiswaController@update');
    Route::get('/siswa/{id}/pass', 'SiswaController@pass');
    Route::get('/siswa/{id}/kelas', 'SiswaController@getSiswa');


    // Guru;
    Route::get('/guru', 'GuruController@index');
    Route::post('/guru', 'GuruController@store');
    Route::get('/guru/{id}/edit', 'GuruController@edit');
    Route::put('/guru/{id}/update', 'GuruController@update');
    Route::get('/guru/{id}/pass', 'GuruController@pass');

    // Kelas;
    Route::get('/kelas', 'KelasController@index');
    Route::post('/kelas', 'KelasController@store');
    Route::get('/kelas/{id}/edit', 'KelasController@edit');
    Route::put('/kelas/{id}/update', 'KelasController@update');

    // Mata Pelajaran;
    Route::get('/matapelajaran', 'MataPelajaranController@index');
    Route::post('/matapelajaran', 'MataPelajaranController@store');
    Route::get('/matapelajaran/{id}/edit', 'MataPelajaranController@edit');
    Route::put('/matapelajaran/{id}/update', 'MataPelajaranController@update');

    // Jadwal;
    Route::get('/jadwal', 'JadwalController@index');
    Route::post('/jadwal', 'JadwalController@store');
    Route::get('/jadwal/{id}/edit', 'JadwalController@edit');
    Route::put('/jadwal/{id}/update', 'JadwalController@update');

    // spp
    Route::get('/spp', 'AngkatanController@index');
    Route::post('/spp', 'AngkatanController@store');
    Route::get('/spp/{id}/edit', 'AngkatanController@edit');
    Route::put('/spp/{id}/update', 'AngkatanController@update');
    
    // rppdansilabus
    Route::get('/rppdansilabus', 'SilabusDanRppController@index');
    Route::post('/rppdansilabus', 'SilabusDanRppController@store');
    Route::get('/rppdansilabus/{id}/edit', 'SilabusDanRppController@edit');
    Route::put('/rppdansilabus/{id}/update', 'SilabusDanRppController@update');

     // nilai
    Route::get('/nilaiharian', 'NilaiController@harian');
    Route::get('/nilairaport', 'NilaiController@raport');
    Route::get('/nilaiujian', 'NilaiController@ujian');
    Route::post('/nilai', 'NilaiController@store');
    Route::get('/nilai/{id}/edit', 'NilaiController@edit');
    Route::put('/nilai/{id}/update', 'NilaiController@update');

    // tagihan
    Route::get('/daftartagihan', 'TagihanController@index');
    Route::post('/daftartagihan', 'TagihanController@store');
    Route::get('/detail_tagihan/{kelas_id}/{id}', 'TagihanController@detail');
    Route::get('/tagihanemail/{kelas_id}/{id}', 'TagihanController@email');


    // pembayaran Admin
    Route::get('/accpembayaran', 'AccPembayaranController@index');
    Route::get('/accpembayarantambahan', 'AccPembayaranController@tambahan');
    Route::get('/accpembayaranwajib', 'AccPembayaranController@wajib');
    Route::get('/accpembayaran/{id}/{tipe}/{tipebyr}', 'AccPembayaranController@update');
    Route::get('/detailpembayaran', 'AccPembayaranController@detail');

    // laporan bulan
    // Route::get('/laporanbulan', 'LaporanController@bulan');
    // Route::post('/cetaklaporanbulan', 'LaporanController@cetakbulan');
    Route::get('/laporanpembayaran', 'LaporanController@pembayaran');
    Route::post('/cetaklaporanpembayaran', 'LaporanController@cetakpembayaran');
    Route::get('/laporanpembayaranangkatan', 'LaporanController@pembayaranangkatan');
    Route::post('/cetaklaporanpembayaranangkatan', 'LaporanController@cetakpembayaranangkatan');
    Route::get('/laporanpenilaian', 'LaporanController@penilaian');
    Route::post('/cetaklaporanpenilaian', 'LaporanController@cetakpenilaian');
    Route::get('/laporanrds', 'LaporanController@rppdansilabus');
    Route::post('/cetaklaporanrds', 'LaporanController@cetakrppdansilabus');
    Route::get('/laporanjadwal', 'LaporanController@jadwal');
    Route::post('/cetaklaporanjadwal', 'LaporanController@cetakjadwal');
    Route::get('/laporanabsensiswa', 'LaporanController@absenSiswa');
    Route::post('/cetaklaporanabsensiswa', 'LaporanController@cetakAbsSiswa');
    Route::get('/laporanabsenguru', 'LaporanController@absenGuru');
    Route::post('/cetaklaporanabsenguru', 'LaporanController@cetakAbsGuru');
    Route::get('/laporanabsenstaf', 'LaporanController@absenStaf');
    Route::post('/cetaklaporanabsenstaf', 'LaporanController@cetakAbsStaf');
    // Route::post('/cetaklaporanbulan', 'LaporanController@cetakbulan');
    // Route::post('/pembayaran', 'PembayaranController@store');

    // admin
    Route::get('/admin', 'AdminController@index');
    Route::post('/admin', 'AdminController@store');
    Route::get('/admin/{id}/edit', 'AdminController@edit');
    Route::put('/admin/{id}/update', 'AdminController@update');
    
    // absensi
    Route::get('/presensime', 'AbsensiController@user');
    Route::get('/absensiguru', 'AbsensiController@guru');
    Route::get('/absensistaf', 'AbsensiController@staf');
    Route::get('/absensisiswa', 'AbsensiController@siswa');
    Route::get('/absensirfid', 'AbsensiController@rfid');
    Route::post('/tambahabsenm', 'AbsensiController@storeManual');
    Route::post('/tambahabsenrfid', 'AbsensiController@storeRFID');
    Route::put('/absensi/update', 'AbsensiController@update');
    Route::get('/absendetail/{id}/guru', 'AbsensiController@detailGuru');
    Route::get('/absendetail/{id}/staf', 'AbsensiController@detailStaf');
    Route::get('/absendetail/{id}/siswa', 'AbsensiController@detailSiswa');

    // user
    Route::get('/user/{id}/edit', 'UserController@edit');
    Route::put('/user/{id}/update', 'UserController@update');
    Route::get('/user/siswa/{id}/edit', 'UserController@editusersiswa');
    
    // logo
    Route::get('/logo', 'LogoController@index');
    Route::put('/logo/update', 'LogoController@update');

    // tipe
    Route::get('/tipepembayaran', 'TipePembayaranController@index');
    Route::post('/tipepembayaran', 'TipePembayaranController@store');
    Route::get('/tipepembayaran/{id}/edit', 'TipePembayaranController@edit');
    Route::put('/tipepembayaran/{id}/update', 'TipePembayaranController@update');
    
});
