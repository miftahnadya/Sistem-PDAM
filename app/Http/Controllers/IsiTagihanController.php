<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IsiTagihanController extends Controller
{
    public function index()
    {
        return view('admin.isi-tagihan.index');
    }

    public function searchPelanggan(Request $request)
    {
        $request->validate([
            'id_pel' => 'required|string|max:10'
        ]);

        $pelanggan = Pelanggan::where('id_pel', $request->id_pel)->first();

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ]);
        }

        // Ambil tagihan terakhir untuk referensi meter
        $tagihanTerakhir = Tagihan::where('id_pel', $request->id_pel)
            ->orderBy('periode', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'pelanggan' => $pelanggan,
            'tagihan_terakhir' => $tagihanTerakhir
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pel' => 'required|string|max:10|exists:pelanggan,id_pel',
            'periode' => 'required|string|max:7',
            'meter_awal' => 'required|numeric|min:0',
            'meter_akhir' => 'required|numeric|min:0',
            'tarif_per_m3' => 'required|numeric|min:0',
            'biaya_admin' => 'required|numeric|min:0',
            'biaya_beban' => 'nullable|numeric|min:0',
            'tgl_tagihan' => 'required|date',
            'tgl_batas_bayar' => 'required|date|after:tgl_tagihan'
        ]);

        // Validasi meter akhir harus lebih besar dari meter awal
        if ($request->meter_akhir < $request->meter_awal) {
            return back()->withErrors(['meter_akhir' => 'Meter akhir harus lebih besar dari meter awal']);
        }

        // Cek apakah tagihan untuk periode ini sudah ada
        $existingTagihan = Tagihan::where('id_pel', $request->id_pel)
            ->where('periode', $request->periode)
            ->first();

        if ($existingTagihan) {
            return back()->withErrors(['periode' => 'Tagihan untuk periode ini sudah ada']);
        }

        DB::beginTransaction();
        try {
            // Hitung pemakaian
            $pemakaian = $request->meter_akhir - $request->meter_awal;
            
            // Hitung biaya air
            $biaya_air = $pemakaian * $request->tarif_per_m3;
            
            // Hitung biaya pemakaian (biaya air + tarif dasar)
            $biaya_pemakaian = $biaya_air;
            
            // Hitung total tagihan
            $total_tagihan = $biaya_pemakaian + $request->biaya_admin + ($request->biaya_beban ?? 0);

            // Generate ID tagihan
            $id_tagihan = $this->generateIdTagihan($request->id_pel, $request->periode);

            Tagihan::create([
                'id_tagihan' => $id_tagihan,
                'id_pel' => $request->id_pel,
                'periode' => $request->periode,
                'meter_awal' => $request->meter_awal,
                'meter_akhir' => $request->meter_akhir,
                'tarif_per_m3' => $request->tarif_per_m3,
                'pemakaian' => $pemakaian,
                'biaya_air' => $biaya_air,
                'biaya_pemakaian' => $biaya_pemakaian,
                'biaya_admin' => $request->biaya_admin,
                'biaya_beban' => $request->biaya_beban ?? 0,
                'biaya_denda' => 0,
                'denda' => 0,
                'total_tagihan' => $total_tagihan,
                'status_bayar' => 'BELUM_LUNAS',
                'tgl_tagihan' => $request->tgl_tagihan,
                'tgl_batas_bayar' => $request->tgl_batas_bayar,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return redirect()->route('isi-tagihan.index')->with('success', 'Tagihan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function generateIdTagihan($id_pel, $periode)
    {
        // Format: TG-IDPEL-YYYYMM-XXX
        $tahun_bulan = str_replace('-', '', $periode);
        $prefix = 'TG-' . $id_pel . '-' . $tahun_bulan . '-';
        
        // Cari nomor urut terakhir
        $lastTagihan = Tagihan::where('id_tagihan', 'like', $prefix . '%')
            ->orderBy('id_tagihan', 'desc')
            ->first();
        
        if ($lastTagihan) {
            $lastNumber = intval(substr($lastTagihan->id_tagihan, -3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}