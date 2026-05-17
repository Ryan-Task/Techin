<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\TeknisiOwnerLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PembayaranController;

// Owner-only routes
Route::middleware(['auth', 'role:owner'])->prefix('pemilik')->group(function () {
    Route::get('/ringkasan', [ServiceController::class, 'ringkasanOwner'])->name('pemilik.ringkasan');

    Route::get('/akun', [UserController::class, 'index'])->name('pemilik.akun.index');
    Route::post('/akun', [UserController::class, 'store'])->name('pemilik.akun.store');
    Route::put('/akun/{id}/access', [UserController::class, 'toggleAccess'])->name('pemilik.akun.toggleAccess');
    Route::post('/akun/{id}/toggle-access', [UserController::class, 'toggleAccess'])->name('pemilik.akun.toggleAccess.post');
    Route::delete('/akun/{id}', [UserController::class, 'destroy'])->name('pemilik.akun.destroy');
});

Route::get('/riwayat-owner', [ServiceController::class, 'historyOwner'])
    ->middleware(['auth', 'role:owner'])
    ->name('riwayat.owner');

// Teknisi routes (teknisi + owner can access)
Route::middleware(['auth', 'role:teknisi,owner'])->group(function () {
    Route::get('/daftar-servis', [ServiceController::class, 'daftarServis'])->name('service.daftar');

    Route::post('/daftar-servis/update', [ServiceController::class, 'updateProsesStatus'])
        ->name('service.updateProsesStatus');

    Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
    Route::delete('/service/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('service.bulk-delete');

    Route::get('/history', [ServiceController::class, 'history'])->name('service.history');
});

// Pembayaran (umum)
Route::get('/check-pembayaran', [PembayaranController::class, 'checkForm'])->name('pembayaran.form');
Route::post('/check-pembayaran', [PembayaranController::class, 'check'])->name('pembayaran.check');

Route::get('/pembayaran/success/{id}', [PembayaranController::class, 'success'])->name('pembayaran.success');
Route::post('/pembayaran/cod', [PembayaranController::class, 'cod'])->name('pembayaran.cod');

// Rating service request (baru ditambahkan)
Route::post('/service/{id}/rating', [ServiceController::class, 'giveRating'])->name('service.giveRating');

Route::get('/service/check', [ServiceController::class, 'checkForm'])->name('service.check.form');
Route::post('/service/check', [ServiceController::class, 'check'])->name('service.check');

// Login teknisi/owner
Route::get('/login-teknisi-owner', [TeknisiOwnerLoginController::class, 'showLoginForm'])->name('teknisi.owner.login.form');
Route::post('/login-teknisi-owner', [TeknisiOwnerLoginController::class, 'login'])->name('teknisi.owner.login');

// Service
Route::get('/service/form', [ServiceController::class, 'create'])->name('service.form');
Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
Route::get('/service/sukses/{service_id}', [ServiceController::class, 'sukses'])->name('service.sukses');

// Halaman statis
Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', function () {
    return view('dashboard');
});

Route::get('/servis', function () {
    return view('page.user.servis');
});