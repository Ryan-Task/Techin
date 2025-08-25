<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\TeknisiOwnerLoginController;
use App\Http\Controllers\UserController;

Route::middleware(['auth'])->prefix('pemilik')->group(function () {
    Route::get('/akun', [UserController::class, 'index'])->name('pemilik.akun.index');
    Route::post('/akun', [UserController::class, 'store'])->name('pemilik.akun.store');

    // route lama biarkan
    Route::put('/akun/{id}/access', [UserController::class, 'toggleAccess'])->name('pemilik.akun.toggleAccess');

    // route tambahan agar cocok dengan tombol/JS kamu
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

// Halaman statis
Route::get('/', function () {
    return view('welcom'); // mungkin seharusnya 'welcome'
});

Route::get('/beranda', function () {
    return view('dashboard');
});

Route::get('/servis', function () {
    return view('page.user.servis');
});