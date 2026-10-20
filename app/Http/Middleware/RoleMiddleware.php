<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        // Ambil user yang sedang login dari session
        $userId = session('user_id');

        // Jika belum login
        if (!$userId) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil role user
        $user = \App\Models\User::find($userId);

        // Jika user tidak ditemukan
        if (!$user) {
            session()->flush();

            return redirect()
                ->route('login')
                ->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Cek apakah role user diizinkan
        if (!in_array($user->role, $roles)) {
            abort(
                403,
                'Anda tidak memiliki izin untuk mengakses halaman ini.'
            );
        }

        return $next($request);
    }
}