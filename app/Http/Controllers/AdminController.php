<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Pastikan hanya admin yang bisa akses
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboardmasyarakat')->with('error', 'Akses ditolak!');
        }

        try {
            // Statistics untuk dashboard admin dengan pengecekan tabel
            $stats = [
                'total_pelanggan' => User::where('role', 'user')->count(),
            ];

            // Cek apakah tabel tagihan ada
            if (DB::getSchemaBuilder()->hasTable('tagihan')) {
                $stats['total_tagihan'] = DB::table('tagihan')->count();
                $stats['tagihan_lunas'] = DB::table('tagihan')->where('status_bayar', 'LUNAS')->count();
                $stats['tagihan_belum_lunas'] = DB::table('tagihan')->where('status_bayar', 'BELUM_LUNAS')->count();
                $stats['total_pemakaian'] = DB::table('tagihan')->sum('pemakaian') ?? 0;
                $stats['total_pendapatan'] = DB::table('tagihan')->where('status_bayar', 'LUNAS')->sum('total_tagihan') ?? 0;

                // Debug: cek data tagihan
                $tagihan_count = DB::table('tagihan')->count();
                Log::info('Total tagihan dalam database: ' . $tagihan_count);

                // Data tagihan terbaru dengan pengecekan yang lebih detail
                $tagihan_terbaru = DB::table('tagihan')
                    ->leftJoin('users', function($join) {
                        $join->on('tagihan.id_pel', '=', 'users.id_pel')
                             ->where('users.role', '=', 'user');
                    })
                    ->select(
                        'tagihan.id_tagihan',
                        'tagihan.id_pel',
                        'tagihan.periode',
                        'tagihan.bulan',
                        'tagihan.tahun',
                        'tagihan.total_tagihan',
                        'tagihan.status_bayar',
                        'tagihan.created_at',
                        'users.nama_pelanggan'
                    )
                    ->orderBy('tagihan.created_at', 'desc')
                    ->limit(5)
                    ->get();

                Log::info('Tagihan terbaru count: ' . $tagihan_terbaru->count());
                Log::info('Tagihan terbaru data: ', $tagihan_terbaru->toArray());

                // Konversi created_at ke Carbon
                $tagihan_terbaru = $tagihan_terbaru->map(function ($tagihan) {
                    if (is_string($tagihan->created_at)) {
                        $tagihan->created_at = \Carbon\Carbon::parse($tagihan->created_at);
                    }
                    return $tagihan;
                });

            } else {
                // Jika tabel tagihan tidak ada, set default values
                $stats['total_tagihan'] = 0;
                $stats['tagihan_lunas'] = 0;
                $stats['tagihan_belum_lunas'] = 0;
                $stats['total_pemakaian'] = 0;
                $stats['total_pendapatan'] = 0;
                $tagihan_terbaru = collect();
                Log::warning('Tabel tagihan tidak ditemukan');
            }

            // Cek apakah tabel pengaduan ada
            if (DB::getSchemaBuilder()->hasTable('pengaduan')) {
                $stats['total_pengaduan'] = DB::table('pengaduan')->count();
                $stats['pengaduan_pending'] = DB::table('pengaduan')->where('status', 'pending')->count();
                $stats['pengaduan_diproses'] = DB::table('pengaduan')->where('status', 'diproses')->count();
                $stats['pengaduan_selesai'] = DB::table('pengaduan')->where('status', 'selesai')->count();
                
                // Data pengaduan terbaru dengan konversi created_at ke Carbon
                $pengaduan_terbaru = DB::table('pengaduan')
                    ->leftJoin('users', 'pengaduan.user_id', '=', 'users.id')
                    ->select('pengaduan.*', 'users.nama_pelanggan')
                    ->orderBy('pengaduan.created_at', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($pengaduan) {
                        // Pastikan created_at adalah Carbon instance
                        if (is_string($pengaduan->created_at)) {
                            $pengaduan->created_at = \Carbon\Carbon::parse($pengaduan->created_at);
                        }
                        return $pengaduan;
                    });
            } else {
                $stats['total_pengaduan'] = 0;
                $stats['pengaduan_pending'] = 0;
                $stats['pengaduan_diproses'] = 0;
                $stats['pengaduan_selesai'] = 0;
                $pengaduan_terbaru = collect();
            }

            return view('admin.dashboard', compact('stats', 'pengaduan_terbaru', 'tagihan_terbaru'));

        } catch (\Exception $e) {
            Log::error('Error in dashboard: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Fallback dengan data kosong
            $stats = [
                'total_pelanggan' => 0,
                'total_tagihan' => 0,
                'tagihan_lunas' => 0,
                'tagihan_belum_lunas' => 0,
                'total_pemakaian' => 0,
                'total_pendapatan' => 0,
                'total_pengaduan' => 0,
                'pengaduan_pending' => 0,
                'pengaduan_diproses' => 0,
                'pengaduan_selesai' => 0,
            ];
            
            return view('admin.dashboard', [
                'stats' => $stats,
                'pengaduan_terbaru' => collect(),
                'tagihan_terbaru' => collect()
            ])->with('error', 'Terjadi kesalahan dalam memuat dashboard');
        }
    }

    public function dataPelanggan()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboardmasyarakat')->with('error', 'Akses ditolak!');
        }

        $pelanggan = User::where('role', 'user')->paginate(15);
        return view('admin.data-pelanggan', compact('pelanggan'));
    }

