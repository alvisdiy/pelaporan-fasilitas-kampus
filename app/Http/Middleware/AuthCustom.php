<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login (ada session user)
        if (!session()->has('user')) {
            // Simpan pesan error
            session()->flash('error', 'Silakan login terlebih dahulu');
            
            // Redirect ke halaman login
            return redirect()->route('login');
        }
        
        // Lanjutkan request jika sudah login
        return $next($request);
    }
}