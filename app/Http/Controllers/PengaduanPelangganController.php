<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanPelangganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Dummy data pengaduan
        $pengaduan = collect([
            (object)[
                'id' => 1,
                'isi_pengaduan' => 'Air keruh sejak kemarin',
                'status' => 'Menunggu',
                'tanggal_pengaduan' => date('Y-m-d'),
                'tanggapan' => null
            ]
        ]);

        return view('pengaduanpelanggan', compact('pengaduan', 'user'));
    }
}