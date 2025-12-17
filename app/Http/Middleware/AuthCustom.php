<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login menggunakan Laravel Auth
        if (!Auth::check()) {
            // Log untuk debugging
            Log::warning('Unauthorized access attempt', [
                'url' => $request->url(),
                'ip' => $request->ip()
            ]);
            
            // Simpan pesan error
            session()->flash('error', 'Silakan login terlebih dahulu');
            
            // Redirect ke halaman login
            return redirect()->route('login');
        }
        
        // Log successful auth check
        Log::info('Auth check passed', [
            'user_id' => Auth::id(),
            'url' => $request->url()
        ]);
        
        // Lanjutkan request jika sudah login
        return $next($request);
    }
}