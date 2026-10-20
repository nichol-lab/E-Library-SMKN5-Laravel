<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdditionalBooksSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $books = [
                [
                    'title' => 'Digital Marketing Melalui Aplikasi Playstore',
                    'author' => 'Drs. Usman Chamdani',
                    'category' => 'Digital Marketing',
                    'publisher' => null,
                    'year' => null,
                    'cover' => 'digital-marketing.jpg',
                    'description' => 'Buku mengenai digital marketing melalui aplikasi Playstore. Informasi edisi dan bibliografi lengkap perlu disesuaikan dengan buku fisik.',
                    'stock' => 3,
                    'shelf_location' => 'Belum ditentukan',
                ],
                [
                    'title' => 'Pendidikan Pancasila SD/MI Kelas II',
                    'author' => 'Belum terverifikasi',
                    'category' => 'Pendidikan',
                    'publisher' => null,
                    'year' => null,
                    'cover' => 'pendidikan-pancasila.jpg',
                    'description' => 'Buku Pendidikan Pancasila untuk peserta didik SD/MI kelas II. Nama penulis dan informasi penerbit perlu diperiksa pada buku fisik.',
                    'stock' => 3,
                    'shelf_location' => 'Belum ditentukan',
                ],
                [
                    'title' => 'Grave of the Fireflies',
                    'author' => 'Belum terverifikasi',
                    'category' => 'Novel dan Sastra',
                    'publisher' => null,
                    'year' => null,
                    'cover' => 'grave-of-the-fireflies.jpg',
                    'description' => 'Koleksi dengan judul Grave of the Fireflies. Pastikan sampul yang digunakan sesuai dengan edisi buku yang benar karena judul ini juga dikenal sebagai film.',
                    'stock' => 3,
                    'shelf_location' => 'Belum ditentukan',
                ],
                [
                    'title' => 'Laut Bercerita',
                    'author' => 'Leila S. Chudori',
                    'category' => 'Novel dan Sastra',
                    'publisher' => null,
                    'year' => null,
                    'cover' => 'laut-bercerita.jpg',
                    'description' => 'Novel karya Leila S. Chudori yang mengangkat kisah persahabatan, keluarga, dan sejarah Indonesia. Informasi edisi dan penerbit perlu disesuaikan dengan koleksi yang dimiliki.',
                    'stock' => 3,
                    'shelf_location' => 'Belum ditentukan',
                ],
                [
                    'title' => 'Seporsi Mie Ayam Sebelum Mati',
                    'author' => 'Brian Khrisna',
                    'category' => 'Novel dan Sastra',
                    'publisher' => null,
                    'year' => null,
                    'cover' => 'seporsi-mie-ayam.jpg',
                    'description' => 'Karya fiksi oleh Brian Khrisna. Lengkapi informasi penerbit dan tahun terbit berdasarkan edisi buku yang tersedia di perpustakaan.',
                    'stock' => 3,
                    'shelf_location' => 'Belum ditentukan',
                ],
                [
                    'title' => "Harry Potter and the Sorcerer's Stone",
                    'author' => 'J. K. Rowling',
                    'category' => 'Fantasi',
                    'publisher' => null,
                    'year' => null,
                    'cover' => 'harry-potter.jpg',
                    'description' => 'Novel fantasi karya J. K. Rowling tentang awal petualangan Harry Potter di dunia sihir. Detail penerbit dan tahun terbit mengikuti edisi koleksi.',
                    'stock' => 3,
                    'shelf_location' => 'Belum ditentukan',
                ],
            ];

            foreach ($books as $data) {
                $category = Category::firstOrCreate(
                    ['name' => $data['category']],
                    [
                        'description' => 'Kategori buku ' . $data['category'],
                    ]
                );

                // Jangan menimpa data buku jika judulnya sudah ada.
                Book::firstOrCreate(
                    ['title' => $data['title']],
                    [
                        'category_id' => $category->id,
                        'isbn' => null,
                        'author' => $data['author'],
                        'publisher' => $data['publisher'],
                        'year' => $data['year'],
                        'stock' => $data['stock'],
                        'available_stock' => $data['stock'],
                        'shelf_location' => $data['shelf_location'],
                        'description' => $data['description'],
                        'cover' => $data['cover'],
                    ]
                );
            }
        });
    }
}