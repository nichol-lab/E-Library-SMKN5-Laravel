<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // USERS
        // =========================

        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@elibrary.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Perpustakaan',
            'username' => 'petugas',
            'email' => 'petugas@elibrary.test',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        User::create([
            'name' => 'Siswa SMKN 5',
            'username' => 'siswa',
            'email' => 'siswa@elibrary.test',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nis' => '20260001',
            'kelas' => 'XII RPL C',
            'no_telepon' => '081234567890',
            'alamat' => 'Surakarta',
        ]);

        // =========================
        // CATEGORIES
        // =========================

        $pelajaran = Category::create([
            'name' => 'Pelajaran',
            'description' => 'Buku pelajaran sekolah.',
        ]);

        $kejuruan = Category::create([
            'name' => 'Kejuruan',
            'description' => 'Buku yang berkaitan dengan bidang keahlian PPLG/RPL.',
        ]);

        $fiksi = Category::create([
            'name' => 'Fiksi',
            'description' => 'Novel dan cerita fiksi.',
        ]);

        $nonfiksi = Category::create([
            'name' => 'Nonfiksi',
            'description' => 'Buku pengetahuan umum dan nonfiksi.',
        ]);

        $referensi = Category::create([
            'name' => 'Referensi',
            'description' => 'Buku referensi dan bahan pendukung pembelajaran.',
        ]);

        // =========================
        // BOOKS
        // =========================

        Book::create([
            'category_id' => $kejuruan->id,
            'isbn' => '9786020000001',
            'title' => 'Pemrograman PHP Dasar',
            'author' => 'Andi Publisher',
            'publisher' => 'Andi',
            'year' => 2024,
            'stock' => 10,
            'available_stock' => 10,
            'shelf_location' => 'A-01',
            'description' => 'Buku dasar pemrograman PHP.',
        ]);

        Book::create([
            'category_id' => $kejuruan->id,
            'isbn' => '9786020000002',
            'title' => 'Laravel untuk Pemula',
            'author' => 'Budi Raharjo',
            'publisher' => 'Informatika',
            'year' => 2024,
            'stock' => 8,
            'available_stock' => 8,
            'shelf_location' => 'A-02',
            'description' => 'Panduan dasar pengembangan website menggunakan Laravel.',
        ]);

        Book::create([
            'category_id' => $kejuruan->id,
            'isbn' => '9786020000003',
            'title' => 'Basis Data',
            'author' => 'Fathansyah',
            'publisher' => 'Informatika',
            'year' => 2023,
            'stock' => 7,
            'available_stock' => 7,
            'shelf_location' => 'A-03',
            'description' => 'Materi basis data dan pengelolaan database.',
        ]);

        Book::create([
            'category_id' => $pelajaran->id,
            'isbn' => '9786020000004',
            'title' => 'Matematika untuk SMK',
            'author' => 'Tim Edukasi',
            'publisher' => 'Erlangga',
            'year' => 2024,
            'stock' => 12,
            'available_stock' => 12,
            'shelf_location' => 'B-01',
            'description' => 'Buku matematika untuk siswa SMK.',
        ]);

        Book::create([
            'category_id' => $nonfiksi->id,
            'isbn' => '9786020000005',
            'title' => 'Sejarah Indonesia',
            'author' => 'Tim Sejarah',
            'publisher' => 'Yudhistira',
            'year' => 2023,
            'stock' => 6,
            'available_stock' => 6,
            'shelf_location' => 'B-02',
            'description' => 'Buku sejarah Indonesia.',
        ]);

        Book::create([
            'category_id' => $fiksi->id,
            'isbn' => '9786020000006',
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'publisher' => 'Bentang',
            'year' => 2022,
            'stock' => 5,
            'available_stock' => 5,
            'shelf_location' => 'C-01',
            'description' => 'Novel fiksi Indonesia.',
        ]);

        Book::create([
            'category_id' => $referensi->id,
            'isbn' => '9786020000007',
            'title' => 'Kamus Bahasa Indonesia',
            'author' => 'Tim Penyusun',
            'publisher' => 'Balai Pustaka',
            'year' => 2023,
            'stock' => 4,
            'available_stock' => 4,
            'shelf_location' => 'D-01',
            'description' => 'Kamus sebagai bahan referensi siswa.',
        ]);
    }
}