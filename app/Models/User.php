<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'nis',
        'kelas',
        'no_telepon',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * User memiliki banyak transaksi peminjaman.
     */
    public function loans()
    {
        return $this->hasMany(
            Loan::class,
            'user_id'
        );
    }

    /**
     * User sebagai admin/petugas yang menyetujui peminjaman.
     */
    public function approvedLoans()
    {
        return $this->hasMany(
            Loan::class,
            'approved_by'
        );
    }

    /**
     * Mengecek apakah user adalah admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Mengecek apakah user adalah petugas perpustakaan.
     */
    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    /**
     * Mengecek apakah user adalah siswa.
     */
    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    /**
     * Nama role yang lebih mudah dibaca.
     */
    public function getRoleLabelAttribute()
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'petugas' => 'Petugas Perpustakaan',
            'siswa' => 'Siswa',
            default => ucfirst($this->role ?? '-'),
        };
    }
}