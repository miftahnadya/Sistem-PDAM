<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\Tarif;

class TagihanController extends Controller
{
    public function inputTagihan($id_pel)
    {
        // Cari pelanggan berdasarkan id_pel
        $pelanggan = User::where('id_pel', $id_pel)->first();
        
        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan!');
        }
        
        // Ambil data tarif untuk perhitungan
        $tarif = Tarif::first(); // Sesuaikan dengan struktur tabel tarif Anda
        
        // Ambil tagihan terakhir untuk referensi meter
        $tagihanTerakhir = Tagihan::where('id_pel', $id_pel)
            ->orderBy('created_at', 'desc')
            ->first();
        
        return view('admin.input-tagihan', compact('pelanggan', 'tarif', 'tagihanTerakhir'));
    }
    
    public function storeTagihan(Request $request, $id_pel)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gt:meter_awal',
        ]);
        
        $pelanggan = User::where('id_pel', $id_pel)->first();
        
        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan!');
        }
        
        // Hitung pemakaian
        $pemakaian = $request->meter_akhir - $request->meter_awal;
        
        // Ambil tarif (sesuaikan dengan struktur database Anda)
        $tarif = Tarif::first();
        $biaya_pemakaian = $pemakaian * $tarif->tarif_per_m3;
        $biaya_admin = $tarif->biaya_admin ?? 0;
        $total_tagihan = $biaya_pemakaian + $biaya_admin;
        
        // Simpan tagihan
        $tagihan = new Tagihan();
        $tagihan->id_pel = $id_pel;
        $tagihan->nama_pelanggan = $pelanggan->nama_pelanggan;
        $tagihan->bulan = $request->bulan;
        $tagihan->tahun = $request->tahun;
        $tagihan->meter_awal = $request->meter_awal;
        $tagihan->meter_akhir = $request->meter_akhir;
        $tagihan->pemakaian = $pemakaian;
        $tagihan->biaya_pemakaian = $biaya_pemakaian;
        $tagihan->biaya_admin = $biaya_admin;
        $tagihan->total_tagihan = $total_tagihan;
        $tagihan->status = 'belum_bayar';
        $tagihan->save();
        
        return redirect()->route('admin.isi-tagihan')->with('success', 'Tagihan berhasil dibuat untuk ' . $pelanggan->nama_pelanggan);
    }
}