@extends('layouts.app')

@section('title', 'Data Buku')

@section('header', 'Data Buku')

@section('content')

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}

    <div class="welcome">

        <div>

            <h1 class="welcome-title">
                Data Buku
            </h1>

            <p class="welcome-description">
                Kelola koleksi buku yang tersedia di perpustakaan
                SMK Negeri 5 Surakarta.
            </p>

        </div>

        <a
            href="{{ route('books.create') }}"
            class="btn btn-primary"
        >
            <span>＋</span>
            <span>Tambah Buku</span>
        </a>

    </div>


    {{-- =========================================================
         SUMMARY
    ========================================================== --}}

    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-top">

                <span class="stat-label">
                    Total Buku
                </span>

                <div class="stat-icon">
                    ▣
                </div>

            </div>

            <div class="stat-number">
                {{ $books->count() }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-top">

                <span class="stat-label">
                    Total Stok
                </span>

                <div class="stat-icon">
                    ▤
                </div>

            </div>

            <div class="stat-number">
                {{ $books->sum('stock') }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-top">

                <span class="stat-label">
                    Buku Tersedia
                </span>

                <div
                    class="stat-icon"
                    style="
                        background:#ecfdf3;
                        color:#16a34a;
                    "
                >
                    ✓
                </div>

            </div>

            <div class="stat-number">
                {{ $books->sum('available_stock') }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-top">

                <span class="stat-label">
                    Stok Dipinjam
                </span>

                <div
                    class="stat-icon"
                    style="
                        background:#fff7df;
                        color:#d97706;
                    "
                >
                    →
                </div>

            </div>

            <div class="stat-number">
                {{ $books->sum('stock') - $books->sum('available_stock') }}
            </div>

        </div>

    </div>


    {{-- =========================================================
         DATA TABLE
    ========================================================== --}}

    <div class="card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Koleksi Buku
                </div>

                <div class="card-subtitle">
                    Daftar seluruh buku yang terdaftar
                </div>

            </div>

        </div>


        <div class="card-body">


            {{-- =================================================
                 SEARCH
            ================================================== --}}

            <div class="toolbar">

                <div class="search-box">

                    <input
                        type="text"
                        id="bookSearch"
                        class="form-control"
                        placeholder="Cari judul, penulis, ISBN, atau penerbit..."
                    >

                </div>

                <div
                    style="
                        color:#94a3b8;
                        font-size:10px;
                        white-space:nowrap;
                    "
                >
                    {{ $books->count() }} buku
                </div>

            </div>


            {{-- =================================================
                 TABLE
            ================================================== --}}

            <div class="table-wrapper">

                <table
                    class="data-table"
                    id="bookTable"
                >

                    <thead>

                        <tr>

                            <th style="width:55px;">
                                No
                            </th>

                            <th>
                                Buku
                            </th>

                            <th>
                                Kategori
                            </th>

                            <th>
                                ISBN
                            </th>

                            <th>
                                Tahun
                            </th>

                            <th>
                                Stok
                            </th>

                            <th>
                                Status
                            </th>

                            <th style="text-align:center;">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($books as $index => $book)

                            <tr>

                                {{-- NO --}}

                                <td>

                                    <span
                                        style="
                                            color:#94a3b8;
                                            font-size:10px;
                                            font-weight:700;
                                        "
                                    >
                                        {{ $index + 1 }}
                                    </span>

                                </td>


                                {{-- BUKU --}}

                                <td>

                                    <div
                                        style="
                                            display:flex;
                                            align-items:center;
                                            gap:10px;
                                            min-width:190px;
                                        "
                                    >

                                        <div
                                            style="
                                                width:39px;
                                                height:48px;
                                                flex-shrink:0;
                                                border-radius:7px;
                                                background:
                                                    linear-gradient(
                                                        145deg,
                                                        #dbeafe,
                                                        #eff6ff
                                                    );
                                                color:#2563eb;
                                                display:flex;
                                                align-items:center;
                                                justify-content:center;
                                                font-size:17px;
                                            "
                                        >
                                            ▣
                                        </div>

                                        <div>

                                            <div class="table-title">
                                                {{ $book->title }}
                                            </div>

                                            <div class="table-muted">
                                                {{ $book->author ?? 'Penulis tidak tersedia' }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- KATEGORI --}}

                                <td>

                                    @if($book->category)

                                        <span
                                            style="
                                                display:inline-flex;
                                                padding:5px 9px;
                                                background:#f1f5f9;
                                                color:#64748b;
                                                border-radius:7px;
                                                font-size:9.5px;
                                                font-weight:700;
                                            "
                                        >
                                            {{ $book->category->name }}
                                        </span>

                                    @else

                                        <span
                                            style="
                                                color:#a0a9b8;
                                                font-size:10px;
                                            "
                                        >
                                            Tanpa kategori
                                        </span>

                                    @endif

                                </td>


                                {{-- ISBN --}}

                                <td>

                                    <span
                                        style="
                                            color:#64748b;
                                            font-size:10.5px;
                                        "
                                    >
                                        {{ $book->isbn ?? '-' }}
                                    </span>

                                </td>


                                {{-- TAHUN --}}

                                <td>

                                    <span
                                        style="
                                            color:#64748b;
                                            font-size:10.5px;
                                        "
                                    >
                                        {{ $book->year ?? '-' }}
                                    </span>

                                </td>


                                {{-- STOK --}}

                                <td>

                                    <div>

                                        <strong
                                            style="
                                                color:#334155;
                                                font-size:11px;
                                            "
                                        >
                                            {{ $book->available_stock }}
                                        </strong>

                                        <span
                                            style="
                                                color:#a0a9b8;
                                                font-size:9px;
                                            "
                                        >
                                            /
                                            {{ $book->stock }}
                                        </span>

                                    </div>

                                    <div
                                        style="
                                            width:65px;
                                            height:4px;
                                            margin-top:5px;
                                            background:#eef2f7;
                                            border-radius:999px;
                                            overflow:hidden;
                                        "
                                    >

                                        @php

                                            $stockPercentage =
                                                $book->stock > 0
                                                ? ($book->available_stock / $book->stock) * 100
                                                : 0;

                                        @endphp

                                        <div
                                            style="
                                                width:{{ $stockPercentage }}%;
                                                height:100%;
                                                background:#2563eb;
                                                border-radius:999px;
                                            "
                                        ></div>

                                    </div>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($book->available_stock > 0)

                                        <span class="badge badge-approved">
                                            Tersedia
                                        </span>

                                    @else

                                        <span class="badge badge-rejected">
                                            Habis
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}

                                <td>

                                    <div
                                        style="
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                            gap:5px;
                                        "
                                    >

                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('books.edit', $book) }}"
                                            class="btn btn-light"
                                            title="Edit"
                                            style="
                                                width:32px;
                                                min-height:32px;
                                                padding:0;
                                            "
                                        >
                                            ✎
                                        </a>


                                        {{-- DELETE --}}

                                        <form
                                            action="{{ route('books.destroy', $book) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus buku ini?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger"
                                                title="Hapus"
                                                style="
                                                    width:32px;
                                                    min-height:32px;
                                                    padding:0;
                                                "
                                            >
                                                ×
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    style="border:none;"
                                >

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            ▣
                                        </div>

                                        <strong>
                                            Belum ada buku
                                        </strong>

                                        <span>
                                            Tambahkan buku pertama
                                            ke dalam koleksi perpustakaan.
                                        </span>

                                        <div style="margin-top:15px;">

                                            <a
                                                href="{{ route('books.create') }}"
                                                class="btn btn-primary"
                                            >
                                                ＋ Tambah Buku
                                            </a>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


@endsection


{{-- =============================================================
     SEARCH SCRIPT
============================================================= --}}

@push('scripts')

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const searchInput =
                document.getElementById(
                    'bookSearch'
                );

            const table =
                document.getElementById(
                    'bookTable'
                );


            if (!searchInput || !table) {
                return;
            }


            searchInput.addEventListener(
                'input',
                function () {

                    const keyword =
                        this.value
                            .toLowerCase()
                            .trim();


                    const rows =
                        table.querySelectorAll(
                            'tbody tr'
                        );


                    rows.forEach(
                        function (row) {

                            const text =
                                row.textContent
                                    .toLowerCase();


                            if (
                                text.includes(keyword)
                            ) {

                                row.style.display =
                                    '';

                            } else {

                                row.style.display =
                                    'none';

                            }

                        }
                    );

                }
            );

        }
    );

</script>

@endpush