<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Services\WhatsAppService; // Tambah import ini
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Tambah import ini

class AdminPengaduanController extends Controller
{
    // Hapus __construct() middleware

    public function index(Request $request)
    {
        $query = Pengaduan::query();

        // Filter berdasarkan search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('id_pelanggan', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan prioritas
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        $pengaduan = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => Pengaduan::count(),
            'pending' => Pengaduan::where('status', 'pending')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditutup' => Pengaduan::where('status', 'ditutup')->count(),
        ];

        return view('admin.pengaduan.index', compact('pengaduan', 'stats'));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

  public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditutup',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'response_admin' => 'nullable|string'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        
        // Simpan status lama untuk logging
        $oldStatus = $pengaduan->status;
        
        $pengaduan->update([
            'status' => $request->status,
            'prioritas' => $request->prioritas,
            'response_admin' => $request->response_admin,
            'tanggal_response' => now(),
            'admin_id' => auth()->id()
        ]);

        // Kirim notifikasi WhatsApp ke pelanggan jika nomor HP tersedia
        if (!empty($pengaduan->no_hp)) {
            try {
                $whatsAppService = new WhatsAppService();
                
                // Generate ticket number jika belum ada
                $ticketNumber = $pengaduan->ticket_number ?? ('TK-' . str_pad($pengaduan->id, 6, '0', STR_PAD_LEFT));
                
                // Kirim notifikasi update status
                $whatsAppSent = $whatsAppService->sendStatusUpdate(
                    $pengaduan->no_hp,
                    $ticketNumber,
                    $request->status,
                    $request->response_admin
                );

                if ($whatsAppSent) {
                    Log::info('WhatsApp notification sent successfully from AdminPengaduanController', [
                        'pengaduan_id' => $id,
                        'phone' => $pengaduan->no_hp,
                        'old_status' => $oldStatus,
                        'new_status' => $request->status,
                        'ticket' => $ticketNumber,
                        'admin_id' => auth()->id()
                    ]);
                    
                    return redirect()->back()->with('success', 'Status pengaduan berhasil diupdate dan notifikasi WhatsApp telah dikirim');
                } else {
                    Log::warning('WhatsApp notification failed to send from AdminPengaduanController', [
                        'pengaduan_id' => $id,
                        'phone' => $pengaduan->no_hp,
                        'old_status' => $oldStatus,
                        'new_status' => $request->status
                    ]);
                    
                    return redirect()->back()->with('success', 'Status pengaduan berhasil diupdate, namun notifikasi WhatsApp gagal dikirim');
                }

            } catch (\Exception $e) {
                // Log error tapi jangan gagalkan update status
                Log::error('Failed to send WhatsApp notification from AdminPengaduanController', [
                    'pengaduan_id' => $id,
                    'phone' => $pengaduan->no_hp,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'admin_id' => auth()->id()
                ]);
                
                return redirect()->back()->with('warning', 'Status pengaduan berhasil diupdate, namun terjadi kesalahan saat mengirim notifikasi WhatsApp');
            }
        } else {
            Log::info('No phone number available for WhatsApp notification from AdminPengaduanController', [
                'pengaduan_id' => $id,
                'customer_name' => $pengaduan->nama_pelanggan ?? 'Unknown',
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'admin_id' => auth()->id()
            ]);
            
            return redirect()->back()->with('success', 'Status pengaduan berhasil diupdate (nomor HP tidak tersedia untuk notifikasi)');
        }
    }
    public function downloadFile($id, $fileIndex)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $files = $pengaduan->files;
        
        if (isset($files[$fileIndex])) {
            $file = $files[$fileIndex];
            $path = storage_path('app/public/' . $file['path']);
            
            if (file_exists($path)) {
                return response()->download($path, $file['original_name']);
            }
        }
        
        abort(404, 'File tidak ditemukan');
    }

    public function exportExcel(Request $request)
    {
        // Implementasi export Excel jika diperlukan
        return response()->json(['message' => 'Export Excel feature coming soon']);
    }
}