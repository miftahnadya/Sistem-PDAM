<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class DashboardMasyarakatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan user bukan admin
        if ($user->role === 'admin') {
            return redirect()->route('dashboardadmin');
        }

        // Data statistik pelanggan berdasarkan data aktual
        $stats = [
            'status_pelanggan' => $user->status_pelanggan ?? 'TIDAK AKTIF',
            'status_meter' => $user->status_meter ?? 'TIDAK DIKETAHUI',
            'total_tagihan' => $user->total_tagihan ?? 0,
            'tunggakan_bulan' => $user->jumlah_bulan_rekening ?? 0,
            'pemakaian_air' => $user->total_pemakaian_m3 ?? 0,
            'stand_meter' => $user->angka_meter_kini ?? 0,
        ];

        // Data tagihan berdasarkan data user aktual
        $tagihan_terbaru = [
            'periode' => $user->periode_terakhir ?? 'Tidak ada data',
            'harga_air' => $user->harga_air ?? 0,
            'biaya_admin' => $user->biaya_admin ?? 0,
            'denda' => $user->denda ?? 0,
            'total' => $user->total_tagihan ?? 0,
            'status' => ($user->total_tagihan ?? 0) > 0 ? 'Belum Lunas' : 'Lunas',
            'jatuh_tempo' => $this->calculateJatuhTempoString($user)
        ];

        // Ambil pengaduan user dari database (gunakan try-catch untuk safety)
        $riwayat_pengaduan = collect();
        try {
            if (class_exists(\App\Models\Pengaduan::class)) {
                $riwayat_pengaduan = \App\Models\Pengaduan::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($pengaduan) {
                        return (object)[
                            'id' => $pengaduan->id,
                            'tanggal' => $pengaduan->created_at->format('d M Y'),
                            'judul' => $pengaduan->judul_pengaduan ?? 'Tidak ada judul',
                            'isi_pengaduan' => \Str::limit($pengaduan->isi_pengaduan ?? '', 50),
                            'status' => ucfirst($pengaduan->status ?? 'pending'),
                            'status_class' => $this->getStatusClass($pengaduan->status ?? 'pending')
                        ];
                    });
            }
        } catch (\Exception $e) {
            // Jika model Pengaduan belum ada, gunakan data kosong
            $riwayat_pengaduan = collect();
        }

        // Hitung statistik pengaduan
        $pengaduan_stats = [
            'total' => $riwayat_pengaduan->count(),
            'pending' => $riwayat_pengaduan->where('status', 'Pending')->count(),
            'proses' => $riwayat_pengaduan->where('status', 'Proses')->count(),
            'selesai' => $riwayat_pengaduan->where('status', 'Selesai')->count(),
        ];

        // Informasi jatuh tempo berdasarkan data aktual
        $jatuh_tempo = $this->calculateJatuhTempo($user);

        // Data untuk notifikasi berdasarkan kondisi aktual
        $notifications = $this->generateNotifications($user);

        // Data informasi umum PDAM
        $info_umum = [
            'jam_operasional' => '08:00 - 16:00 WIB',
            'kontak_darurat' => '0811-xxxx-xxxx',
            'email_cs' => 'cs@pdam.go.id',
            'alamat_kantor' => 'Jl. Raya PDAM No. 123'
        ];

        // Data grafik berdasarkan data aktual (jika ada)
        $grafik_data = $this->getGrafikData($user);

        return view('dashboardmasyarakat', compact(
            'user',
            'stats',
            'tagihan_terbaru',
            'riwayat_pengaduan',
            'pengaduan_stats',
            'jatuh_tempo',
            'notifications',
            'info_umum',
            'grafik_data'
        ));
    }

    /**
     * Calculate jatuh tempo string safely
     */
    private function calculateJatuhTempoString($user)
    {
        if (!$user->periode_terakhir) {
            return 'Tidak diketahui';
        }

        try {
            $periode = Carbon::createFromFormat('Y-m', $user->periode_terakhir);
            return $periode->addMonth()->format('d M Y');
        } catch (\Exception $e) {
            return 'Tidak diketahui';
        }
    }

    /**
     * Generate notifications berdasarkan kondisi user
     */
    private function generateNotifications($user)
    {
        $notifications = [];
        
        // Cek tagihan belum lunas
        if (($user->total_tagihan ?? 0) > 0) {
            $notifications[] = [
                'type' => 'warning',
                'icon' => 'fa-exclamation-triangle',
                'title' => 'Tagihan Belum Lunas',
                'message' => 'Anda memiliki tagihan sebesar Rp ' . number_format($user->total_tagihan, 0, ',', '.'),
                'action_text' => 'Lihat Detail',
                'action_url' => route('cektagihan')
            ];
        }

        // Cek status meter bermasalah
        if (in_array($user->status_meter ?? '', ['RUSAK', 'TERTIMBUN', 'TERKUNCI', 'MACET'])) {
            $notifications[] = [
                'type' => 'danger',
                'icon' => 'fa-tools',
                'title' => 'Status Meter: ' . ($user->status_meter ?? 'Bermasalah'),
                'message' => 'Segera laporkan untuk perbaikan meter air Anda',
                'action_text' => 'Buat Laporan',
                'action_url' => '#'
            ];
        }

        // Cek status pelanggan tidak aktif
        if (($user->status_pelanggan ?? '') !== 'AKTIF') {
            $notifications[] = [
                'type' => 'info',
                'icon' => 'fa-user-times',
                'title' => 'Status Pelanggan: ' . ($user->status_pelanggan ?? 'Tidak Aktif'),
                'message' => 'Hubungi kantor PDAM untuk aktivasi layanan',
                'action_text' => 'Hubungi CS',
                'action_url' => '#'
            ];
        }

        // Cek tunggakan banyak
        if (($user->jumlah_bulan_rekening ?? 0) > 3) {
            $notifications[] = [
                'type' => 'danger',
                'icon' => 'fa-calendar-times',
                'title' => 'Tunggakan Tinggi',
                'message' => 'Anda memiliki tunggakan ' . $user->jumlah_bulan_rekening . ' bulan. Segera lakukan pembayaran.',
                'action_text' => 'Bayar Sekarang',
                'action_url' => route('cektagihan')
            ];
        }

        return collect($notifications);
    }

    /**
     * Hitung jatuh tempo berdasarkan data aktual
     */
    private function calculateJatuhTempo($user)
    {
        $jatuh_tempo = [
            'tanggal' => 'Tidak diketahui',
            'hari_tersisa' => 0,
            'status' => 'normal'
        ];

        if ($user->periode_terakhir) {
            try {
                // Asumsi jatuh tempo adalah akhir bulan berikutnya
                $periode = Carbon::createFromFormat('Y-m', $user->periode_terakhir);
                $tanggal_jatuh_tempo = $periode->addMonth()->endOfMonth();
                $hari_tersisa = now()->diffInDays($tanggal_jatuh_tempo, false);

                $jatuh_tempo = [
                    'tanggal' => $tanggal_jatuh_tempo->format('d M Y'),
                    'hari_tersisa' => max(0, $hari_tersisa),
                    'status' => $this->getJatuhTempoStatus($hari_tersisa)
                ];
            } catch (\Exception $e) {
                // Jika error parsing tanggal, gunakan default
            }
        }

        return $jatuh_tempo;
    }

    /**
     * Get status class untuk jatuh tempo
     */
    private function getJatuhTempoStatus($hari_tersisa)
    {
        if ($hari_tersisa < 0) {
            return 'danger'; // Sudah lewat
        }
        if ($hari_tersisa <= 7) {
            return 'warning'; // Kurang dari seminggu
        }
        return 'normal';
    }

    /**
     * Get status class untuk pengaduan
     */
    private function getStatusClass($status)
    {
        $statusLower = strtolower($status);
        
        switch ($statusLower) {
            case 'selesai':
                return 'bg-green-100 text-green-800';
            case 'proses':
                return 'bg-blue-100 text-blue-800';
            case 'pending':
                return 'bg-yellow-100 text-yellow-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    /**
     * Get data grafik berdasarkan data yang tersedia
     */
    private function getGrafikData($user)
    {
        // Untuk saat ini, return data sederhana berdasarkan user
        return [
            'pemakaian_bulan_ini' => $user->total_pemakaian_m3 ?? 0,
            'rata_rata_pemakaian' => 18, // Bisa dihitung dari data historis jika ada
            'pengaduan_bulan_ini' => $this->getPengaduanBulanIni($user),
            'status_pembayaran' => ($user->total_tagihan ?? 0) > 0 ? 'Belum Lunas' : 'Lunas'
        ];
    }

    /**
     * Hitung pengaduan bulan ini
     */
    private function getPengaduanBulanIni($user)
    {
        try {
            if (class_exists(\App\Models\Pengaduan::class)) {
                return \App\Models\Pengaduan::where('user_id', $user->id)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();
            }
        } catch (\Exception $e) {
            // Jika model tidak ada atau error, return 0
        }
        return 0;
    }

    /**
     * Get data for AJAX requests
     */
    public function getStats()
    {
        $user = Auth::user();
        
        return response()->json([
            'status_pelanggan' => $user->status_pelanggan ?? 'TIDAK AKTIF',
            'total_tagihan' => $user->total_tagihan ?? 0,
            'tunggakan_bulan' => $user->jumlah_bulan_rekening ?? 0,
            'pemakaian_air' => $user->total_pemakaian_m3 ?? 0,
            'formatted_tagihan' => 'Rp ' . number_format($user->total_tagihan ?? 0, 0, ',', '.'),
        ]);
    }

    /**
     * Get chart data berdasarkan data aktual
     */
    public function getChartData($type = 'pemakaian')
    {
        $user = Auth::user();
        
        if ($type === 'pemakaian') {
            // Data sederhana untuk pemakaian (bisa dikembangkan dengan data historis)
            $data = [
                'labels' => ['Bulan Lalu', 'Bulan Ini'],
                'datasets' => [
                    [
                        'label' => 'Pemakaian Air (m³)',
                        'data' => [
                            max(($user->total_pemakaian_m3 ?? 0) - 5, 0), // Estimasi bulan lalu
                            $user->total_pemakaian_m3 ?? 0
                        ],
                        'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                        'borderColor' => 'rgba(59, 130, 246, 1)',
                        'borderWidth' => 2
                    ]
                ]
            ];
        } else {
            // Data pengaduan
            $pengaduan_bulan_ini = $this->getPengaduanBulanIni($user);
            $data = [
                'labels' => ['Bulan Lalu', 'Bulan Ini'],
                'datasets' => [
                    [
                        'label' => 'Jumlah Pengaduan',
                        'data' => [max($pengaduan_bulan_ini - 1, 0), $pengaduan_bulan_ini],
                        'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                        'borderColor' => 'rgba(239, 68, 68, 1)',
                        'borderWidth' => 2
                    ]
                ]
            ];
        }

        return response()->json($data);
    }

    /**
     * Quick payment check
     */
    public function quickPaymentCheck()
    {
        $user = Auth::user();
        
        return response()->json([
            'has_bill' => ($user->total_tagihan ?? 0) > 0,
            'amount' => $user->total_tagihan ?? 0,
            'formatted_amount' => 'Rp ' . number_format($user->total_tagihan ?? 0, 0, ',', '.'),
            'periode' => $user->periode_terakhir ?? 'Tidak ada data',
            'status' => ($user->total_tagihan ?? 0) > 0 ? 'unpaid' : 'paid',
            'tunggakan_bulan' => $user->jumlah_bulan_rekening ?? 0
        ]);
    }

    /**
     * Get notifications untuk AJAX
     */
    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = $this->generateNotifications($user);
        
        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        // Implementasi mark as read jika diperlukan
        return response()->json(['success' => true]);
    }
}