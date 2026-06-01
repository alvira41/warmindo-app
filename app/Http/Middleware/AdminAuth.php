<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // cek apakah sudah login
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Silakan login dulu');
        }

        return $next($request);
    }
}