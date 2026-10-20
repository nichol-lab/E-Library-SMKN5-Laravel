<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan semua pengguna.
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }


    /**
     * Form tambah pengguna.
     */
    public function create()
    {
        return view('users.create');
    }


    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'petugas',
                    'siswa',
                ]),
            ],

            'nis' => [
                'nullable',
                'string',
                'max:30',
            ],

            'kelas' => [
                'nullable',
                'string',
                'max:50',
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
            'name.required' =>
                'Nama lengkap wajib diisi.',

            'username.required' =>
                'Username wajib diisi.',

            'username.unique' =>
                'Username sudah digunakan.',

            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email sudah digunakan.',

            'password.required' =>
                'Password wajib diisi.',

            'password.min' =>
                'Password minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',

            'role.required' =>
                'Role pengguna wajib dipilih.',

            'role.in' =>
                'Role pengguna tidak valid.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Data NIS & Kelas
        |--------------------------------------------------------------------------
        |
        | NIS dan kelas hanya digunakan untuk siswa.
        |
        */

        if ($validated['role'] !== 'siswa') {
            $validated['nis'] = null;
            $validated['kelas'] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        $validated['password'] =
            Hash::make($validated['password']);


        /*
        |--------------------------------------------------------------------------
        | Simpan User
        |--------------------------------------------------------------------------
        */

        User::create($validated);


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan detail pengguna.
     */
    public function show($id)
    {
        $user = User::with([
            'loans.loanDetails.book',
        ])->findOrFail($id);

        return view(
            'users.show',
            compact('user')
        );
    }


    /**
     * Form edit pengguna.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view(
            'users.edit',
            compact('user')
        );
    }


    /**
     * Memperbarui pengguna.
     */
    public function update(
        Request $request,
        $id
    ) {
        $user = User::findOrFail($id);


        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')
                    ->ignore($user->id),
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'petugas',
                    'siswa',
                ]),
            ],

            'nis' => [
                'nullable',
                'string',
                'max:30',
            ],

            'kelas' => [
                'nullable',
                'string',
                'max:50',
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

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' =>
                'Nama lengkap wajib diisi.',

            'username.required' =>
                'Username wajib diisi.',

            'username.unique' =>
                'Username sudah digunakan.',

            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'email.unique' =>
                'Email sudah digunakan.',

            'password.min' =>
                'Password minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Jangan sampai Admin terakhir dihapus role-nya
        |--------------------------------------------------------------------------
        */

        if (
            $user->role === 'admin' &&
            $validated['role'] !== 'admin'
        ) {

            $jumlahAdmin = User::where(
                'role',
                'admin'
            )->count();

            if ($jumlahAdmin <= 1) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Admin terakhir tidak boleh diubah rolenya.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NIS & Kelas
        |--------------------------------------------------------------------------
        */

        if ($validated['role'] !== 'siswa') {

            $validated['nis'] = null;
            $validated['kelas'] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['password'])
        ) {

            $validated['password'] =
                Hash::make(
                    $validated['password']
                );

        } else {

            unset($validated['password']);
        }


        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->update($validated);


        /*
        |--------------------------------------------------------------------------
        | Jika user mengedit dirinya sendiri
        |--------------------------------------------------------------------------
        */

        if (
            session('user_id') ==
            $user->id
        ) {

            session([
                'user_name' =>
                    $user->name,

                'user_role' =>
                    $user->role,
            ]);
        }


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Data pengguna berhasil diperbarui.'
            );
    }


    /**
     * Menghapus pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Tidak boleh menghapus akun sendiri
        |--------------------------------------------------------------------------
        */

        if (
            session('user_id') ==
            $user->id
        ) {

            return back()
                ->with(
                    'error',
                    'Kamu tidak dapat menghapus akun yang sedang digunakan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Admin terakhir tidak boleh dihapus
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            $jumlahAdmin = User::where(
                'role',
                'admin'
            )->count();

            if ($jumlahAdmin <= 1) {

                return back()
                    ->with(
                        'error',
                        'Admin terakhir tidak boleh dihapus.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | User yang sudah memiliki transaksi tidak boleh dihapus
        |--------------------------------------------------------------------------
        */

        if ($user->loans()->exists()) {

            return back()
                ->with(
                    'error',
                    'Pengguna tidak dapat dihapus karena sudah memiliki data peminjaman.'
                );
        }


        $user->delete();


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna berhasil dihapus.'
            );
    }
}