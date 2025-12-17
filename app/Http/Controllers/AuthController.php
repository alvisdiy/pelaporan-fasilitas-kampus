<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Jangan lupa import
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->has('user')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        // Validasi tetep jalan
        $validated = $request->validate([
            'nim' => 'required|string',
        ]);

        // Cek apakah user dengan NIM ini ada di database?
        $user = User::where('nim', $validated['nim'])->first();

        if (!$user) {
            return back()->withErrors(['nim' => 'NIM tidak terdaftar di sistem!']);
        }
        Auth::login($user); 

        return redirect()->route('dashboard')->with('success', 'Login berhasil, selamat datang ' . $user->name);
    }

    /**
     * Proses logout
     */
    public function logout()
    {
        // Hapus semua session
        session()->flush();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
