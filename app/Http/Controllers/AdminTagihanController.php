<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminTagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        // Ambil semua pelanggan (bukan admin)
        $pelanggan = User::where('role', '!=', 'admin')->get();
        
        // Ambil data tagihan terbaru untuk setiap pelanggan
        $tagihan_data = User::where('role', '!=', 'admin')
            ->select('id_pel', 'nama_pelanggan', 'periode_terakhir', 'total_tagihan', 'status_pelanggan', 'alamat', 'goltar', 'total_pemakaian_m3', 'angka_meter_kini')
            ->orderBy('nama_pelanggan')
            ->get();

        // Statistik untuk cards
        $total_pelanggan = $pelanggan->count();
        $total_tagihan = $tagihan_data->sum('total_tagihan');
        $tagihan_lunas = $tagihan_data->where('status_pelanggan', 'AKTIF')->sum('total_tagihan');
        $tagihan_belum_lunas = $total_tagihan - $tagihan_lunas;
        
        return view('Isitagihan', compact(
            'pelanggan', 
            'tagihan_data',
            'total_pelanggan',
            'total_tagihan',
            'tagihan_lunas',
            'tagihan_belum_lunas'
        ));
    }

    public function create()
    {
        $pelanggan = User::where('role', '!=', 'admin')->get();
        return view('admin.input-tagihan', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pel' => 'required|exists:users,id_pel',
            'tahun' => 'required|integer|min:2020|max:2030',
            'bulan' => 'required|integer|min:1|max:12',
            'angka_meter_lalu' => 'required|numeric|min:0',
            'angka_meter_kini' => 'required|numeric|min:0',
            'biaya_admin' => 'required|numeric|min:0',
            'denda' => 'nullable|numeric|min:0',
        ]);

        try {
            if ($request->angka_meter_kini < $request->angka_meter_lalu) {
                return back()->withErrors(['angka_meter_kini' => 'Angka meter kini harus lebih besar dari meter lalu']);
            }

            $periode = sprintf('%04d%02d', $request->tahun, $request->bulan);
            $pemakaian = $request->angka_meter_kini - $request->angka_meter_lalu;
            
            $pelanggan = User::where('id_pel', $request->id_pel)->first();
            $harga_air = $this->hitungTarif($pemakaian, $pelanggan->goltar);
            $total_tagihan = $harga_air + $request->biaya_admin + ($request->denda ?? 0);

            User::where('id_pel', $request->id_pel)->update([
                'angka_meter_kini' => $request->angka_meter_kini,
                'periode_terakhir' => $periode,
                'total_pemakaian_m3' => $pemakaian,
                'harga_air' => $harga_air,
                'biaya_admin' => $request->biaya_admin,
                'denda' => $request->denda ?? 0,
                'total_tagihan' => $total_tagihan,
                'updated_at' => now()
            ]);

            $bulan_nama = $this->getNamaBulan($request->bulan);
            
            return redirect()->route('isitagihan')
                ->with('success', "Tagihan berhasil diinput untuk pelanggan {$pelanggan->nama_pelanggan} periode {$bulan_nama} {$request->tahun}");

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function edit($id_pel)
    {
        $pelanggan = User::where('id_pel', $id_pel)->first();
        
        if (!$pelanggan) {
            return redirect()->route('isitagihan')->with('error', 'Pelanggan tidak ditemukan');
        }

        return view('admin.edit-tagihan', compact('pelanggan'));
    }

    public function update(Request $request, $id_pel)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2020|max:2030',
            'bulan' => 'required|integer|min:1|max:12',
            'angka_meter_kini' => 'required|numeric|min:0',
            'biaya_admin' => 'required|numeric|min:0',
            'denda' => 'nullable|numeric|min:0',
        ]);

        try {
            $pelanggan = User::where('id_pel', $id_pel)->first();
            $periode = sprintf('%04d%02d', $request->tahun, $request->bulan);
            $meter_lalu = $request->angka_meter_lalu ?? 0;
            $pemakaian = $request->angka_meter_kini - $meter_lalu;
            
            $harga_air = $this->hitungTarif($pemakaian, $pelanggan->goltar);
            $total_tagihan = $harga_air + $request->biaya_admin + ($request->denda ?? 0);

            User::where('id_pel', $id_pel)->update([
                'angka_meter_kini' => $request->angka_meter_kini,
                'periode_terakhir' => $periode,
                'total_pemakaian_m3' => $pemakaian,
                'harga_air' => $harga_air,
                'biaya_admin' => $request->biaya_admin,
                'denda' => $request->denda ?? 0,
                'total_tagihan' => $total_tagihan,
                'updated_at' => now()
            ]);

            return redirect()->route('isitagihan')->with('success', 'Tagihan berhasil diupdate');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function hitungTarif($pemakaian, $goltar)
    {
        $tarif_per_m3 = match($goltar) {
            '21' => 3600, '22' => 4500, '23' => 5400, '24' => 6300,
            '31' => 7200, '32' => 8100, '41' => 9000, '42' => 10800,
            default => 3600
        };

        return $pemakaian * $tarif_per_m3;
    }

    private function getNamaBulan($bulan)
    {
        $nama_bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return $nama_bulan[$bulan] ?? 'Unknown';
    }
}