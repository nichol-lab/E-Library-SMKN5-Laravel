<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        // Cek apakah user sudah login
        if (!session()->has('user_id')) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Pastikan user masih ada di database
        $user = \App\Models\User::find(
            session('user_id')
        );

        if (!$user) {
            session()->flush();

            return redirect()
                ->route('login')
                ->with('error', 'Sesi login tidak valid. Silakan login kembali.');
        }

        return $next($request);
    }
}