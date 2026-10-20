<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| ROUTE UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Halaman Login
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');


/*
|--------------------------------------------------------------------------
| Proses Login
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


/*
|--------------------------------------------------------------------------
| ROUTE SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth.session')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    |
    | Semua user yang sudah login bisa membuka dashboard.
    |
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMIN + PETUGAS PERPUSTAKAAN
    |--------------------------------------------------------------------------
    |
    | Fitur yang dapat digunakan oleh:
    | - Admin
    | - Petugas Perpustakaan
    |
    */
    Route::middleware('role:admin,petugas')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | KATEGORI BUKU
        |--------------------------------------------------------------------------
        */
        Route::resource('categories', CategoryController::class);


        /*
        |--------------------------------------------------------------------------
        | DATA BUKU
        |--------------------------------------------------------------------------
        */
        Route::resource('books', BookController::class);


        /*
        |--------------------------------------------------------------------------
        | DATA PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        /*
        | Menampilkan seluruh peminjaman
        */
        Route::get('/loans', [LoanController::class, 'index'])
            ->name('loans.index');


        /*
        | Menyetujui peminjaman
        */
        Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])
            ->name('loans.approve');


        /*
        | Menolak peminjaman
        */
        Route::patch('/loans/{loan}/reject', [LoanController::class, 'reject'])
            ->name('loans.reject');


        /*
        | Menyerahkan buku kepada siswa
        */
        Route::patch('/loans/{loan}/handover', [LoanController::class, 'handover'])
            ->name('loans.handover');


        /*
        | Memproses pengembalian buku
        */
        Route::patch('/loans/{loan}/return', [LoanController::class, 'returnBook'])
            ->name('loans.return');

    });


    /*
    |--------------------------------------------------------------------------
    | KHUSUS ADMIN
    |--------------------------------------------------------------------------
    |
    | Admin memiliki akses penuh terhadap data pengguna.
    |
    */
    Route::middleware('role:admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DATA PENGGUNA
        |--------------------------------------------------------------------------
        */
        Route::resource('users', UserController::class);

    });


    /*
    |--------------------------------------------------------------------------
    | KHUSUS SISWA
    |--------------------------------------------------------------------------
    |
    | Fitur yang dapat digunakan oleh siswa:
    | - Melihat katalog
    | - Mengajukan peminjaman
    | - Melihat peminjaman sendiri
    |
    */
    Route::middleware('role:siswa')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | KATALOG BUKU
        |--------------------------------------------------------------------------
        */
        Route::get('/catalog', [LoanController::class, 'catalog'])
            ->name('catalog');


        /*
        |--------------------------------------------------------------------------
        | FORM AJUKAN PEMINJAMAN
        |--------------------------------------------------------------------------
        */
        Route::get('/loans/create', [LoanController::class, 'create'])
            ->name('loans.create');


        /*
        |--------------------------------------------------------------------------
        | PROSES AJUKAN PEMINJAMAN
        |--------------------------------------------------------------------------
        */
        Route::post('/loans', [LoanController::class, 'store'])
            ->name('loans.store');


        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN SAYA
        |--------------------------------------------------------------------------
        */
        Route::get('/my-loans', [LoanController::class, 'myLoans'])
            ->name('loans.mine');

    });


    /*
    |--------------------------------------------------------------------------
    | PROFIL
    |--------------------------------------------------------------------------
    |
    | Semua user yang sudah login dapat mengelola profilnya sendiri.
    |
    */

    /*
    | Halaman profil
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');


    /*
    | Update profil
    */
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    /*
    |--------------------------------------------------------------------------
    | PASSWORD
    |--------------------------------------------------------------------------
    */

    /*
    | Halaman ubah password
    */
    Route::get('/profile/password', [ProfileController::class, 'password'])
        ->name('profile.password');


    /*
    | Proses ubah password
    */
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');

});