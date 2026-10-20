<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Satu kategori memiliki banyak buku.
     */
    public function books()
    {
        return $this->hasMany(
            Book::class,
            'category_id'
        );
    }

    /**
     * Jumlah buku dalam kategori.
     */
    public function getTotalBooksAttribute()
    {
        return $this->books()->count();
    }
}