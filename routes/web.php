<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\TeknisiOwnerLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PembayaranController;

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/beranda'); // arahkan ke halaman beranda setelah logout
})->name('logout');

// Route publik tanpa login
Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', function () {
    return view('dashboard');
});

Route::get('/servis', function () {
    return view('page.user.servis');
});

// Route login teknisi/owner
Route::get('/login-teknisi-owner', [TeknisiOwnerLoginController::class, 'showLoginForm'])->name('teknisi.owner.login.form');
Route::post('/login-teknisi-owner', [TeknisiOwnerLoginController::class, 'login'])->name('teknisi.owner.login');

// Route yang membutuhkan auth
Route::middleware(['auth'])->group(function () {
    // Ringkasan untuk owner
    Route::get('/ringkasan-owner', [ServiceController::class, 'ringkasanOwner'])->name('pemilik.ringkasan');

    // Route pemilik
    Route::prefix('pemilik')->group(function () {
        Route::get('/akun', [UserController::class, 'index'])->name('pemilik.akun.index');
        Route::post('/akun', [UserController::class, 'store'])->name('pemilik.akun.store');
        Route::put('/akun/{id}/access', [UserController::class, 'toggleAccess'])->name('pemilik.akun.toggleAccess');
        Route::post('/akun/{id}/toggle-access', [UserController::class, 'toggleAccess'])->name('pemilik.akun.toggleAccess.post');
        Route::delete('/akun/{id}', [UserController::class, 'destroy'])->name('pemilik.akun.destroy');

        // Tambahan perbaikan: route verify aman untuk POST
        Route::match(['get', 'post'], '/akun/verify', [UserController::class, 'verify'])->name('pemilik.akun.verify');

        // Route tambahan untuk resend verification code
        Route::post('/akun/{id}/resend-code', [UserController::class, 'resendCode'])->name('pemilik.akun.resendCode');
    });

    // Halaman daftar servis (teknisi/owner)
    Route::get('/daftar-servis', [ServiceController::class, 'daftarServis'])->name('service.daftar');

    // Route baru untuk update proses & status
    Route::post('/daftar-servis/update', [ServiceController::class, 'updateProsesStatus'])->name('service.updateProsesStatus');
});

// Route service umum
Route::get('/history', [ServiceController::class, 'history'])->name('service.history');
Route::get('/service/check', [ServiceController::class, 'checkForm'])->name('service.check.form');
Route::post('/service/check', [ServiceController::class, 'check'])->name('service.check');
Route::get('/service/form', [ServiceController::class, 'create'])->name('service.form');
Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
Route::get('/service/sukses/{service_id}', [ServiceController::class, 'sukses'])->name('service.sukses');
Route::post('/service/{id}/rating', [ServiceController::class, 'giveRating'])->name('service.giveRating');

// Pembayaran
Route::get('/check-pembayaran', [PembayaranController::class, 'checkForm'])->name('pembayaran.form');
Route::post('/check-pembayaran', [PembayaranController::class, 'check'])->name('pembayaran.check');
Route::get('/pembayaran/success/{id}', [PembayaranController::class, 'success'])->name('pembayaran.success');
Route::post('/pembayaran/cod', [PembayaranController::class, 'cod'])->name('pembayaran.cod');

// Route untuk menghapus service
Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
Route::delete('/service/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('service.bulk-delete');

// Route tambahan untuk fallback register supaya tidak error
Route::get('/register', function () {
    return redirect('/login-teknisi-owner');
})->name('register');

// Route riwayat owner (auth)
Route::get('/riwayat-owner', [ServiceController::class, 'historyOwner'])
    ->middleware('auth')
    ->name('riwayat.owner');