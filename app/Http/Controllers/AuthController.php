<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
    $validated = $request->validate([
        'nim' => 'required|string',
        'password' => 'required|string', // Validasi password
    ]);

    // Cari user
    $user = User::where('nim', $validated['nim'])->first();

    // Cek User DAN Password
    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return back()->withErrors(['nim' => 'NIM atau Password salah!']);
    }

    Auth::login($user); 
    return redirect()->route('dashboard')->with('success', 'Login berhasil!');
}

    
    public function apiLogin(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nim'      => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Cari User berdasarkan NIM
        $user = User::where('nim', $request->nim)->first();

        // 3. Cek Password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'NIM atau Password salah!'
            ], 401);
        }

        // 4. Bikin Token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Kirim Response JSON
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
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
