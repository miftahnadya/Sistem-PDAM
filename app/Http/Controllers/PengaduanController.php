<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    // Hapus __construct() karena middleware sudah diatur di routes

    public function index()
    {
        return view('pengaduanpelanggan');
    }
    
    public function store(Request $request)
    {
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle file uploads
        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
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

        // Create pengaduan
        $pengaduan = Pengaduan::create([
            'ticket_number' => Pengaduan::generateTicketNumber(),
            'nama_pelanggan' => $request->nama_pelanggan,
            'id_pelanggan' => $request->id_pelanggan,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'kategori' => $request->kategori,
            'judul' => $request->judul,
            'detail_pengaduan' => $request->detail_pengaduan,
            'files' => $uploadedFiles,
            'status' => 'pending'
        ]);

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
    }

    public function success($ticketNumber)
    {
        $pengaduan = Pengaduan::where('ticket_number', $ticketNumber)->firstOrFail();
        return view('pengaduan.succes', compact('pengaduan')); // Ubah dari 'succes' ke 'success'
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
        $request->validate([
            'ticket_number' => 'required|string'
        ]);

        try {
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
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}