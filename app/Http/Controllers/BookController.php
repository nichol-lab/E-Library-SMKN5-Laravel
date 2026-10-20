<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Menampilkan semua buku.
     */
    public function index()
    {
        $books = Book::with('category')
            ->latest()
            ->get();

        return view(
            'books.index',
            compact('books')
        );
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'books.create',
            compact('categories')
        );
    }

    /**
     * Menyimpan buku baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:50',
                'unique:books,isbn',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'author' => [
                'required',
                'string',
                'max:255',
            ],

            'publisher' => [
                'nullable',
                'string',
                'max:255',
            ],

            'year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'shelf_location' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'category_id.required' =>
                'Kategori wajib dipilih.',

            'category_id.exists' =>
                'Kategori tidak ditemukan.',

            'isbn.unique' =>
                'ISBN sudah digunakan.',

            'title.required' =>
                'Judul buku wajib diisi.',

            'author.required' =>
                'Nama penulis wajib diisi.',

            'year.integer' =>
                'Tahun harus berupa angka.',

            'stock.required' =>
                'Stok buku wajib diisi.',

            'stock.min' =>
                'Stok tidak boleh kurang dari 0.',

            'cover.image' =>
                'File cover harus berupa gambar.',

            'cover.mimes' =>
                'Cover harus berformat JPG, JPEG, PNG, atau WEBP.',

            'cover.max' =>
                'Ukuran cover maksimal 2 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Cover
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request
                ->file('cover')
                ->store('covers', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Stok tersedia otomatis sama dengan stok awal
        |--------------------------------------------------------------------------
        */

        $validated['available_stock'] = $validated['stock'];

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with(
                'success',
                'Buku berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail buku.
     */
    public function show(Book $book)
    {
        $book->load([
            'category',
            'loanDetails.loan.user',
        ]);

        return view(
            'books.show',
            compact('book')
        );
    }

    /**
     * Menampilkan form edit buku.
     */
    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'books.edit',
            compact('book', 'categories')
        );
    }

    /**
     * Memperbarui data buku.
     */
    public function update(
        Request $request,
        Book $book
    ) {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('books', 'isbn')
                    ->ignore($book->id),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'author' => [
                'required',
                'string',
                'max:255',
            ],

            'publisher' => [
                'nullable',
                'string',
                'max:255',
            ],

            'year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'available_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'shelf_location' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'category_id.required' =>
                'Kategori wajib dipilih.',

            'category_id.exists' =>
                'Kategori tidak ditemukan.',

            'isbn.unique' =>
                'ISBN sudah digunakan.',

            'title.required' =>
                'Judul buku wajib diisi.',

            'author.required' =>
                'Nama penulis wajib diisi.',

            'stock.required' =>
                'Stok buku wajib diisi.',

            'stock.min' =>
                'Stok tidak boleh kurang dari 0.',

            'available_stock.required' =>
                'Stok tersedia wajib diisi.',

            'available_stock.min' =>
                'Stok tersedia tidak boleh kurang dari 0.',

            'cover.image' =>
                'File cover harus berupa gambar.',

            'cover.mimes' =>
                'Cover harus berformat JPG, JPEG, PNG, atau WEBP.',

            'cover.max' =>
                'Ukuran cover maksimal 2 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pastikan available_stock tidak melebihi stock
        |--------------------------------------------------------------------------
        */

        if ($validated['available_stock'] > $validated['stock']) {
            return back()
                ->withInput()
                ->withErrors([
                    'available_stock' =>
                        'Stok tersedia tidak boleh lebih besar dari total stok.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Cover Baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('cover')) {

            // Hapus cover lama jika ada
            if ($book->cover) {
                Storage::disk('public')->delete(
                    $book->cover
                );
            }

            $validated['cover'] = $request
                ->file('cover')
                ->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with(
                'success',
                'Data buku berhasil diperbarui.'
            );
    }

    /**
     * Menghapus buku.
     */
    public function destroy(Book $book)
    {
        /*
        |--------------------------------------------------------------------------
        | Jangan hapus buku yang pernah digunakan dalam transaksi
        |--------------------------------------------------------------------------
        */

        if ($book->loanDetails()->exists()) {
            return redirect()
                ->route('books.index')
                ->with(
                    'error',
                    'Buku tidak dapat dihapus karena sudah memiliki riwayat peminjaman.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus file cover
        |--------------------------------------------------------------------------
        */

        if ($book->cover) {
            Storage::disk('public')->delete(
                $book->cover
            );
        }

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with(
                'success',
                'Buku berhasil dihapus.'
            );
    }
}