<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Jika admin, redirect ke halaman admin
        if ($user->role === 'admin') {
            return redirect()->route('isitagihan');
        }

        // Ambil data tagihan user yang sedang login
        $tagihans = collect([$user]); // Wrap dalam collection untuk konsistensi
        
        return view('cektagihan', compact('tagihans', 'user'));
    }

    public function show($id_pel = null)
    {
        $user = Auth::user();
        
        // User biasa hanya bisa lihat tagihan sendiri
        if ($user->role !== 'admin' && $id_pel !== $user->id_pel) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $targetUser = $id_pel ? User::where('id_pel', $id_pel)->firstOrFail() : $user;
        
        return response()->json([
            'success' => true,
            'data' => [
                'id_pel' => $targetUser->id_pel,
                'nama_pelanggan' => $targetUser->nama_pelanggan,
                'alamat' => $targetUser->alamat,
                'periode' => $targetUser->periode_terakhir ?? date('Ym'),
                'total_pemakaian_m3' => $targetUser->total_pemakaian_m3 ?? 0,
                'harga_air' => $targetUser->harga_air ?? 0,
                'biaya_admin' => $targetUser->biaya_admin ?? 5000,
                'denda' => $targetUser->denda ?? 0,
                'total_tagihan' => $targetUser->total_tagihan ?? 0,
                'status_pelanggan' => $targetUser->status_pelanggan,
                'goltar' => $targetUser->goltar,
            ]
        ]);
    }
}