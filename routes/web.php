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
    Route::get('/login', 'formLogin')->name('user.form.login');
    Route::post('/login', 'login')->name('user.login');
    Route::get('/logout', 'logout')->name('user.logout');
    Route::get('/get/username/{username}', 'getByUsername')->name('user.get.username');
    Route::get('/get/role/{role}', 'getByRole')->name('user.get.role');
    Route::post('/admin/update', 'updateAdmin')->name('user.admin.update');
    Route::get('/admin/delete/{id}', 'deleteAdmin')->name('user.admin.delete');
    Route::post('/akun/update', 'updateAkun')->name('user.akun.update');
    Route::get('/akun/delete/{id}', 'deleteAkun')->name('user.akun.delete');
    Route::post('/tamu/update', 'updateTamu')->name('user.tamu.update');
    Route::get('/tamu/delete/{id}', 'deleteTamu')->name('user.tamu.delete');
    Route::post('/fo/update', 'updateFrontOffice')->name('user.fo.update');
    Route::get('/fo/delete/{id}', 'deleteFrontOffice')->name('user.fo.delete');
    Route::post('/pegawai/update', 'updatePegawai')->name('user.pegawai.update');
    Route::get('/pegawai/delete/{id}', 'deletePegawai')->name('user.pegawai.delete');
});

// ADMIN ROUTES
Route::prefix('/admin')->controller(AdminController::class)->group(function () {
    Route::get('/permintaan/all', 'allPermintaanBertamu')->name('admin.permintaan.all');
    Route::get('/permintaan/setujui/{idPermintaan}', 'setujuiPermintaan')->name('admin.permintaan.setujui');
    Route::get('/all', 'allAdmin')->name('admin.all');
    Route::get('/pegawai/all', 'allPegawai')->name('admin.pegawai.all');
    Route::get('/fo/all', 'allFrontOffice')->name('admin.fo.all');
    Route::get('/tamu/all', 'allTamu')->name('admin.tamu.all'); 
    Route::get('/tamu/get/nik/{nik}', 'getTamuByNIK')->name('admin.tamu.get.nik');
    Route::post('/pegawai/tambah', 'tambahPegawai')->name('admin.pegawai.tambah');
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
