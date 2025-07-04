<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function cekTagihan(Request $request)
    {
        $user = Auth::user();
        $id_pel = $user->id_pel;
        
        // Query untuk mengambil data tagihan
        $query = DB::table('tagihan')
            ->leftJoin('pelanggan', 'tagihan.id_pel', '=', 'pelanggan.id_pel')
            ->select(
                'tagihan.*',
                'pelanggan.nama_pelanggan',
                'pelanggan.alamat',
                'pelanggan.no_telepon',
                DB::raw('CONCAT(tagihan.bulan, "/", tagihan.tahun) as periode_formatted'),
                DB::raw('CASE 
                    WHEN tagihan.status_bayar = "LUNAS" THEN "LUNAS"
                    WHEN tagihan.tgl_batas_bayar < CURDATE() THEN "TERLAMBAT"
                    ELSE "BELUM LUNAS"
                END as status_pembayaran'),
                DB::raw('CASE 
                    WHEN tagihan.status_bayar = "LUNAS" THEN 0
                    WHEN tagihan.tgl_batas_bayar < CURDATE() THEN 
                        DATEDIFF(CURDATE(), tagihan.tgl_batas_bayar) * 1000
                    ELSE 0
                END as denda_keterlambatan'),
                DB::raw('(tagihan.pemakaian * tagihan.tarif_per_m3) as harga_air'),
                DB::raw('(tagihan.total_tagihan + CASE 
                    WHEN tagihan.status_bayar = "LUNAS" THEN 0
                    WHEN tagihan.tgl_batas_bayar < CURDATE() THEN 
                        DATEDIFF(CURDATE(), tagihan.tgl_batas_bayar) * 1000
                    ELSE 0
                END) as total_dengan_denda')
            )
            ->where('tagihan.id_pel', $id_pel);
        
        // Filter berdasarkan periode jika dipilih
        if ($request->filled('periode')) {
            $periode = $request->periode;
            $query->where('tagihan.periode', $periode);
        }
        
        // Ambil data tagihan
        $tagihans = $query->orderBy('tagihan.tahun', 'desc')
                         ->orderBy('tagihan.bulan', 'desc')
                         ->get();
        
        // Hitung summary
        $summary = [
            'total_records' => $tagihans->count(),
            'total_pemakaian' => $tagihans->sum('pemakaian'),
            'total_tagihan' => $tagihans->sum('total_tagihan'),
            'total_denda' => $tagihans->sum('denda_keterlambatan'),
            'total_dengan_denda' => $tagihans->sum('total_dengan_denda'),
            'lunas' => $tagihans->where('status_bayar', 'LUNAS')->count(),
            'belum_lunas' => $tagihans->where('status_bayar', 'BELUM_LUNAS')->count(),
        ];
        
        // Ambil periode yang tersedia
        $periode_tersedia = DB::table('tagihan')
            ->where('id_pel', $id_pel)
            ->select('periode', 'bulan', 'tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get()
            ->map(function($item) {
                return [
                    'periode' => $item->periode,
                    'formatted' => $this->formatPeriode($item->bulan, $item->tahun)
                ];
            });
        
        // Format data untuk tampilan
        $tagihans = $tagihans->map(function($tagihan) {
            $tagihan->periode_terakhir = $tagihan->periode_formatted;
            $tagihan->total_pemakaian_m3 = $tagihan->pemakaian;
            $tagihan->denda = $tagihan->denda_keterlambatan;
            $tagihan->total_tagihan = $tagihan->total_dengan_denda;
            $tagihan->jatuh_tempo = Carbon::parse($tagihan->tgl_batas_bayar)->format('d/m/Y');
            $tagihan->tgl_tagihan_formatted = Carbon::parse($tagihan->tgl_tagihan)->format('d/m/Y');
            
            return $tagihan;
        });
        
        return view('cektagihan', compact('tagihans', 'summary', 'periode_tersedia'));
    }
    
    private function formatPeriode($bulan, $tahun)
    {
        $bulan_nama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return $bulan_nama[$bulan] . ' ' . $tahun;
    }
}