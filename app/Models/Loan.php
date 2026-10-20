<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'user_id',
        'loan_code',
        'loan_date',
        'due_date',
        'status',
        'approved_by',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'approved_at' => 'datetime',
    ];


    /**
     * Peminjaman milik seorang siswa/user.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /**
     * Detail buku yang ada dalam peminjaman.
     */
    public function loanDetails()
    {
        return $this->hasMany(
            LoanDetail::class,
            'loan_id'
        );
    }


    /**
     * Petugas/admin yang menyetujui peminjaman.
     */
    public function approvedBy()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }


    /**
     * Mengecek apakah pengajuan masih pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }


    /**
     * Mengecek apakah peminjaman sudah disetujui.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }


    /**
     * Mengecek apakah buku sedang dipinjam.
     */
    public function isBorrowed()
    {
        return $this->status === 'borrowed';
    }


    /**
     * Mengecek apakah buku sudah dikembalikan.
     */
    public function isReturned()
    {
        return $this->status === 'returned';
    }


    /**
     * Mengecek apakah pengajuan ditolak.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }


    /**
     * Total jumlah buku dalam peminjaman.
     */
    public function getTotalBooksAttribute()
    {
        return $this->loanDetails->sum(
            'quantity'
        );
    }


    /**
     * Total denda dari seluruh detail peminjaman.
     */
    public function getTotalFineAttribute()
    {
        return $this->loanDetails
            ->flatMap(function ($detail) {
                return $detail->fines;
            })
            ->sum('amount');
    }
}