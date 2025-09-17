<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\TeknisiOwnerLoginController;
use App\Http\Controllers\UserController;


Route::get('/service/check', [ServiceController::class, 'checkForm'])->name('service.check.form');
Route::post('/service/check', [ServiceController::class, 'check'])->name('service.check');



// Route pemilik
Route::middleware(['auth'])->prefix('pemilik')->group(function () {
    Route::get('/akun', [UserController::class, 'index'])->name('pemilik.akun.index');
    Route::post('/akun', [UserController::class, 'store'])->name('pemilik.akun.store');
    Route::put('/akun/{id}/access', [UserController::class, 'toggleAccess'])->name('pemilik.akun.toggleAccess');
    Route::post('/akun/{id}/toggle-access', [UserController::class, 'toggleAccess'])->name('pemilik.akun.toggleAccess.post');
    Route::delete('/akun/{id}', [UserController::class, 'destroy'])->name('pemilik.akun.destroy');
});

// Login teknisi/owner
Route::get('/login-teknisi-owner', [TeknisiOwnerLoginController::class, 'showLoginForm'])->name('teknisi.owner.login.form');
Route::post('/login-teknisi-owner', [TeknisiOwnerLoginController::class, 'login'])->name('teknisi.owner.login');

// Service
Route::get('/service/form', [ServiceController::class, 'create'])->name('service.form');
Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
Route::get('/service/sukses/{service_id}', [ServiceController::class, 'sukses'])->name('service.sukses');

// Halaman daftar servis (teknisi/owner)
Route::get('/daftar-servis', [ServiceController::class, 'daftarServis'])
    ->name('service.daftar')
    ->middleware('auth');

//Route untuk menghapus secara banyak
Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
Route::delete('/service/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('service.bulk-delete');


// Route baru untuk update proses & status (menggunakan POST)
Route::post('/daftar-servis/update', [ServiceController::class, 'updateProsesStatus'])
    ->name('service.updateProsesStatus')
    ->middleware('auth');

// Halaman statis
Route::get('/', function () {
    return view('welcome'); // pastikan typo diperbaiki
});



Route::get('/beranda', function () {
    return view('dashboard');
});

Route::get('/servis', function () {
    return view('page.user.servis');
});

Route::get('/check', function () {
    return view('page.user.check');
});

Route::get('/check_diterima', function () {
    return view('page.user.check_diterima');
});


Route::get('/check_ditolak', function () {
    return view('page.user.check_ditolak');
});

Route::get('/check_belum', function () {
    return view('page.user.check_belum');
});

Route::get('/check_diperbaiki', function () {
    return view('page.user.check_diperbaiki');
});


Route::get('/check_diambil', function () {
    return view('page.user.check_diambil');
});


Route::get('/check_selesai', function () {
    return view('page.user.check_selesai');
});


Route::get('/pembayaran', function () {
    return view('page.teknisi.pembayaran');
});

Route::get('/riwayat', function () {
    return view('page.pemilik.riwayat');
});

Route::get('/ringkasan', function () {
    return view('page.pemilik.ringkasan');
});

Route::get('/daftarservis', function () {
    return view('page.teknisi.daftarservis');
});

