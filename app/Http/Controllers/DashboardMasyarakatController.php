<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;

class DashboardMasyarakatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Contoh tanggal jatuh tempo (dummy, ganti dengan data tagihan asli jika ada)
        $jatuh_tempo = now()->addDays(7)->format('d-m-Y');

        // Riwayat pengaduan user
        $riwayat_pengaduan = Pengaduan::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Grafik pengaduan per bulan (12 bulan terakhir)
        $grafik_pengaduan = Pengaduan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('count(*) as total')
            )
            ->where('user_id', $user->id)
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Kirim semua variabel ke view
        return view('dashboardmasyarakat', compact(
            'user',
            'jatuh_tempo',
            'riwayat_pengaduan',
            'grafik_pengaduan'
        ));
    }
}