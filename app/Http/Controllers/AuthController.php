<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        if (session()->has('user')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:50',
            'nim' => 'required|min:8|max:15'
        ]);

        session([
            'user' => [
                'nama' => $request->nama,
                'nim' => $request->nim,
                'prodi' => 'Sistem Informasi',
                'login_time' => now()
            ]
        ]);

        return redirect()->route('dashboard')->with('success', 'Login berhasil!');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
};