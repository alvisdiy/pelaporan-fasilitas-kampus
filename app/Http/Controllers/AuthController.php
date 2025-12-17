<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
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
            'nim' => 'required|string',
        ], [
            'nim.required' => 'NIM wajib diisi',
        ]);

        // Cek apakah user dengan NIM ini ada di database
        $user = User::where('nim', $validated['nim'])->first();

        // Log untuk debugging
        Log::info('Login attempt', [
            'nim' => $validated['nim'],
            'user_found' => $user ? 'yes' : 'no'
        ]);

        if (!$user) {
            return back()
                ->withErrors(['nim' => 'NIM tidak terdaftar di sistem!'])
                ->withInput();
        }

        // Login menggunakan Auth facade Laravel
        Auth::login($user, true); // true = remember me

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // Log successful login
        Log::info('Login successful', [
            'user_id' => $user->id,
            'user_name' => $user->name
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Login berhasil, selamat datang ' . $user->name);
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Log::info('Logout', ['user_id' => Auth::id()]);

        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Logout berhasil!');
    }
}