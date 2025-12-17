<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    /**
     * Proses login
     */
    public function doLogin(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|min:3|max:50',
            'nim' => 'required|string|min:8|max:15'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 50 karakter',
            'nim.required' => 'NIM wajib diisi',
            'nim.min' => 'NIM minimal 8 karakter',
            'nim.max' => 'NIM maksimal 15 karakter',
        ]);

        // Simpan data user ke session
        session([
            'user' => [
                'nama' => $validated['nama'],
                'nim' => $validated['nim'],
                'prodi' => 'Sistem Informasi',
                'login_time' => now()->toDateTimeString()
            ]
        ]);

        return redirect()->route('dashboard')->with('success', 'Login berhasil! Selamat datang ' . $validated['nama']);
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