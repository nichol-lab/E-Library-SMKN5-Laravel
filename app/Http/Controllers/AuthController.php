<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        // Jika pengguna sudah login, arahkan ke dashboard.
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Memproses login pengguna.
     */
    public function login(Request $request)
    {
        // Validasi input dari form login.
        $validated = $request->validate(
            [
                'login' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string'],
            ],
            [
                'login.required' => 'Username atau email wajib diisi.',
                'login.string' => 'Username atau email tidak valid.',
                'login.max' => 'Username atau email terlalu panjang.',
                'password.required' => 'Password wajib diisi.',
                'password.string' => 'Format password tidak valid.',
            ]
        );

        // Bersihkan spasi di awal dan akhir username/email.
        $login = trim($validated['login']);

        // Cari akun berdasarkan username atau email.
        $user = User::where('username', $login)
            ->orWhere('email', $login)
            ->first();

        // Jika akun tidak ditemukan.
        if (!$user) {
            return redirect()
                ->route('login')
                ->withInput($request->only('login'))
                ->with('error', 'Username atau email tidak ditemukan.');
        }

        // Periksa password yang dimasukkan pengguna.
        if (!Hash::check($validated['password'], $user->password)) {
            return redirect()
                ->route('login')
                ->withInput($request->only('login'))
                ->with('error', 'Password yang kamu masukkan salah.');
        }

        // Buat session ID baru setelah login berhasil.
        $request->session()->regenerate();

        // Simpan informasi pengguna ke session.
        $request->session()->put([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
            'logged_in' => true,
        ]);

        // Arahkan ke dashboard setelah login berhasil.
        return redirect()
            ->route('dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        // Hapus session login dan data session sebelumnya.
        $request->session()->invalidate();

        // Buat token CSRF baru.
        $request->session()->regenerateToken();

        // Kembali ke halaman login.
        return redirect()
            ->route('login')
            ->with('success', 'Kamu berhasil logout.');
    }
}
