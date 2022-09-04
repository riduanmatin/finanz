<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes([
	'register' => false, // disable register
  	'reset' => false, // disable reset password
  	'verify' => false, // disable verifikasi email saat pendaftaran
]);

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/kategori', 'HomeController@kategori')->name('kategori');
// Route::post('/kategori/aksi', 'HomeController@kategori_aksi')->name('kategori.aksi');
// Route::put('/kategori/update/{id}', 'HomeController@kategori_update')->name('kategori.update');
// Route::delete('/kategori/delete/{id}', 'HomeController@kategori_delete')->name('kategori.delete');

Route::get('/kategori', 'KategoriController@view')->name('kategori');
Route::post('/kategori/aksi', 'KategoriController@input')->name('kategori.aksi');
Route::put('/kategori/update/{id}', 'KategoriController@update')->name('kategori.update');
Route::delete('/kategori/delete/{id}', 'KategoriController@delete')->name('kategori.delete');

Route::get('/password', 'HomeController@password')->name('password');
Route::post('/password/update', 'HomeController@password_update')->name('password.update');

// Route::get('/transaksi', 'HomeController@transaksi')->name('transaksi');
// Route::post('/transaksi/aksi', 'HomeController@transaksi_aksi')->name('transaksi.aksi');
// Route::put('/transaksi/update/{id}', 'HomeController@transaksi_update')->name('transaksi.update');
// Route::delete('/transaksi/delete/{id}', 'HomeController@transaksi_delete')->name('transaksi.delete');

Route::get('/transaksi', 'TransaksiController@view')->name('transaksi');
Route::post('/transaksi/input', 'TransaksiController@input')->name('transaksi.aksi');
Route::put('/transaksi/update/{id}', 'TransaksiController@update')->name('transaksi.update');
Route::delete('/transaksi/delete/{id}', 'TransaksiController@delete')->name('transaksi.delete');

// Route::get('/pengguna', 'HomeController@user')->name('user');
// Route::get('/pengguna/tambah', 'HomeController@user_add')->name('user.tambah');
// Route::post('/pengguna/aksi', 'HomeController@user_aksi')->name('user.aksi');
// Route::get('/pengguna/edit/{id}', 'HomeController@user_edit')->name('user.edit');
// Route::put('/pengguna/update/{id}', 'HomeController@user_update')->name('user.update');
// Route::delete('/user/delete/{id}', 'HomeController@user_delete')->name('user.delete');

Route::get('/pengguna', 'UserController@view')->name('user');
Route::get('/pengguna/tambah', 'UserController@user_add')->name('user.tambah');
Route::post('/pengguna/aksi', 'UserController@add')->name('user.aksi');
Route::get('/pengguna/edit/{id}', 'UserController@edit')->name('user.edit');
Route::put('/pengguna/update/{id}', 'UserController@update')->name('user.update');
Route::delete('/user/delete/{id}', 'UserController@delete')->name('user.delete');

// Route::get('/laporan', 'HomeController@laporan')->name('laporan');
// Route::get('/laporan/excel', 'HomeController@laporan_excel')->name('laporan_excel');
// Route::get('/laporan/pdf', 'HomeController@laporan_print')->name('laporan_print');

Route::get('/laporan', 'LaporanRugiLabaController@view')->name('laporan');
Route::get('/laporan/excel', 'LaporanRugiLabaController@print_excel')->name('laporan_excel');
Route::get('/laporan/pdf', 'LaporanRugiLabaController@print_pdf')->name('laporan_print');

// Route::get('/laporan-anggaran', 'HomeController@laporan_anggaran')->name('laporan.anggaran');
// Route::get('/laporan-anggaran/print', 'HomeController@laporan_print_anggaran')->name('laporan.anggaran.print');
// Route::get('/laporan-anggaran/excel', 'HomeController@laporan_excel_anggaran')->name('laporan.anggaran.excel');

Route::get('/laporan-anggaran', 'LaporanAnggaranController@view')->name('laporan.anggaran');
Route::get('/laporan-anggaran/pdf', 'LaporanAnggaranController@print_pdf')->name('laporan.anggaran.print');
Route::get('/laporan-anggaran/excel', 'LaporanAnggaranController@print_excel')->name('laporan.anggaran.excel');

// Route::get('/laporan-arus-kas', 'HomeController@laporan_arus_kas')->name('laporan.arus.kas');
// Route::get('/laporan-arus-kas/pdf', 'HomeController@laporan_arus_kas_print')->name('laporan.arus.kas.print');
// Route::get('/laporan-arus-kas/excel', 'HomeController@laporan_arus_kas_excel')->name('laporan.arus.kas.excel');

Route::get('/laporan-arus-kas', 'LaporanArusKasController@view')->name('laporan.arus.kas');
Route::get('/laporan-arus-kas/pdf', 'LaporanArusKasController@print_pdf')->name('laporan.arus.kas.print');
Route::get('/laporan-arus-kas/excel', 'LaporanArusKasController@print_excel]')->name('laporan.arus.kas.excel');

// Route::get('/rencana-anggaran', 'HomeController@rencana_anggaran')->name('anggaran.rencana');
// Route::post('/rencana-anggaran/aksi', 'HomeController@rencana_anggaran_aksi')->name('anggaran.rencana.aksi');
// Route::put('/rencana-anggaran/update/{id}', 'HomeController@rencana_anggaran_update')->name('anggaran.rencana.update');
// Route::delete('rencana-anggaran/delete/{id}', 'HomeController@rencana_anggaran_delete')->name('anggaran.rencana.delete');

Route::get('/rencana-anggaran', 'RencanaAnggaranController@view')->name('anggaran.rencana');
Route::post('/rencana-anggaran/aksi', 'RencanaAnggaranController@input')->name('anggaran.rencana.aksi');
Route::put('/rencana-anggaran/update/{id}', 'RencanaAnggaranController@update')->name('anggaran.rencana.update');
Route::delete('rencana-anggaran/delete/{id}', 'RencanaAnggaranController@delete')->name('anggaran.rencana.delete');

// Route::get('/anggaran', 'HomeController@anggaran')->name('anggaran');
// Route::post('anggaran/validasi/{id}', 'HomeController@anggaran_aksi_terima')->name('anggaran.aksi.validasi');
// Route::post('anggaran/tolak/{id}', 'HomeController@anggaran_aksi_tolak')->name('anggaran.aksi.tolak');
// Route::post('anggaran/realisasi/{id}', 'HomeController@anggaran_aksi_realisasi')->name('anggaran.aksi.realisasi');

Route::get('/anggaran', 'AnggaranController@view')->name('anggaran');
Route::post('anggaran/validasi/{id}', 'AnggaranController@input_anggaran_terima')->name('anggaran.aksi.validasi');
Route::post('anggaran/tolak/{id}', 'AnggaranController@input_anggaran_tolak')->name('anggaran.aksi.tolak');
Route::post('anggaran/realisasi/{id}', 'AnggaranController@input_anggaran_realisasi')->name('anggaran.aksi.realisasi');