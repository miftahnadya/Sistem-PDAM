<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CekTagihanController;
use App\Http\Controllers\DashboardMasyarakatController;
use App\Http\Controllers\PengaduanPelangganController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPengaduanController;
use App\Http\Controllers\IsitagihanController;
use App\Http\Controllers\TanggapiPengaduanController;
use App\Http\Controllers\AdminTagihanController;
use App\Http\Controllers\UserController;    

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User routes (require auth)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboardmasyarakat', [DashboardMasyarakatController::class, 'index'])->name('dashboardmasyarakat');
        Route::post('/pengaduan/track-result', [PengaduanController::class, 'trackResult'])->name('pengaduan.track.result');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    

    // Cek Tagihan
    // Route::get('/cektagihan', [CekTagihanController::class, 'index'])->name('cektagihan');
    Route::get('/cektagihan', [UserController::class, 'cekTagihan'])->name('cektagihan');
    Route::get('/cektagihan/export', [CekTagihanController::class, 'export'])->name('cektagihan.export');
    Route::get('/tagihan/periods', [CekTagihanController::class, 'getAvailablePeriods'])->name('tagihan.periods');
    Route::get('/tagihan/by-periode', [CekTagihanController::class, 'getTagihanByPeriode'])->name('tagihan.by-periode');
    Route::get('/tagihan/search', [CekTagihanController::class, 'search'])->name('tagihan.search');
    Route::post('/tagihan/quick-check', [CekTagihanController::class, 'quickCheck'])->name('tagihan.quick-check');


    // Pengaduan routes untuk pelanggan
    Route::get('/pengaduanpelanggan', [PengaduanController::class, 'index'])->name('pengaduanpelanggan');
    
    Route::prefix('pengaduan')->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::post('/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
        Route::get('/success/{ticketNumber}', [PengaduanController::class, 'success'])->name('pengaduan.success');
        Route::get('/track', [PengaduanController::class, 'track'])->name('pengaduan.track');
        Route::post('/track-result', [PengaduanController::class, 'trackResult'])->name('pengaduan.track.result');
    });
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard') ;

      Route::get('/isitagihan', [AdminController::class, 'isiTagihan'])->name('admin.isitagihan');
    
      // Input tagihan routes
    Route::get('/input-tagihan', [AdminController::class, 'inputTagihan'])->name('admin.input-tagihan');
    Route::get('/input-tagihan/{id_pel}', [AdminController::class, 'inputTagihanForUser'])->name('admin.input-tagihan');
        // Route untuk pencarian pelanggan
    Route::get('/pelanggan/search/{id_pel}', [AdminController::class, 'searchPelanggan'])->name('admin.pelanggan.search');
    
    // Route untuk menyimpan tagihan
    Route::post('/tagihan/store', [AdminController::class, 'storeTagihan'])->name('admin.tagihan.store');
    
    // Pengaduan Management
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('admin.pengaduan.index');
    Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->name('admin.pengaduan.show');
    Route::put('/pengaduan/{id}/update-status', [AdminPengaduanController::class, 'updateStatus'])->name('admin.pengaduan.update-status');
    Route::get('/pengaduan/{id}/download/{fileIndex}', [AdminPengaduanController::class, 'downloadFile'])->name('admin.pengaduan.download-file');
    Route::get('/pengaduan/export/excel', [AdminPengaduanController::class, 'exportExcel'])->name('admin.pengaduan.export-excel');
    
});

// Legacy routes untuk backward compatibility
Route::middleware('auth')->group(function () {
    Route::get('/tanggapipengaduan', [TanggapiPengaduanController::class, 'index'])->name('tanggapipengaduan');
});