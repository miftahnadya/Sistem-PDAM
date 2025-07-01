<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $pengaduan = Pengaduan::where('id_pel', $user->id_pel)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.pengaduan', compact('pengaduan', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_pengaduan' => 'required|min:10|max:500',
        ], [
            'isi_pengaduan.required' => 'Isi pengaduan wajib diisi',
            'isi_pengaduan.min' => 'Isi pengaduan minimal 10 karakter',
            'isi_pengaduan.max' => 'Isi pengaduan maksimal 500 karakter',
        ]);

        Pengaduan::create([
            'id_pel' => Auth::user()->id_pel,
            'isi_pengaduan' => $request->isi_pengaduan,
            'status' => 'Menunggu',
            'tanggal_pengaduan' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim!');
    }
}