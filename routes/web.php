<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('Login');
});

// Tambahkan route dengan nama 'cek-tagihan'
Route::get('/cek-tagihan', function () {
    // Ganti dengan logic atau view yang sesuai
    return view('cek-tagihan');
})->name('cek-tagihan');