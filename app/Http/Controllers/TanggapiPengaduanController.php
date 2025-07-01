<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TanggapiPengaduanController extends Controller
{
    public function index()
    {
        // Dummy data pengaduan untuk admin
        $pengaduan = collect([
            (object)[
                'id' => 1,
                'id_pel' => '00357',
                'user' => (object)['nama_pelanggan' => 'HANIF'],
                'isi_pengaduan' => 'Air keruh sejak kemarin',
                'status' => 'Menunggu',
                'created_at' => now()->subDays(1),
                'tanggapan' => null
            ],
            (object)[
                'id' => 2,
                'id_pel' => '00323',
                'user' => (object)['nama_pelanggan' => 'FADHIL RIDWAN'],
                'isi_pengaduan' => 'Meteran rusak',
                'status' => 'Diselesaikan',
                'created_at' => now()->subDays(3),
                'tanggapan' => 'Meteran sudah diperbaiki'
            ]
        ]);

        return view('tanggapipengaduan', compact('pengaduan'));
    }
}