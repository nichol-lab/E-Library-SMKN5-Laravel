<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    use HasFactory;

    protected $table = 'loan_details';

    protected $fillable = [
        'loan_id',
        'book_id',
        'quantity',
        'returned_at',
        'condition',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
        'quantity' => 'integer',
    ];

    /**
     * Detail ini milik satu transaksi peminjaman.
     */
    public function loan()
    {
        return $this->belongsTo(
            Loan::class,
            'loan_id'
        );
    }

    /**
     * Buku yang dipinjam.
     */
    public function book()
    {
        return $this->belongsTo(
            Book::class,
            'book_id'
        );
    }

    /**
     * Denda yang terkait dengan detail peminjaman.
     */
    public function fines()
    {
        return $this->hasMany(
            Fine::class,
            'loan_detail_id'
        );
    }

    /**
     * Mengecek apakah buku sudah dikembalikan.
     */
    public function isReturned()
    {
        return !is_null($this->returned_at);
    }

    /**
     * Mengecek apakah buku belum dikembalikan.
     */
    public function isNotReturned()
    {
        return is_null($this->returned_at);
    }
}