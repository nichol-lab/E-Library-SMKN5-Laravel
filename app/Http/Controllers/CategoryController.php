<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Menampilkan semua kategori.
     */
    public function index()
    {
        $categories = Category::withCount('books')
            ->latest()
            ->get();

        return view(
            'categories.index',
            compact('categories')
        );
    }

    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'name.required' =>
                'Nama kategori wajib diisi.',

            'name.unique' =>
                'Nama kategori sudah digunakan.',

            'description.max' =>
                'Deskripsi maksimal 1000 karakter.',
        ]);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategori berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail kategori.
     */
    public function show(Category $category)
    {
        $category->load('books');

        return view(
            'categories.show',
            compact('category')
        );
    }

    /**
     * Menampilkan form edit kategori.
     */
    public function edit(Category $category)
    {
        $category->loadCount('books');

        return view(
            'categories.edit',
            compact('category')
        );
    }

    /**
     * Memperbarui kategori.
     */
    public function update(
        Request $request,
        Category $category
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($category->id),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'name.required' =>
                'Nama kategori wajib diisi.',

            'name.unique' =>
                'Nama kategori sudah digunakan.',

            'description.max' =>
                'Deskripsi maksimal 1000 karakter.',
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategori berhasil diperbarui.'
            );
    }

    /**
     * Menghapus kategori.
     */
    public function destroy(Category $category)
    {
        // Jangan hapus kategori jika masih memiliki buku.
        if ($category->books()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena masih memiliki buku.'
                );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Kategori berhasil dihapus.'
            );
    }
}