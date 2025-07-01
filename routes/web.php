<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CekTagihanController;
use App\Http\Controllers\DashboardMasyarakatController;
use App\Http\Controllers\PengaduanPelangganController;
use App\Http\Controllers\IsitagihanController;
use App\Http\Controllers\TanggapiPengaduanController;

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
        Route::get('/cektagihan', [CekTagihanController::class, 'index'])->name('cektagihan');
    Route::get('/cektagihan/export', [CekTagihanController::class, 'export'])->name('cektagihan.export');
        Route::get('/tagihan/periods', [CekTagihanController::class, 'getAvailablePeriods'])->name('tagihan.periods');
    Route::get('/tagihan/by-periode', [CekTagihanController::class, 'getTagihanByPeriode'])->name('tagihan.by-periode');
    Route::get('/tagihan/search', [CekTagihanController::class, 'search'])->name('tagihan.search');
    Route::post('/tagihan/quick-check', [CekTagihanController::class, 'quickCheck'])->name('tagihan.quick-check');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/dashboardmasyarakat', [DashboardMasyarakatController::class, 'index'])
    ->middleware('auth')
    ->name('dashboardmasyarakat');

Route::get('/tanggapipengaduan', [TanggapiPengaduanController::class, 'index'])
    ->middleware('auth')
    ->name('tanggapipengaduan');

Route::get('/isitagihan', [IsitagihanController::class, 'index'])
    ->middleware('auth')
    ->name('isitagihan');