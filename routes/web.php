<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use Illuminate\Support\Facades\Http;

Route::get('/cek-github-{random}', function () {
    $response = Http::get('https://api.github.com/');

    if ($response->successful()) {
        return response()->json([
            'status' => 'ok',
            'message' => 'GitHub dapat diakses.',
            'headers' => $response->headers(),
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Tidak bisa mengakses GitHub.',
            'code' => $response->status(),
        ], $response->status());
    }
});