public function isiTagihan()
{
    try {
        Log::info('Accessing isiTagihan method');
        
        // Cek apakah tabel tagihan ada
        if (!DB::getSchemaBuilder()->hasTable('tagihan')) {
            Log::error('Tabel tagihan tidak ditemukan');
            return view('admin.isitagihan', [
                'pelanggan' => collect(),
                'tagihan_data' => collect(),
                'recent_tagihan' => collect(), // Tambahkan ini
                'total_tagihan' => 0,
                'total_pelanggan' => 0,
                'pelanggan_aktif' => 0,
                'pelanggan_tidak_aktif' => 0,
                'total_pemakaian' => 0
            ])->with('error', 'Tabel tagihan tidak ditemukan');
        }

        // Ambil data tagihan dengan join ke users berdasarkan id_pel
        $tagihan_data = DB::table('tagihan')
            ->leftJoin('users', function($join) {
                $join->on('tagihan.id_pel', '=', 'users.id_pel')
                     ->where('users.role', '=', 'user');
            })
            ->select(
                'tagihan.*',
                'users.nama_pelanggan',
                'users.alamat',
                'users.no_telepon'
            )
            ->orderBy('tagihan.created_at', 'desc')
            ->get();

        Log::info('Tagihan data count: ' . $tagihan_data->count());

        // Ambil data pelanggan yang memiliki id_pel
        $pelanggan = User::where('role', 'user')
            ->whereNotNull('id_pel')
            ->orderBy('nama_pelanggan', 'asc')
            ->get();

        Log::info('Pelanggan data count: ' . $pelanggan->count());

        // Ambil tagihan terbaru untuk ditampilkan di tabel (limit 10)
        $recent_tagihan = DB::table('tagihan')
            ->leftJoin('users', function($join) {
                $join->on('tagihan.id_pel', '=', 'users.id_pel')
                     ->where('users.role', '=', 'user');
            })
            ->select(
                'tagihan.id_tagihan',
                'tagihan.id_pel',
                'tagihan.bulan',
                'tagihan.tahun',
                'tagihan.pemakaian',
                'tagihan.total_tagihan',
                'tagihan.status_bayar',
                'tagihan.created_at',
                'users.nama_pelanggan'
            )
            ->orderBy('tagihan.created_at', 'desc')
            ->limit(10)
            ->get();

        Log::info('Recent tagihan count: ' . $recent_tagihan->count());

        // Hitung statistik
        $total_tagihan = $tagihan_data->sum('total_tagihan') ?? 0;
        $total_pelanggan = $pelanggan->count();
        $pelanggan_aktif = $pelanggan->where('status_pelanggan', 'AKTIF')->count();
        $pelanggan_tidak_aktif = $pelanggan->where('status_pelanggan', '!=', 'AKTIF')->count();
        $total_pemakaian = $tagihan_data->sum('pemakaian') ?? 0;

        return view('admin.isitagihan', compact(
            'pelanggan',
            'tagihan_data',
            'recent_tagihan', // Pastikan ini dikirim
            'total_tagihan',
            'total_pelanggan',
            'pelanggan_aktif',
            'pelanggan_tidak_aktif',
            'total_pemakaian'
        ));

    } catch (\Exception $e) {
        Log::error('Error in isiTagihan: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return view('admin.isitagihan', [
            'pelanggan' => collect(),
            'tagihan_data' => collect(),
            'recent_tagihan' => collect(), // Tambahkan ini
            'total_tagihan' => 0,
            'total_pelanggan' => 0,
            'pelanggan_aktif' => 0,
            'pelanggan_tidak_aktif' => 0,
            'total_pemakaian' => 0
        ])->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function inputTagihan()
    {
        try {
            // Ambil semua pelanggan yang memiliki id_pel untuk dropdown
            $pelanggan = User::where('role', 'user')
                ->whereNotNull('id_pel')
                ->orderBy('nama_pelanggan', 'asc')
                ->get();

            Log::info('Pelanggan untuk input tagihan: ' . $pelanggan->count());
                
            // Ambil tarif
            $tarif = DB::table('tarif')->first();
            if (!$tarif) {
                $tarif = $this->createDefaultTarif();
            }
            
            return view('admin.input-tagihan', compact('pelanggan', 'tarif'));
            
        } catch (\Exception $e) {
            Log::error('Error in inputTagihan: ' . $e->getMessage());
            return redirect()->route('admin.isitagihan')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function inputTagihanForUser($id_pel)
    {
        try {
            // Cari pelanggan berdasarkan id_pel
            $pelanggan = User::where('id_pel', $id_pel)
                ->where('role', 'user')
                ->first();
            
            if (!$pelanggan) {
                return redirect()->route('admin.isitagihan')
                    ->with('error', 'Pelanggan dengan ID ' . $id_pel . ' tidak ditemukan');
            }
            
            $tarif = DB::table('tarif')->first();
            if (!$tarif) {
                $tarif = $this->createDefaultTarif();
            }
            
            return view('admin.input-tagihan', compact('pelanggan', 'tarif'));
            
        } catch (\Exception $e) {
            Log::error('Error in inputTagihanForUser: ' . $e->getMessage());
            return redirect()->route('admin.isitagihan')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function searchPelanggan($id_pel)
    {
        try {
            Log::info('Searching for pelanggan with ID: ' . $id_pel);
            
            // Cari pelanggan berdasarkan id_pel di tabel users
            $pelanggan = User::where('id_pel', $id_pel)
                ->where('role', 'user')
                ->first();

            // Jika tidak ditemukan di users, coba cari di tabel pelanggan jika ada
            if (!$pelanggan && DB::getSchemaBuilder()->hasTable('pelanggan')) {
                $pelanggan_data = DB::table('pelanggan')
                    ->where('id_pel', $id_pel)
                    ->first();
                
                if ($pelanggan_data) {
                    Log::info('Pelanggan ditemukan di tabel pelanggan: ' . $pelanggan_data->nama_pelanggan);
                    
                    // Ambil tagihan terakhir
                    $tagihan_terakhir = DB::table('tagihan')
                        ->where('id_pel', $id_pel)
                        ->orderBy('created_at', 'desc')
                        ->first();
                        
                    // Ambil informasi tarif
                    $tarif_info = DB::table('tarif')->first();
                    if (!$tarif_info) {
                        $tarif_info = $this->createDefaultTarif();
                    }
                    
                    return response()->json([
                        'success' => true,
                        'pelanggan' => [
                            'id_pel' => $pelanggan_data->id_pel,
                            'nama_pelanggan' => $pelanggan_data->nama_pelanggan,
                            'alamat' => $pelanggan_data->alamat ?? 'N/A',
                            'no_telepon' => $pelanggan_data->no_telepon ?? 'N/A',
                            'email' => $pelanggan_data->email ?? 'N/A',
                            'status_pelanggan' => $pelanggan_data->status_pelanggan ?? 'AKTIF',
                            'goltar' => $pelanggan_data->goltar ?? '21'
                        ],
                        'tagihan_terakhir' => $tagihan_terakhir,
                        'tarif_info' => $tarif_info
                    ]);
                }
            }
                
            if (!$pelanggan) {
                Log::warning('Pelanggan tidak ditemukan dengan ID: ' . $id_pel);
                return response()->json([
                    'success' => false,
                    'message' => 'Pelanggan dengan ID ' . $id_pel . ' tidak ditemukan'
                ], 404);
            }
            
            Log::info('Pelanggan ditemukan: ' . $pelanggan->nama_pelanggan);
            
            // Ambil tagihan terakhir untuk referensi
            $tagihan_terakhir = DB::table('tagihan')
                ->where('id_pel', $id_pel)
                ->orderBy('created_at', 'desc')
                ->first();
                
            // Ambil informasi tarif
            $tarif_info = DB::table('tarif')->first();
            if (!$tarif_info) {
                $tarif_info = $this->createDefaultTarif();
            }
            
            return response()->json([
                'success' => true,
                'pelanggan' => [
                    'id_pel' => $pelanggan->id_pel,
                    'nama_pelanggan' => $pelanggan->nama_pelanggan,
                    'alamat' => $pelanggan->alamat,
                    'no_telepon' => $pelanggan->no_telepon ?? 'N/A',
                    'email' => $pelanggan->email ?? 'N/A',
                    'status_pelanggan' => $pelanggan->status_pelanggan ?? 'AKTIF',
                    'goltar' => $pelanggan->goltar ?? '21'
                ],
                'tagihan_terakhir' => $tagihan_terakhir,
                'tarif_info' => $tarif_info
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error searching pelanggan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeTagihan(Request $request)
    {
        try {
            Log::info('Received tagihan data:', $request->all());
            
            DB::beginTransaction();
            
            // Validasi input
            $request->validate([
                'id_pel' => 'required|string',
                'bulan' => 'required|integer|min:1|max:12',
                'tahun' => 'required|integer|min:2020|max:2030',
                'meter_awal' => 'required|numeric|min:0',
                'meter_akhir' => 'required|numeric|min:0',
                'tarif_per_m3' => 'required|numeric|min:0',
                'biaya_admin' => 'required|numeric|min:0',
                'total_tagihan' => 'required|numeric|min:0',
            ]);
            
            // Cek apakah pelanggan ada di tabel users berdasarkan id_pel
            $pelanggan = User::where('id_pel', $request->id_pel)
                ->where('role', 'user')
                ->first();

            // Jika tidak ada di users, cek di tabel pelanggan
            if (!$pelanggan && DB::getSchemaBuilder()->hasTable('pelanggan')) {
                $pelanggan_exists = DB::table('pelanggan')
                    ->where('id_pel', $request->id_pel)
                    ->exists();
                
                if (!$pelanggan_exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pelanggan dengan ID ' . $request->id_pel . ' tidak ditemukan'
                    ]);
                }
            } elseif (!$pelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pelanggan dengan ID ' . $request->id_pel . ' tidak ditemukan'
                ]);
            }
            
            // Cek apakah tagihan sudah ada untuk periode ini
            $periode = sprintf('%04d%02d', $request->tahun, $request->bulan);
            $existing_tagihan = DB::table('tagihan')
                ->where('id_pel', $request->id_pel)
                ->where('periode', $periode)
                ->first();
                
            if ($existing_tagihan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tagihan untuk periode ' . $request->bulan . '/' . $request->tahun . ' sudah ada'
                ]);
            }
            
            // Hitung pemakaian
            $pemakaian = $request->meter_akhir - $request->meter_awal;
            
            if ($pemakaian < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Meter akhir tidak boleh kurang dari meter awal'
                ]);
            }
            
            // Generate ID tagihan
            $id_tagihan = $this->generateIdTagihan();
            
            // Simpan tagihan
            $tagihan_data = [
                'id_tagihan' => $id_tagihan,
                'id_pel' => $request->id_pel,
                'periode' => $periode,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'meter_awal' => $request->meter_awal,
                'meter_akhir' => $request->meter_akhir,
                'pemakaian' => $pemakaian,
                'tarif_per_m3' => $request->tarif_per_m3,
                'biaya_admin' => $request->biaya_admin,
                'total_tagihan' => $request->total_tagihan,
                'status_bayar' => 'BELUM_LUNAS',
                'tgl_tagihan' => now(),
                'tgl_batas_bayar' => now()->addDays(30),
                'keterangan' => $request->keterangan ?? '',
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            Log::info('Inserting tagihan data:', $tagihan_data);
            
            $inserted = DB::table('tagihan')->insert($tagihan_data);
            
            if (!$inserted) {
                throw new \Exception('Gagal menyimpan data tagihan');
            }
            
            DB::commit();
            
            Log::info('Tagihan berhasil disimpan dengan ID: ' . $id_tagihan);
            
            return response()->json([
                'success' => true,
                'message' => 'Tagihan berhasil disimpan',
                'id_tagihan' => $id_tagihan
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all())
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error storing tagihan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function editTagihan($id_tagihan)
    {
        try {
            $tagihan = DB::table('tagihan')
                ->leftJoin('users', 'tagihan.id_pel', '=', 'users.id_pel')
                ->select('tagihan.*', 'users.nama_pelanggan')
                ->where('tagihan.id_tagihan', $id_tagihan)
                ->first();
                
            if (!$tagihan) {
                return redirect()->route('admin.isitagihan')
                    ->with('error', 'Tagihan tidak ditemukan');
            }
                
            $tarif = DB::table('tarif')->first();
            if (!$tarif) {
                $tarif = $this->createDefaultTarif();
            }
            
            return view('admin.edit-tagihan', compact('tagihan', 'tarif'));
            
        } catch (\Exception $e) {
            Log::error('Error in editTagihan: ' . $e->getMessage());
            return redirect()->route('admin.isitagihan')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateTagihan(Request $request, $id_tagihan)
    {
        $request->validate([
            'meter_akhir' => 'required|numeric|min:0',
            'tgl_batas_bayar' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $tagihan = DB::table('tagihan')->where('id_tagihan', $id_tagihan)->first();
            
            if (!$tagihan) {
                return back()->with('error', 'Tagihan tidak ditemukan');
            }
            
            $tarif = DB::table('tarif')->first();
            if (!$tarif) {
                $tarif = $this->createDefaultTarif();
            }

            // Hitung ulang pemakaian
            $pemakaian = $request->meter_akhir - $tagihan->meter_awal;

            // Hitung ulang biaya
            $biaya_air = $this->hitungBiayaAir($pemakaian, $tarif);
            $total_tagihan = $biaya_air + $tagihan->biaya_admin;

            // Update tagihan
            DB::table('tagihan')
                ->where('id_tagihan', $id_tagihan)
                ->update([
                    'meter_akhir' => $request->meter_akhir,
                    'pemakaian' => $pemakaian,
                    'total_tagihan' => $total_tagihan,
                    'tgl_batas_bayar' => $request->tgl_batas_bayar,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()->route('admin.isitagihan')
                ->with('success', 'Tagihan berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in updateTagihan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteTagihan($id_tagihan)
    {
        try {
            $tagihan = DB::table('tagihan')->where('id_tagihan', $id_tagihan)->first();
            
            if (!$tagihan) {
                return back()->with('error', 'Tagihan tidak ditemukan');
            }
            
            if ($tagihan->status_bayar == 'LUNAS') {
                return back()->with('error', 'Tagihan yang sudah lunas tidak dapat dihapus');
            }

            DB::table('tagihan')->where('id_tagihan', $id_tagihan)->delete();

            return redirect()->route('admin.isitagihan')
                ->with('success', 'Tagihan berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Error in deleteTagihan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // === PENGADUAN METHODS ===
    public function pengaduan()
    {
        try {
            // Pastikan tabel pengaduan ada
            if (!DB::getSchemaBuilder()->hasTable('pengaduan')) {
                $this->createPengaduanTable();
            }

            $pengaduan = DB::table('pengaduan')
                ->leftJoin('users', 'pengaduan.user_id', '=', 'users.id')
                ->select(
                    'pengaduan.*',
                    'users.nama_pelanggan',
                    'users.id_pel',
                    'users.alamat',
                    'users.no_telepon'
                )
                ->orderBy('pengaduan.created_at', 'desc')
                ->paginate(15);

            return view('admin.pengaduan', compact('pengaduan'));

        } catch (\Exception $e) {
            Log::error('Error in pengaduan: ' . $e->getMessage());
            return view('admin.pengaduan', ['pengaduan' => collect()])->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateStatusPengaduan(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,diproses,selesai',
                'catatan_admin' => 'nullable|string'
            ]);

            $updated = DB::table('pengaduan')
                ->where('id', $id)
                ->update([
                    'status' => $request->status,
                    'catatan_admin' => $request->catatan_admin,
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status pengaduan berhasil diperbarui'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengaduan tidak ditemukan'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error updating pengaduan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function deletePengaduan($id)
    {
        try {
            $deleted = DB::table('pengaduan')->where('id', $id)->delete();

            if ($deleted) {
                return redirect()->route('admin.pengaduan')
                    ->with('success', 'Pengaduan berhasil dihapus');
            } else {
                return redirect()->route('admin.pengaduan')
                    ->with('error', 'Pengaduan tidak ditemukan');
            }

        } catch (\Exception $e) {
            Log::error('Error deleting pengaduan: ' . $e->getMessage());
            return redirect()->route('admin.pengaduan')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // === HELPER METHODS ===
    private function createPengaduanTable()
    {
        try {
            DB::statement('CREATE TABLE IF NOT EXISTS pengaduan (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                judul VARCHAR(255) NOT NULL,
                deskripsi TEXT NOT NULL,
                foto VARCHAR(255) NULL,
                status ENUM("pending", "diproses", "selesai") DEFAULT "pending",
                catatan_admin TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )');
            
            Log::info('Tabel pengaduan berhasil dibuat');
        } catch (\Exception $e) {
            Log::error('Error creating pengaduan table: ' . $e->getMessage());
        }
    }

    private function generateIdTagihan()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = $year . $month;
        
        $lastTagihan = DB::table('tagihan')
            ->where('id_tagihan', 'like', $prefix . '%')
            ->orderBy('id_tagihan', 'desc')
            ->first();
        
        if ($lastTagihan) {
            $lastNumber = (int)substr($lastTagihan->id_tagihan, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    private function createDefaultTarif()
    {
        $defaultTarif = [
            'id_tarif' => 1,
            'nama_tarif' => 'Tarif Default',
            'tarif_1' => 2500,
            'tarif_2' => 3000,
            'tarif_3' => 4000,
            'tarif_4' => 5000,
            'biaya_admin' => 5000,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        try {
            if (!DB::getSchemaBuilder()->hasTable('tarif')) {
                DB::statement('CREATE TABLE tarif (
                    id_tarif INT AUTO_INCREMENT PRIMARY KEY,
                    nama_tarif VARCHAR(100) DEFAULT "Tarif Default",
                    tarif_1 INT DEFAULT 2500,
                    tarif_2 INT DEFAULT 3000,
                    tarif_3 INT DEFAULT 4000,
                    tarif_4 INT DEFAULT 5000,
                    biaya_admin INT DEFAULT 5000,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )');
            }

            DB::table('tarif')->updateOrInsert(
                ['id_tarif' => 1],
                $defaultTarif
            );
            
            return (object) $defaultTarif;
            
        } catch (\Exception $e) {
            Log::error('Error creating default tarif: ' . $e->getMessage());
            return (object) $defaultTarif;
        }
    }

    private function hitungBiayaAir($pemakaian, $tarif)
    {
        $biaya = 0;
        
        $tarif_1 = isset($tarif->tarif_1) ? $tarif->tarif_1 : 2500;
        $tarif_2 = isset($tarif->tarif_2) ? $tarif->tarif_2 : 3000;
        $tarif_3 = isset($tarif->tarif_3) ? $tarif->tarif_3 : 4000;
        $tarif_4 = isset($tarif->tarif_4) ? $tarif->tarif_4 : 5000;
        
        if ($pemakaian <= 10) {
            $biaya = $pemakaian * $tarif_1;
        } elseif ($pemakaian <= 20) {
            $biaya = (10 * $tarif_1) + (($pemakaian - 10) * $tarif_2);
        } elseif ($pemakaian <= 30) {
            $biaya = (10 * $tarif_1) + (10 * $tarif_2) + (($pemakaian - 20) * $tarif_3);
        } else {
            $biaya = (10 * $tarif_1) + (10 * $tarif_2) + (10 * $tarif_3) + (($pemakaian - 30) * $tarif_4);
        }
        
        return $biaya;
    }

    // === UTILITY METHODS ===
    public function getTagihanByPelanggan($id_pel)
    {
        try {
            $tagihan = DB::table('tagihan')
                ->where('id_pel', $id_pel)
                ->orderBy('periode', 'desc')
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => $tagihan
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getPelangganInfo($id_pel)
    {
        try {
            $pelanggan = User::where('id_pel', $id_pel)->first();
                
            if (!$pelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pelanggan tidak ditemukan'
                ]);
            }
                
            return response()->json([
                'success' => true,
                'data' => $pelanggan
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Debug method untuk cek struktur database
    public function debugDatabase()
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $result = [];
            
            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                $columns = DB::select("SHOW COLUMNS FROM $tableName");
                $result[$tableName] = $columns;
            }
            
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Tambahkan method debug untuk membantu troubleshooting
    public function debugTagihan()
    {
        try {
            // Cek apakah tabel tagihan ada
            if (!DB::getSchemaBuilder()->hasTable('tagihan')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tabel tagihan tidak ditemukan'
                ]);
            }

            // Cek struktur tabel tagihan
            $columns = DB::select("SHOW COLUMNS FROM tagihan");
            
            // Cek semua data tagihan
            $all_tagihan = DB::table('tagihan')
                ->select('*')
                ->orderBy('created_at', 'desc')
                ->get();

            // Cek data users dengan id_pel
            $users_with_id_pel = DB::table('users')
                ->whereNotNull('id_pel')
                ->select('id', 'id_pel', 'nama_pelanggan', 'role')
                ->get();

            // Cek join result
            $join_result = DB::table('tagihan')
                ->leftJoin('users', function($join) {
                    $join->on('tagihan.id_pel', '=', 'users.id_pel')
                         ->where('users.role', '=', 'user');
                })
                ->select(
                    'tagihan.id_tagihan',
                    'tagihan.id_pel',
                    'tagihan.created_at',
                    'users.nama_pelanggan',
                    'users.role'
                )
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'table_exists' => true,
                    'columns' => $columns,
                    'total_tagihan' => $all_tagihan->count(),
                    'all_tagihan' => $all_tagihan,
                    'users_with_id_pel' => $users_with_id_pel,
                    'join_result' => $join_result
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    // Method untuk insert sample data tagihan (untuk testing)
    public function insertSampleTagihan()
    {
        try {
            // Pastikan tabel tagihan ada
            if (!DB::getSchemaBuilder()->hasTable('tagihan')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tabel tagihan tidak ditemukan'
                ]);
            }

            // Ambil user pertama yang punya id_pel
            $user = User::where('role', 'user')
                ->whereNotNull('id_pel')
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada user dengan id_pel yang valid'
                ]);
            }

            // Insert sample data
            $sample_data = [
                'id_tagihan' => $this->generateIdTagihan(),
                'id_pel' => $user->id_pel,
                'periode' => date('Ym'),
                'bulan' => date('n'),
                'tahun' => date('Y'),
                'meter_awal' => 100,
                'meter_akhir' => 125,
                'pemakaian' => 25,
                'tarif_per_m3' => 2500,
                'biaya_admin' => 5000,
                'total_tagihan' => 67500,
                'status_bayar' => 'BELUM_LUNAS',
                'tgl_tagihan' => now(),
                'tgl_batas_bayar' => now()->addDays(30),
                'keterangan' => 'Sample data untuk testing',
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $inserted = DB::table('tagihan')->insert($sample_data);

            if ($inserted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sample data berhasil diinsert',
                    'data' => $sample_data
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal insert sample data'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}