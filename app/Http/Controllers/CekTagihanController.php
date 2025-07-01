<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class CekTagihanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Redirect admin ke dashboard admin
        if ($user->role === 'admin') {
            return redirect()->route('dashboardadmin');
        }

        $tagihans = collect();

        // Jika ada filter periode atau tampilkan default
        if ($request->filled('periode')) {
            $periode = $request->periode;
            if ($user->periode_terakhir && $user->periode_terakhir === $periode) {
                $tagihans = $this->buildTagihanData($user);
            }
        } else {
            // Tampilkan data default jika ada
            if ($user->periode_terakhir) {
                $tagihans = $this->buildTagihanData($user);
            }
        }

        // Data periode untuk dropdown
        $periode_tersedia = collect();
        if ($user->periode_terakhir) {
            $periode_tersedia->push([
                'periode' => $user->periode_terakhir,
                'formatted' => $this->formatPeriode($user->periode_terakhir)
            ]);
        }

        // Summary data
        $summary = [
            'total_records' => $tagihans->count(),
            'total_pemakaian' => $tagihans->sum('total_pemakaian_m3'),
            'total_tagihan' => $tagihans->sum('total_tagihan'),
            'total_denda' => $tagihans->sum('denda'),
            'total_biaya_admin' => $tagihans->sum('biaya_admin'),
            'total_harga_air' => $tagihans->sum('harga_air'),
        ];

        return view('cektagihan', compact('tagihans', 'periode_tersedia', 'summary'));
    }

    /**
     * Build data tagihan dari user
     */
    private function buildTagihanData($user)
    {
        return collect([
            (object)[
                'id' => $user->id,
                'id_pel' => $user->id_pel,
                'nama_pelanggan' => $user->nama_pelanggan,
                'periode_terakhir' => $user->periode_terakhir,
                'total_pemakaian_m3' => $user->total_pemakaian_m3 ?? 0,
                'harga_air' => $user->harga_air ?? 0,
                'biaya_admin' => $user->biaya_admin ?? 0,
                'denda' => $user->denda ?? 0,
                'total_tagihan' => $user->total_tagihan ?? 0,
                'status_pembayaran' => ($user->total_tagihan ?? 0) > 0 ? 'Belum Lunas' : 'Lunas',
                'jatuh_tempo' => $this->calculateJatuhTempo($user->periode_terakhir),
                'alamat' => $user->alamat ?? '',
                'goltar' => $user->goltar ?? '',
                'status_meter' => $user->status_meter ?? '',
                'angka_meter_kini' => $user->angka_meter_kini ?? 0,
            ]
        ]);
    }

    /**
     * Quick check untuk dashboard
     */
    public function quickCheck(Request $request)
    {
        $user = Auth::user();
        
        return response()->json([
            'has_bill' => ($user->total_tagihan ?? 0) > 0,
            'periode' => $user->periode_terakhir ?? null,
            'formatted_periode' => $user->periode_terakhir ? $this->formatPeriode($user->periode_terakhir) : null,
            'amount' => $user->total_tagihan ?? 0,
            'formatted_amount' => 'Rp ' . number_format($user->total_tagihan ?? 0, 0, ',', '.'),
            'status' => ($user->total_tagihan ?? 0) > 0 ? 'unpaid' : 'paid',
            'tunggakan_bulan' => $user->jumlah_bulan_rekening ?? 0,
            'pemakaian' => $user->total_pemakaian_m3 ?? 0
        ]);
    }

    /**
     * Print tagihan
     */
    public function print($id)
    {
        $user = Auth::user();
        
        // Cek akses
        if ($user->id != $id && $user->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        $billUser = User::find($id);
        if (!$billUser) {
            abort(404, 'Data tidak ditemukan');
        }

        $bill = (object)[
            'id' => $id,
            'id_pel' => $billUser->id_pel ?? 'N/A',
            'nama_pelanggan' => $billUser->nama_pelanggan ?? 'N/A',
            'alamat' => $billUser->alamat ?? 'N/A',
            'desa' => $billUser->desa ?? '',
            'kecamatan' => $billUser->kecamatan ?? '',
            'goltar' => $billUser->goltar ?? 'N/A',
            'periode_terakhir' => $billUser->periode_terakhir ?? 'N/A',
            'total_pemakaian_m3' => $billUser->total_pemakaian_m3 ?? 0,
            'harga_air' => $billUser->harga_air ?? 0,
            'biaya_admin' => $billUser->biaya_admin ?? 0,
            'denda' => $billUser->denda ?? 0,
            'total_tagihan' => $billUser->total_tagihan ?? 0,
            'tanggal_cetak' => date('d/m/Y H:i:s'),
            'formatted_periode' => $billUser->periode_terakhir ? $this->formatPeriode($billUser->periode_terakhir) : 'N/A',
            'jatuh_tempo' => $this->calculateJatuhTempo($billUser->periode_terakhir),
            'status_meter' => $billUser->status_meter ?? 'N/A',
            'angka_meter_kini' => $billUser->angka_meter_kini ?? 0,
            'angka_meter_lalu' => max(0, ($billUser->angka_meter_kini ?? 0) - ($billUser->total_pemakaian_m3 ?? 0)),
        ];

        return view('cektagihan.print', compact('bill'));
    }

    /**
     * Export data tagihan
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        
        $data = [
            'export_date' => date('d/m/Y H:i:s'),
            'user_data' => [
                'id_pel' => $user->id_pel,
                'nama_pelanggan' => $user->nama_pelanggan,
                'alamat' => $user->alamat,
                'periode_terakhir' => $user->periode_terakhir,
                'total_pemakaian_m3' => $user->total_pemakaian_m3,
                'harga_air' => $user->harga_air,
                'biaya_admin' => $user->biaya_admin,
                'denda' => $user->denda,
                'total_tagihan' => $user->total_tagihan,
                'formatted_periode' => $user->periode_terakhir ? $this->formatPeriode($user->periode_terakhir) : null,
            ],
            'summary' => [
                'total_tagihan' => $user->total_tagihan ?? 0,
                'status' => ($user->total_tagihan ?? 0) > 0 ? 'Belum Lunas' : 'Lunas',
                'tunggakan_bulan' => $user->jumlah_bulan_rekening ?? 0
            ]
        ];

        $filename = 'tagihan_' . ($user->id_pel ?? 'unknown') . '_' . date('Ymd_His') . '.json';
        
        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Type', 'application/json');
    }

    /**
     * Format periode tanpa Carbon
     */
    private function formatPeriode($periode)
    {
        if (!$periode) return '';
        
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        try {
            $year = null;
            $month = null;
            
            // Parse berbagai format periode
            if (preg_match('/^(\d{4})-(\d{1,2})$/', $periode, $matches)) {
                $year = intval($matches[1]);
                $month = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{4})\/(\d{1,2})$/', $periode, $matches)) {
                $year = intval($matches[1]);
                $month = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{1,2})-(\d{4})$/', $periode, $matches)) {
                $month = intval($matches[1]);
                $year = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{1,2})\/(\d{4})$/', $periode, $matches)) {
                $month = intval($matches[1]);
                $year = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{4})(\d{2})$/', $periode, $matches)) {
                $year = intval($matches[1]);
                $month = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{2})(\d{4})$/', $periode, $matches)) {
                $month = intval($matches[1]);
                $year = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $periode, $matches)) {
                $year = intval($matches[1]);
                $month = intval($matches[2]);
            }
            
            // Validasi dan return
            if ($year && $month && $month >= 1 && $month <= 12 && $year >= 1900 && $year <= 2100) {
                return $bulan[$month] . ' ' . $year;
            }
            
        } catch (\Exception $e) {
            Log::warning('Error formatting periode: ' . $periode);
        }
        
        return $periode;
    }

    /**
     * Calculate jatuh tempo tanpa Carbon
     */
    private function calculateJatuhTempo($periode)
    {
        if (!$periode) return 'Tidak diketahui';
        
        try {
            $year = null;
            $month = null;
            
            // Parse periode (sama seperti formatPeriode)
            if (preg_match('/^(\d{4})-(\d{1,2})$/', $periode, $matches)) {
                $year = intval($matches[1]);
                $month = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{4})\/(\d{1,2})$/', $periode, $matches)) {
                $year = intval($matches[1]);
                $month = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{1,2})-(\d{4})$/', $periode, $matches)) {
                $month = intval($matches[1]);
                $year = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{1,2})\/(\d{4})$/', $periode, $matches)) {
                $month = intval($matches[1]);
                $year = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{4})(\d{2})$/', $periode, $matches)) {
                $year = intval($matches[1]);
                $month = intval($matches[2]);
            }
            elseif (preg_match('/^(\d{2})(\d{4})$/', $periode, $matches)) {
                $month = intval($matches[1]);
                $year = intval($matches[2]);
            }
            
            if ($year && $month && $month >= 1 && $month <= 12) {
                // Hitung bulan berikutnya
                $nextMonth = $month + 1;
                $nextYear = $year;
                
                if ($nextMonth > 12) {
                    $nextMonth = 1;
                    $nextYear++;
                }
                
                // Hari terakhir bulan berikutnya
                $daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                
                // Cek tahun kabisat untuk Februari
                if ($nextMonth == 2 && (($nextYear % 4 == 0 && $nextYear % 100 != 0) || ($nextYear % 400 == 0))) {
                    $lastDay = 29;
                } else {
                    $lastDay = $daysInMonth[$nextMonth - 1];
                }
                
                return sprintf('%02d/%02d/%04d', $lastDay, $nextMonth, $nextYear);
            }
            
        } catch (\Exception $e) {
            Log::warning('Error calculating jatuh tempo: ' . $periode);
        }
        
        return 'Tidak diketahui';
    }

    /**
     * Set current periode untuk quick filter
     */
    public function setCurrentPeriode($periode)
    {
        return redirect()->route('cektagihan', ['periode' => $periode]);
    }

    /**
     * Debug periode info
     */
    public function getPeriodeInfo()
    {
        $user = Auth::user();
        
        return response()->json([
            'original_periode' => $user->periode_terakhir,
            'formatted_periode' => $this->formatPeriode($user->periode_terakhir),
            'jatuh_tempo' => $this->calculateJatuhTempo($user->periode_terakhir),
            'debug_info' => [
                'periode_type' => gettype($user->periode_terakhir),
                'periode_length' => strlen($user->periode_terakhir ?? ''),
                'periode_pattern' => $this->detectPeriodePattern($user->periode_terakhir),
                'current_time' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Detect periode pattern untuk debugging
     */
    private function detectPeriodePattern($periode)
    {
        if (!$periode) return 'empty';
        
        if (preg_match('/^\d{4}-\d{1,2}$/', $periode)) return 'Y-m (2024-01)';
        if (preg_match('/^\d{4}\/\d{1,2}$/', $periode)) return 'Y/m (2024/01)';
        if (preg_match('/^\d{1,2}-\d{4}$/', $periode)) return 'm-Y (01-2024)';
        if (preg_match('/^\d{1,2}\/\d{4}$/', $periode)) return 'm/Y (01/2024)';
        if (preg_match('/^\d{6}$/', $periode)) return 'Ym (202401)';
        if (preg_match('/^\d{2}\d{4}$/', $periode)) return 'mY (012024)';
        if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $periode)) return 'Y-m-d (2024-01-01)';
        if (preg_match('/^\d{8}$/', $periode)) return 'Ymd/dmY (20240101)';
        if (preg_match('/^\d+$/', $periode)) return 'numeric (' . strlen($periode) . ' digits)';
        
        return 'unknown: ' . $periode;
    }
}