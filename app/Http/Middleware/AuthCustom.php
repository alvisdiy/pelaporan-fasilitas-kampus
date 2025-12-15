<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCustom
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user')) {
            session()->flash('error', 'Silakan login terlebih dahulu');
            return redirect()->route('login');
        }
        return $next($request);
    }
}