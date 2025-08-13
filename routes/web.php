<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcom');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/servis', function () {
    return view('page.user.servis');
})->name('servis');
