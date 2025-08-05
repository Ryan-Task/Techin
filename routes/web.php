<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcom');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});