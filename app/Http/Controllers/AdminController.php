<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Pastikan hanya admin yang bisa akses
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboardmasyarakat')->with('error', 'Akses ditolak!');
        }

        // Statistics untuk dashboard admin
        $stats = [
            'total_pengaduan' => Pengaduan::count(),
            'pengaduan_pending' => Pengaduan::where('status', 'pending')->count(),
            'pengaduan_diproses' => Pengaduan::where('status', 'diproses')->count(),
            'pengaduan_selesai' => Pengaduan::where('status', 'selesai')->count(),
            'total_pelanggan' => User::where('role', 'user')->count(),
        ];

        // Data pengaduan terbaru
        $pengaduan_terbaru = Pengaduan::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pengaduan_terbaru'));
    }

    public function dataPelanggan()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboardmasyarakat')->with('error', 'Akses ditolak!');
        }

        $pelanggan = User::where('role', 'user')->paginate(15);
        return view('admin.data-pelanggan', compact('pelanggan'));
    }
}