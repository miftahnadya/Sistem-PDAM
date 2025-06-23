<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CekTagihanController;
use App\Http\Controllers\DashboardMasyarakatController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/cektagihan', [CekTagihanController::class, 'index'])
    ->middleware('auth')
    ->name('cektagihan');

Route::get('/pengaduanpelanggan', [PengaduanPelangganController::class, 'index'])
    ->middleware('auth')
    ->name('pengaduanpelanggan');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


Route::get('/dashboardmasyarakat', [DashboardMasyarakatController::class, 'index'])
    ->middleware('auth')
    ->name('dashboardmasyarakat');