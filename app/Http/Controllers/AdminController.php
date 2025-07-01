<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        // Statistik untuk dashboard admin
        $total_pelanggan = User::where('role', '!=', 'admin')->count();
        $total_tagihan = User::where('role', '!=', 'admin')->sum('total_tagihan') ?? 0;
        $pelanggan_aktif = User::where('role', '!=', 'admin')
            ->where('status_pelanggan', 'AKTIF')->count();
        $pelanggan_tidak_aktif = User::where('role', '!=', 'admin')
            ->where('status_pelanggan', 'TIDAK AKTIF')->count();

        // Data tagihan terbaru
        $tagihan_terbaru = User::where('role', '!=', 'admin')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Grafik pengaduan per bulan (dummy data)
        $grafik_pengaduan = collect([
            (object)['bulan' => 1, 'tahun' => 2024, 'total' => 5],
            (object)['bulan' => 2, 'tahun' => 2024, 'total' => 3],
            (object)['bulan' => 3, 'tahun' => 2024, 'total' => 8],
            (object)['bulan' => 4, 'tahun' => 2024, 'total' => 2],
            (object)['bulan' => 5, 'tahun' => 2024, 'total' => 6],
            (object)['bulan' => 6, 'tahun' => 2024, 'total' => 4],
        ]);

        // Grafik pemakaian air per golongan tarif
        $grafik_pemakaian = User::where('role', '!=', 'admin')
            ->selectRaw('goltar, SUM(total_pemakaian_m3) as total_pemakaian')
            ->whereNotNull('goltar')
            ->groupBy('goltar')
            ->get();

        return view('admin.dashboard', compact(
            'total_pelanggan',
            'total_tagihan', 
            'pelanggan_aktif',
            'pelanggan_tidak_aktif',
            'tagihan_terbaru',
            'grafik_pengaduan',
            'grafik_pemakaian'
        ));
    }
}