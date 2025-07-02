<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    public function index()
    {
        return view('pengaduanpelanggan');
    }
    
    public function store(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'nama_pelanggan' => 'required|string|max:255',
                'id_pelanggan' => 'required|string|max:50',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:20',
                'kategori' => 'required|in:kualitas_air,ketersediaan_air,tagihan,pelayanan,perbaikan,lainnya',
                'judul' => 'required|string|max:255',
                'detail_pengaduan' => 'required|string',
                'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'agreement' => 'required|accepted'
            ], [
                'nama_pelanggan.required' => 'Nama pelanggan wajib diisi',
                'id_pelanggan.required' => 'ID pelanggan wajib diisi',
                'alamat.required' => 'Alamat wajib diisi',
                'no_hp.required' => 'Nomor HP wajib diisi',
                'kategori.required' => 'Kategori pengaduan wajib dipilih',
                'judul.required' => 'Judul pengaduan wajib diisi',
                'detail_pengaduan.required' => 'Detail pengaduan wajib diisi',
                'files.*.mimes' => 'File harus berformat JPG, PNG, atau PDF',
                'files.*.max' => 'Ukuran file maksimal 5MB',
                'agreement.required' => 'Anda harus menyetujui pernyataan'
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data tidak valid',
                        'errors' => $validator->errors()
                    ], 422);
                }
                
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Start database transaction
            DB::beginTransaction();

            // Handle file uploads
            $uploadedFiles = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    if ($file->isValid()) {
                        $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('pengaduan', $filename, 'public');
                        
                        $uploadedFiles[] = [
                            'original_name' => $file->getClientOriginalName(),
                            'stored_name' => $filename,
                            'path' => $path,
                            'size' => $file->getSize(),
                            'type' => $file->getMimeType()
                        ];
                    }
                }
            }

            // Generate ticket number
            $ticketNumber = $this->generateTicketNumber();

            // Create pengaduan
            $pengaduan = Pengaduan::create([
                'ticket_number' => $ticketNumber,
                'nama_pelanggan' => $request->nama_pelanggan,
                'id_pelanggan' => $request->id_pelanggan,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'kategori' => $request->kategori,
                'judul' => $request->judul,
                'detail_pengaduan' => $request->detail_pengaduan,
                'files' => json_encode($uploadedFiles), // Pastikan ini di-encode sebagai JSON
                'status' => 'pending',
                'tanggal_pengaduan' => now(),
                'user_id' => Auth::id() // Jika ada relasi dengan user
            ]);

            // Commit transaction
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengaduan berhasil dikirim',
                    'ticket_number' => $pengaduan->ticket_number
                ]);
            }
            
            return redirect()->back()->with([
                'success' => 'Pengaduan berhasil dikirim',
                'ticket_number' => $pengaduan->ticket_number
            ]);

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            
            // Log error
            Log::error('Error creating pengaduan: ' . $e->getMessage(), [
                'request_data' => $request->except(['files', '_token']),
                'user_id' => Auth::id(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan pengaduan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengaduan. Silakan coba lagi.');
        }
    }

    /**
     * Generate unique ticket number
     */
    private function generateTicketNumber()
    {
        $date = now()->format('Ymd');
        $lastTicket = Pengaduan::where('ticket_number', 'like', "PDAM{$date}%")
                               ->orderBy('ticket_number', 'desc')
                               ->first();
        
        if ($lastTicket) {
            $lastNumber = (int) substr($lastTicket->ticket_number, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return "PDAM{$date}" . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function success($ticketNumber)
    {
        $pengaduan = Pengaduan::where('ticket_number', $ticketNumber)->firstOrFail();
        return view('pengaduan.success', compact('pengaduan'));
    }

    public function track()
    {
        return view('pengaduan.track');
    }

    /**
     * Track result untuk AJAX
     */
    public function trackResult(Request $request)
    {
        try {
            $request->validate([
                'ticket_number' => 'required|string'
            ]);

            $pengaduan = Pengaduan::where('ticket_number', $request->ticket_number)->first();

            if (!$pengaduan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengaduan tidak ditemukan'
                ]);
            }

            return response()->json([
                'success' => true,
                'pengaduan' => $pengaduan
            ]);

        } catch (\Exception $e) {
            Log::error('Error tracking pengaduan: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}