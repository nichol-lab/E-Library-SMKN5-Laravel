<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\LoanDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * =========================================================
     * MENAMPILKAN SEMUA DATA PEMINJAMAN
     * ADMIN & PETUGAS
     * =========================================================
     */
    public function index()
    {
        $loans = Loan::with([
            'user',
            'loanDetails.book',
            'approvedBy',
        ])
            ->latest()
            ->get();

        return view(
            'loans.index',
            compact('loans')
        );
    }


    /**
     * =========================================================
     * MENAMPILKAN KATALOG BUKU
     * SISWA
     * =========================================================
     */
    public function catalog()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $books = Book::with('category')
            ->orderBy('title')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | FILE VIEW BERADA DI:
        | resources/views/loans/catalog.blade.php
        |
        | Maka pemanggilan view harus:
        | loans.catalog
        |--------------------------------------------------------------------------
        */

        return view(
            'loans.catalog',
            compact('books', 'user')
        );
    }


    /**
     * =========================================================
     * FORM PENGAJUAN PEMINJAMAN
     * SISWA
     * =========================================================
     */
    public function create(Request $request)
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $books = Book::with('category')
            ->where('available_stock', '>', 0)
            ->orderBy('title')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Buku yang dipilih dari katalog
        |--------------------------------------------------------------------------
        */

        $selectedBookId = $request->query('book_id');

        return view(
            'loans.create',
            compact(
                'books',
                'user',
                'selectedBookId'
            )
        );
    }


    /**
     * =========================================================
     * MENYIMPAN PENGAJUAN PEMINJAMAN
     * SISWA
     * =========================================================
     */
    public function store(Request $request)
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Sesi login tidak valid.'
                );
        }

        $validated = $request->validate([
            'loan_date' => [
                'required',
                'date',
            ],

            'due_date' => [
                'required',
                'date',
                'after_or_equal:loan_date',
            ],

            'books' => [
                'required',
                'array',
                'min:1',
            ],

            'books.*' => [
                'integer',
                'exists:books,id',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'loan_date.required' =>
                'Tanggal peminjaman wajib diisi.',

            'due_date.required' =>
                'Tanggal pengembalian wajib diisi.',

            'due_date.after_or_equal' =>
                'Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.',

            'books.required' =>
                'Pilih minimal satu buku.',

            'books.min' =>
                'Pilih minimal satu buku.',

            'books.*.exists' =>
                'Buku yang dipilih tidak ditemukan.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Hilangkan ID buku yang sama
        |--------------------------------------------------------------------------
        */

        $bookIds = array_values(
            array_unique(
                $validated['books']
            )
        );

        if (empty($bookIds)) {
            return back()
                ->withInput()
                ->withErrors([
                    'books' =>
                        'Pilih minimal satu buku.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cek ketersediaan semua buku
        |--------------------------------------------------------------------------
        */

        $books = Book::whereIn(
            'id',
            $bookIds
        )->get();

        foreach ($books as $book) {

            if ($book->available_stock <= 0) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'books' =>
                            'Buku "' .
                            $book->title .
                            '" sedang tidak tersedia.',
                    ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Buat transaksi
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Buat kode peminjaman
            |--------------------------------------------------------------------------
            */

            $loanCode = $this->generateLoanCode();

            /*
            |--------------------------------------------------------------------------
            | Buat data peminjaman
            |--------------------------------------------------------------------------
            */

            $loan = Loan::create([
                'user_id' => $user->id,
                'loan_code' => $loanCode,
                'loan_date' => $validated['loan_date'],
                'due_date' => $validated['due_date'],
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Buat detail peminjaman
            |--------------------------------------------------------------------------
            */

            foreach ($bookIds as $bookId) {

                LoanDetail::create([
                    'loan_id' => $loan->id,
                    'book_id' => $bookId,
                    'quantity' => 1,
                    'returned_at' => null,
                    'condition' => null,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('loans.mine')
                ->with(
                    'success',
                    'Pengajuan peminjaman berhasil dikirim. Kode: ' .
                    $loanCode
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengajuan peminjaman gagal diproses.'
                );
        }
    }


    /**
     * =========================================================
     * MENAMPILKAN PEMINJAMAN SISWA
     * SISWA
     * =========================================================
     */
    public function myLoans()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $loans = Loan::with([
            'loanDetails.book',
            'approvedBy',
        ])
            ->where(
                'user_id',
                $user->id
            )
            ->latest()
            ->get();

        return view(
            'loans.mine',
            compact(
                'loans',
                'user'
            )
        );
    }


    /**
     * =========================================================
     * MENYETUJUI PEMINJAMAN
     * ADMIN & PETUGAS
     * =========================================================
     */
    public function approve($id)
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }

        $loan = Loan::with(
            'loanDetails.book'
        )->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Pastikan masih pending
        |--------------------------------------------------------------------------
        */

        if ($loan->status !== 'pending') {

            return back()->with(
                'error',
                'Peminjaman ini sudah diproses sebelumnya.'
            );
        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Lock data peminjaman
            |--------------------------------------------------------------------------
            */

            $loan = Loan::with(
                'loanDetails.book'
            )
                ->lockForUpdate()
                ->findOrFail($id);

            if ($loan->status !== 'pending') {

                DB::rollBack();

                return back()->with(
                    'error',
                    'Peminjaman ini sudah diproses sebelumnya.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Cek seluruh stok buku
            |--------------------------------------------------------------------------
            */

            foreach ($loan->loanDetails as $detail) {

                $book = Book::lockForUpdate()
                    ->find($detail->book_id);

                if (!$book) {

                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Buku tidak ditemukan.'
                    );
                }

                if (
                    $book->available_stock <
                    $detail->quantity
                ) {

                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Stok buku "' .
                        $book->title .
                        '" tidak mencukupi.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Kurangi stok buku
            |--------------------------------------------------------------------------
            */

            foreach ($loan->loanDetails as $detail) {

                $book = Book::lockForUpdate()
                    ->find($detail->book_id);

                $book->available_stock =
                    $book->available_stock -
                    $detail->quantity;

                $book->save();
            }

            /*
            |--------------------------------------------------------------------------
            | Update status
            |--------------------------------------------------------------------------
            */

            $loan->update([
                'status' => 'approved',
                'approved_by' => $user->id,
                'approved_at' => now(),
            ]);

            DB::commit();

            return back()->with(
                'success',
                'Peminjaman ' .
                $loan->loan_code .
                ' berhasil disetujui.'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Peminjaman gagal disetujui.'
            );
        }
    }


    /**
     * =========================================================
     * MENOLAK PEMINJAMAN
     * ADMIN & PETUGAS
     * =========================================================
     */
    public function reject(
        Request $request,
        $id
    ) {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pending') {

            return back()->with(
                'error',
                'Peminjaman ini sudah diproses sebelumnya.'
            );
        }

        $request->validate([
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $loan->update([
            'status' => 'rejected',
            'notes' => $request->notes
                ?? $loan->notes,
        ]);

        return back()->with(
            'success',
            'Peminjaman ' .
            $loan->loan_code .
            ' berhasil ditolak.'
        );
    }


    /**
     * =========================================================
     * SERAH TERIMA BUKU
     * ADMIN & PETUGAS
     * =========================================================
     */
    public function handover($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'approved') {

            return back()->with(
                'error',
                'Peminjaman harus berstatus Approved sebelum diserahkan.'
            );
        }

        $loan->update([
            'status' => 'borrowed',
        ]);

        return back()->with(
            'success',
            'Buku berhasil diserahkan kepada siswa.'
        );
    }


    /**
     * =========================================================
     * PENGEMBALIAN BUKU
     * ADMIN & PETUGAS
     * =========================================================
     */
    public function returnBook($id)
    {
        $loan = Loan::with([
            'loanDetails.book',
        ])->findOrFail($id);

        if ($loan->status !== 'borrowed') {

            return back()->with(
                'error',
                'Peminjaman harus berstatus Borrowed sebelum dikembalikan.'
            );
        }

        DB::beginTransaction();

        try {

            $today = Carbon::today();

            $dueDate = Carbon::parse(
                $loan->due_date
            );

            /*
            |--------------------------------------------------------------------------
            | Hitung keterlambatan
            |--------------------------------------------------------------------------
            */

            $lateDays = 0;

            if ($today->greaterThan($dueDate)) {

                $lateDays =
                    $dueDate->diffInDays(
                        $today
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Denda Rp1.000 per hari per buku
            |--------------------------------------------------------------------------
            */

            $finePerDay = 1000;

            foreach ($loan->loanDetails as $detail) {

                /*
                |--------------------------------------------------------------------------
                | Jangan proses detail yang sudah dikembalikan
                |--------------------------------------------------------------------------
                */

                if ($detail->returned_at !== null) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Kembalikan stok buku
                |--------------------------------------------------------------------------
                */

                $book = Book::lockForUpdate()
                    ->find($detail->book_id);

                if ($book) {

                    $book->available_stock =
                        min(
                            $book->stock,
                            $book->available_stock +
                            $detail->quantity
                        );

                    $book->save();
                }

                /*
                |--------------------------------------------------------------------------
                | Tandai detail sudah dikembalikan
                |--------------------------------------------------------------------------
                */

                $detail->update([
                    'returned_at' => now(),
                    'condition' => 'baik',
                ]);

                /*
                |--------------------------------------------------------------------------
                | Buat denda jika terlambat
                |--------------------------------------------------------------------------
                */

                if ($lateDays > 0) {

                    Fine::create([
                        'loan_detail_id' => $detail->id,
                        'late_days' => $lateDays,
                        'amount' =>
                            $lateDays *
                            $finePerDay *
                            $detail->quantity,
                        'status' => 'unpaid',
                        'paid_at' => null,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update status transaksi
            |--------------------------------------------------------------------------
            */

            $loan->update([
                'status' => 'returned',
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Tampilkan informasi denda
            |--------------------------------------------------------------------------
            */

            if ($lateDays > 0) {

                $totalFine = 0;

                foreach ($loan->loanDetails as $detail) {

                    $totalFine +=
                        $lateDays *
                        $finePerDay *
                        $detail->quantity;
                }

                return back()->with(
                    'success',
                    'Buku berhasil dikembalikan. ' .
                    'Terlambat ' .
                    $lateDays .
                    ' hari. Total denda Rp ' .
                    number_format(
                        $totalFine,
                        0,
                        ',',
                        '.'
                    ) .
                    '.'
                );
            }

            return back()->with(
                'success',
                'Buku berhasil dikembalikan tanpa denda.'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Proses pengembalian buku gagal.'
            );
        }
    }


    /**
     * =========================================================
     * MEMBUAT KODE PEMINJAMAN UNIK
     * =========================================================
     */
    private function generateLoanCode()
    {
        do {

            $code =
                'ELIB-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(
                    substr(
                        md5(
                            uniqid(
                                (string) mt_rand(),
                                true
                            )
                        ),
                        0,
                        6
                    )
                );

        } while (
            Loan::where(
                'loan_code',
                $code
            )->exists()
        );

        return $code;
    }
}