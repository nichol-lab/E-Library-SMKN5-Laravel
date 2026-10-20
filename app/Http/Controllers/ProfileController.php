<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil.
     */
    public function edit()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            session()->flush();

            return redirect()
                ->route('login')
                ->with('error', 'Silakan login kembali.');
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Mengubah data profil.
     */
    public function update(Request $request)
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            session()->flush();

            return redirect()
                ->route('login')
                ->with('error', 'Sesi login tidak valid.');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'username')
                    ->ignore($user->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'nis' => [
                'nullable',
                'string',
                'max:50',
            ],

            'kelas' => [
                'nullable',
                'string',
                'max:100',
            ],

            'no_telepon' => [
                'nullable',
                'string',
                'max:20',
            ],

            'alamat' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $user->update($validated);

        // Perbarui data session
        session([
            'user_name' => $user->name,
        ]);

        return redirect()
            ->route('profile.edit')
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }

    /**
     * Menampilkan halaman ubah password.
     */
    public function password()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            session()->flush();

            return redirect()
                ->route('login')
                ->with('error', 'Silakan login kembali.');
        }

        return view(
            'profile.password',
            compact('user')
        );
    }

    /**
     * Mengubah password.
     */
    public function updatePassword(Request $request)
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            session()->flush();

            return redirect()
                ->route('login')
                ->with('error', 'Sesi login tidak valid.');
        }

        $request->validate([
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.required' =>
                'Password lama wajib diisi.',

            'password.required' =>
                'Password baru wajib diisi.',

            'password.min' =>
                'Password baru minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',
        ]);

        // Cek password lama
        if (!Hash::check(
            $request->current_password,
            $user->password
        )) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'Password lama tidak sesuai.',
                ]);
        }

        // Simpan password baru
        $user->password = Hash::make(
            $request->password
        );

        $user->save();

        return redirect()
            ->route('profile.password')
            ->with(
                'success',
                'Password berhasil diubah.'
            );
    }
}