<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard'); // Perbaiki route admin
            }
            return redirect('/dashboardmasyarakat');
        }
        
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'nama_pelanggan' => ['required', 'string'],
            'id_pel' => ['required', 'string'],
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi',
            'id_pel.required' => 'ID pelanggan wajib diisi',
        ]);

        try {
            // Cari user berdasarkan nama_pelanggan
            $user = User::where('nama_pelanggan', trim($credentials['nama_pelanggan']))->first();

            // Jika user ditemukan, cek password (id_pel sebagai password)
            if ($user && Hash::check($credentials['id_pel'], $user->password)) {
                // Login user
                Auth::login($user);
                $request->session()->regenerate();

                // Redirect berdasarkan role dengan route yang benar
                if ($user->role === 'admin') {
                    return redirect()->intended('/admin/dashboard')
                        ->with('success', 'Selamat datang Admin, ' . $user->nama_pelanggan . '!');
                } else {
                    return redirect()->intended('/dashboardmasyarakat')
                        ->with('success', 'Selamat datang, ' . $user->nama_pelanggan . '!');
                }
            }

            // Login gagal
            return back()->withErrors([
                'nama_pelanggan' => 'Nama pelanggan atau ID pelanggan tidak valid.',
            ])->withInput();

        } catch (\Exception $e) {
            return back()->withErrors([
                'nama_pelanggan' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout!');
    }
}