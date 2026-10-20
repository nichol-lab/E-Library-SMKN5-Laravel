@extends('layouts.app')

@section('title', 'Edit Buku')

@section('header', 'Edit Buku')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="welcome">

        <div>
            <h1 class="welcome-title">
                Edit Buku
            </h1>

            <p class="welcome-description">
                Perbarui informasi buku yang tersimpan di E-Library
                SMK Negeri 5 Surakarta.
            </p>
        </div>

        <a
            href="{{ route('books.index') }}"
            class="btn btn-light"
        >
            <span>←</span>
            <span>Kembali</span>
        </a>

    </div>


    {{-- FORM --}}
    <div class="card form-card">

        <div class="card-header">

            <div>
                <div class="card-title">
                    Informasi Buku
                </div>

                <div class="card-subtitle">
                    Ubah data buku sesuai informasi terbaru.
                </div>
            </div>

            <span class="badge badge-approved">
                Edit Data
            </span>

        </div>


        <div class="card-body">

            {{-- ERROR VALIDATION --}}
            @if ($errors->any())

                <div
                    class="alert alert-error"
                    style="margin-bottom:20px;"
                >

                    <strong>
                        Data belum dapat disimpan.
                    </strong>

                    <ul
                        style="
                            margin:8px 0 0 18px;
                            padding:0;
                        "
                    >

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('books.update', $book->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')


                <div class="form-grid">


                    {{-- JUDUL --}}

                    <div class="form-group full">

                        <label
                            for="title"
                            class="form-label"
                        >
                            Judul Buku
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control"
                            value="{{ old('title', $book->title) }}"
                            placeholder="Masukkan judul buku"
                            required
                        >

                    </div>


                    {{-- PENULIS --}}

                    <div class="form-group">

                        <label
                            for="author"
                            class="form-label"
                        >
                            Penulis
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="text"
                            name="author"
                            id="author"
                            class="form-control"
                            value="{{ old('author', $book->author) }}"
                            placeholder="Nama penulis"
                            required
                        >

                    </div>


                    {{-- PENERBIT --}}

                    <div class="form-group">

                        <label
                            for="publisher"
                            class="form-label"
                        >
                            Penerbit
                        </label>

                        <input
                            type="text"
                            name="publisher"
                            id="publisher"
                            class="form-control"
                            value="{{ old('publisher', $book->publisher) }}"
                            placeholder="Nama penerbit"
                        >

                    </div>


                    {{-- KATEGORI --}}

                    <div class="form-group">

                        <label
                            for="category_id"
                            class="form-label"
                        >
                            Kategori
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <select
                            name="category_id"
                            id="category_id"
                            class="form-control"
                            required
                        >

                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ISBN --}}

                    <div class="form-group">

                        <label
                            for="isbn"
                            class="form-label"
                        >
                            ISBN
                        </label>

                        <input
                            type="text"
                            name="isbn"
                            id="isbn"
                            class="form-control"
                            value="{{ old('isbn', $book->isbn) }}"
                            placeholder="Contoh: 978602..."
                        >

                    </div>


                    {{-- TAHUN --}}

                    <div class="form-group">

                        <label
                            for="year"
                            class="form-label"
                        >
                            Tahun Terbit
                        </label>

                        <input
                            type="number"
                            name="year"
                            id="year"
                            class="form-control"
                            value="{{ old('year', $book->year) }}"
                            placeholder="Contoh: 2025"
                            min="1900"
                            max="{{ date('Y') + 1 }}"
                        >

                    </div>


                    {{-- STOK --}}

                    <div class="form-group">

                        <label
                            for="stock"
                            class="form-label"
                        >
                            Jumlah Stok
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="number"
                            name="stock"
                            id="stock"
                            class="form-control"
                            value="{{ old('stock', $book->stock) }}"
                            min="0"
                            required
                        >

                        <div
                            style="
                                margin-top:5px;
                                color:#94a3b8;
                                font-size:9.5px;
                            "
                        >
                            Jumlah seluruh eksemplar buku.
                        </div>

                    </div>


                    {{-- STOK TERSEDIA --}}

                    <div class="form-group">

                        <label
                            for="available_stock"
                            class="form-label"
                        >
                            Stok Tersedia
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="number"
                            name="available_stock"
                            id="available_stock"
                            class="form-control"
                            value="{{ old('available_stock', $book->available_stock) }}"
                            min="0"
                            required
                        >

                        <div
                            style="
                                margin-top:5px;
                                color:#94a3b8;
                                font-size:9.5px;
                            "
                        >
                            Jumlah buku yang masih dapat dipinjam.
                        </div>

                    </div>


                    {{-- LOKASI RAK --}}

                    <div class="form-group">

                        <label
                            for="shelf_location"
                            class="form-label"
                        >
                            Lokasi Rak
                        </label>

                        <input
                            type="text"
                            name="shelf_location"
                            id="shelf_location"
                            class="form-control"
                            value="{{ old('shelf_location', $book->shelf_location) }}"
                            placeholder="Contoh: Rak A-01"
                        >

                    </div>


                    {{-- DESKRIPSI --}}

                    <div class="form-group full">

                        <label
                            for="description"
                            class="form-label"
                        >
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            placeholder="Masukkan deskripsi singkat mengenai buku..."
                        >{{ old('description', $book->description) }}</textarea>

                    </div>

                </div>


                {{-- FORM ACTION --}}

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <span>✓</span>
                        <span>Simpan Perubahan</span>
                    </button>

                    <a
                        href="{{ route('books.index') }}"
                        class="btn btn-light"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- INFO CARD --}}

    <div
        class="card"
        style="
            margin-top:20px;
            max-width:900px;
        "
    >

        <div class="card-body">

            <div
                style="
                    display:flex;
                    align-items:flex-start;
                    gap:12px;
                "
            >

                <div
                    style="
                        width:36px;
                        height:36px;
                        min-width:36px;
                        border-radius:10px;
                        background:#eff6ff;
                        color:#2563eb;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-weight:800;
                    "
                >
                    i
                </div>

                <div>

                    <strong
                        style="
                            display:block;
                            color:#334155;
                            font-size:11px;
                            margin-bottom:4px;
                        "
                    >
                        Perhatian
                    </strong>

                    <p
                        style="
                            color:#94a3b8;
                            font-size:10px;
                            line-height:1.7;
                        "
                    >
                        Pastikan jumlah stok tersedia tidak melebihi
                        jumlah stok keseluruhan. Data buku yang sudah
                        diperbarui akan langsung digunakan dalam sistem
                        peminjaman.
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('styles')

<style>

    select.form-control {
        appearance: auto;
        cursor: pointer;
    }

    input[type="number"].form-control {
        appearance: textfield;
    }

    input[type="number"].form-control::-webkit-inner-spin-button,
    input[type="number"].form-control::-webkit-outer-spin-button {
        opacity: 1;
    }

    @media (max-width: 600px) {

        .form-card {
            width: 100%;
        }

    }

</style>

@endpush