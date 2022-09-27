<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontOfficeController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});

Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

// USER ROUTES
Route::prefix('/user')->controller(UserController::class)->group(function () {
    Route::get('/all', 'allUser')->name('user.all');
    Route::post('/daftar', 'daftar')->name('user.daftar');
    Route::get('/login', 'formLogin')->name('user.formLogin');
    Route::post('/login', 'login')->name('user.login');
    Route::get('/logout', 'logout')->name('user.logout');
    Route::get('/get/nik/{nik}', 'getByNIK')->name('user.get.nik');
    Route::get('/get/role/{role}', 'getByRole')->name('user.get.role');
});

// ADMIN ROUTES
Route::prefix('/admin')->controller(AdminController::class)->group(function () {
    Route::get('/permintaan/all', 'allPermintaanBertamu')->name('admin.permintaan.all');
    Route::get('/permintaan/setujui/{idPermintaan}', 'setujuiPermintaan')->name('admin.permintaan.setujui');
    Route::get('/pegawai/all', 'allPegawai')->name('admin.pegawai.all');
});

// TAMU ROUTES
Route::prefix('/tamu')->controller(TamuController::class)->group(function () {
    Route::post('/permintaan/tambah', 'tambahPermintaan')->name('tamu.permintaan.tambah');
});

// FRONT OFFICE ROUTES
Route::prefix('/fo')->controller(FrontOfficeController::class)->group(function () {
    Route::post('/buku-tamu/check-in', 'checkIn')->name('fo.bukutamu.checkIn');
    Route::get('/buku-tamu/all', 'allBukuTamu')->name('fo.bukutamu.all');
});