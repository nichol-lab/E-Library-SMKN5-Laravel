<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $table = 'fines';

    protected $fillable = [
        'loan_detail_id',
        'late_days',
        'amount',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'late_days' => 'integer',
        'amount' => 'integer',
        'paid_at' => 'datetime',
    ];

    /**
     * Denda ini terkait dengan satu detail peminjaman.
     */
    public function loanDetail()
    {
        return $this->belongsTo(
            LoanDetail::class,
            'loan_detail_id'
        );
    }

    /**
     * Mengecek apakah denda sudah dibayar.
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    /**
     * Mengecek apakah denda belum dibayar.
     */
    public function isUnpaid()
    {
        return $this->status === 'unpaid';
    }

    /**
     * Format jumlah denda ke Rupiah.
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format(
            $this->amount,
            0,
            ',',
            '.'
        );
    }
}