<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('cektagihan');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama_pelanggan' => ['required'],
            'id_pelanggan' => ['required'],
        ]);

        $user = User::where('nama_pelanggan', $credentials['nama_pelanggan'])
            ->where('id_pelanggan', $credentials['id_pelanggan'])
            ->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('cektagihan');
        }

        return back()->withErrors([
            'nama_pelanggan' => 'Nama pelanggan atau ID pelanggan salah.',
        ])->onlyInput('nama_pelanggan');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}