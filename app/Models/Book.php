<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'category_id',
        'isbn',
        'title',
        'author',
        'publisher',
        'year',
        'stock',
        'available_stock',
        'shelf_location',
        'description',
        'cover',
    ];

    protected $casts = [
        'year' => 'integer',
        'stock' => 'integer',
        'available_stock' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id'
        );
    }

    public function loanDetails()
    {
        return $this->hasMany(
            LoanDetail::class,
            'book_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STOCK
    |--------------------------------------------------------------------------
    */

    public function getBorrowedStockAttribute()
    {
        return max(
            0,
            (int) $this->stock -
            (int) $this->available_stock
        );
    }

    public function isAvailable()
    {
        return (int) $this->available_stock > 0;
    }

    public function isOutOfStock()
    {
        return (int) $this->available_stock <= 0;
    }

    /*
    |--------------------------------------------------------------------------
    | COVER URL
    |--------------------------------------------------------------------------
    |
    | Urutan:
    |
    | 1. Cover dari database jika ada
    | 2. Mapping berdasarkan judul
    | 3. Mapping berdasarkan keyword
    | 4. book-icon.jpg sebagai fallback
    |
    */

    public function getCoverUrlAttribute()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. COVER DARI DATABASE
        |--------------------------------------------------------------------------
        */

        if (!empty($this->cover)) {

            $cover = ltrim(
                trim($this->cover),
                '/'
            );

            /*
            | URL eksternal
            */

            if (
                str_starts_with(
                    $cover,
                    'http://'
                )
                ||
                str_starts_with(
                    $cover,
                    'https://'
                )
            ) {
                return $cover;
            }

            /*
            | Kalau database sudah menyimpan:
            | books/nama-file.jpg
            */

            if (
                str_starts_with(
                    $cover,
                    'books/'
                )
            ) {
                return asset($cover);
            }

            /*
            | Kalau database hanya menyimpan:
            | nama-file.jpg
            */

            return asset(
                'books/' . $cover
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 2. NORMALISASI JUDUL
        |--------------------------------------------------------------------------
        */

        $title = strtolower(
            trim(
                preg_replace(
                    '/\s+/',
                    ' ',
                    $this->title ?? ''
                )
            )
        );


        /*
        |--------------------------------------------------------------------------
        | 3. MAPPING JUDUL
        |--------------------------------------------------------------------------
        */

        $coverMap = [

            /*
            | Buku database
            */

            'basis data' =>
                'basis-data.jpg',


            /*
            | SESUAI PERMINTAAN:
            | Laravel untuk Pemula menggunakan flutter.jpg
            */

            'flutter untuk pemula' =>
                'flutter.jpg',

            'laravel untuk pemula' =>
                'flutter.jpg',


            /*
            | Kamus
            */

            'kamus bahasa indonesia' =>
                'kamus-bahasa-indonesia-1.jpg',


            /*
            | Novel
            */

            'laskar pelangi' =>
                'laskar-pelangi.jpg',


            /*
            | Matematika
            */

            'matematika untuk smk' =>
                'matematika-10.jpg',

            'matematika untuk smk kelas 10' =>
                'matematika-10.jpg',

            'matematika untuk smk kelas 11' =>
                'matematika-11.jpg',

            'matematika untuk smk kelas 12' =>
                'matematika-12.jpg',


            /*
            | PHP
            */

            'pemrograman php dasar' =>
                'pemrograman-php.jpg',


            /*
            | Sejarah
            */

            'sejarah indonesia' =>
                'sejarah-indonesia-10.jpg',

            'sejarah indonesia kelas 10' =>
                'sejarah-indonesia-10.jpg',

            'sejarah indonesia kelas 11' =>
                'sejarah-indonesia-11.jpg',

            'sejarah indonesia kelas 12' =>
                'sejarah-indonesia-12.jpg',

        ];


        /*
        |--------------------------------------------------------------------------
        | 4. EXACT MATCH
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $coverMap[$title]
            )
        ) {
            return asset(
                'books/' .
                $coverMap[$title]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 5. KEYWORD MATCH
        |--------------------------------------------------------------------------
        */

        /*
        | Basis Data
        */

        if (
            str_contains(
                $title,
                'basis data'
            )
        ) {
            return asset(
                'books/basis-data.jpg'
            );
        }


        /*
        | Flutter
        */

        if (
            str_contains(
                $title,
                'flutter'
            )
        ) {
            return asset(
                'books/flutter.jpg'
            );
        }


        /*
        | Laravel
        |
        | Sesuai permintaan:
        | Laravel → flutter.jpg
        */

        if (
            str_contains(
                $title,
                'laravel'
            )
        ) {
            return asset(
                'books/flutter.jpg'
            );
        }


        /*
        | Kamus Bahasa Indonesia
        */

        if (
            str_contains(
                $title,
                'kamus'
            )
            &&
            str_contains(
                $title,
                'bahasa indonesia'
            )
        ) {
            return asset(
                'books/kamus-bahasa-indonesia-1.jpg'
            );
        }


        /*
        | Laskar Pelangi
        */

        if (
            str_contains(
                $title,
                'laskar pelangi'
            )
        ) {
            return asset(
                'books/laskar-pelangi.jpg'
            );
        }


        /*
        | Matematika
        */

        if (
            str_contains(
                $title,
                'matematika'
            )
        ) {

            if (
                str_contains(
                    $title,
                    '12'
                )
            ) {
                return asset(
                    'books/matematika-12.jpg'
                );
            }

            if (
                str_contains(
                    $title,
                    '11'
                )
            ) {
                return asset(
                    'books/matematika-11.jpg'
                );
            }

            return asset(
                'books/matematika-10.jpg'
            );
        }


        /*
        | PHP
        */

        if (
            str_contains(
                $title,
                'pemrograman php'
            )
            ||
            str_contains(
                $title,
                'php dasar'
            )
        ) {
            return asset(
                'books/pemrograman-php.jpg'
            );
        }


        /*
        | Sejarah Indonesia
        */

        if (
            str_contains(
                $title,
                'sejarah indonesia'
            )
        ) {

            if (
                str_contains(
                    $title,
                    '12'
                )
            ) {
                return asset(
                    'books/sejarah-indonesia-12.jpg'
                );
            }

            if (
                str_contains(
                    $title,
                    '11'
                )
            ) {
                return asset(
                    'books/sejarah-indonesia-11.jpg'
                );
            }

            return asset(
                'books/sejarah-indonesia-10.jpg'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 6. FALLBACK
        |--------------------------------------------------------------------------
        */

        return asset(
            'book-icon.jpg'
        );
    }
}