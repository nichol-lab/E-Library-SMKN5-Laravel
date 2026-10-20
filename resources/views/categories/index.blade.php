
@extends('layouts.app')

@section('title', 'Kategori Buku')
@section('header', 'Kategori Buku')

@section('content')
@php
    $totalCategories = $categories->count();
    $totalBooks = $categories->sum(
        fn($category) => $category->books_count ?? $category->books->count()
    );
    $emptyCategories = $categories->filter(
        fn($category) => ($category->books_count ?? $category->books->count()) === 0
    )->count();
@endphp

<div class="category-page">

    {{-- HEADER --}}
    <section class="category-hero">
        <div class="category-hero-content">
            <div class="category-eyebrow">
                <span class="eyebrow-dot"></span>
                PANEL PETUGAS PERPUSTAKAAN
            </div>

            <h1>Kelola Kategori Buku</h1>

            <p>
                Atur dan kelompokkan koleksi buku agar siswa lebih mudah
                menemukan bacaan yang mereka butuhkan.
            </p>

            <a href="{{ route('categories.create') }}" class="category-primary-btn">
                <span class="plus-icon">＋</span>
                Tambah Kategori
            </a>
        </div>

        <div class="category-hero-art" aria-hidden="true">
            <div class="art-circle art-circle-one"></div>
            <div class="art-circle art-circle-two"></div>
            <div class="art-book-stack">
                <span>📚</span>
            </div>
            <div class="art-small-label">READ · LEARN · GROW</div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="category-stats">
        <article class="category-stat-card">
            <div class="stat-card-top">
                <div class="category-stat-icon icon-green">📚</div>
                <span class="stat-card-tag">Koleksi</span>
            </div>

            <div class="category-stat-number">{{ $totalCategories }}</div>
            <div class="category-stat-title">Total Kategori</div>
            <p class="category-stat-description">
                Kelompok koleksi buku
            </p>
        </article>

        <article class="category-stat-card">
            <div class="stat-card-top">
                <div class="category-stat-icon icon-pink">📖</div>
                <span class="stat-card-tag">Perpustakaan</span>
            </div>

            <div class="category-stat-number">{{ $totalBooks }}</div>
            <div class="category-stat-title">Total Buku</div>
            <p class="category-stat-description">
                Buku dalam seluruh kategori
            </p>
        </article>

        <article class="category-stat-card">
            <div class="stat-card-top">
                <div class="category-stat-icon icon-peach">🗂️</div>
                <span class="stat-card-tag">Perlu diperiksa</span>
            </div>

            <div class="category-stat-number">{{ $emptyCategories }}</div>
            <div class="category-stat-title">Kategori Kosong</div>
            <p class="category-stat-description">
                Belum memiliki koleksi buku
            </p>
        </article>
    </section>

    {{-- DAFTAR KATEGORI --}}
    <section class="category-card">

        <div class="category-card-header">
            <div class="category-heading">
                <span class="heading-icon">🗃️</span>
                <div>
                    <div class="category-section-label">MANAJEMEN KOLEKSI</div>
                    <h2>Daftar Kategori</h2>
                    <p>Kelola kategori buku yang tersedia di perpustakaan.</p>
                </div>
            </div>

            <div class="category-total-badge">
                <span class="total-badge-dot"></span>
                <span id="categoryCount">{{ $totalCategories }}</span> kategori
            </div>
        </div>

        {{-- PENCARIAN --}}
        <div class="category-toolbar">
            <div class="category-search">
                <span class="search-symbol">⌕</span>
                <input
                    type="search"
                    id="categorySearch"
                    placeholder="Cari nama kategori atau deskripsi..."
                    autocomplete="off"
                    aria-label="Cari kategori buku"
                >
                <button
                    type="button"
                    id="clearCategorySearch"
                    class="clear-search-btn"
                    aria-label="Hapus pencarian"
                    hidden
                >×</button>
            </div>

            <span class="search-hint">
                <span>⌕</span> Cari kategori dengan cepat
            </span>
        </div>

        <div class="category-table-wrapper">
            @if ($categories->count() > 0)
                <table class="category-table">
                    <thead>
                        <tr>
                            <th class="number-column">No.</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="book-count-column">Jumlah Buku</th>
                            <th class="action-column">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="categoryTableBody">
                        @foreach ($categories as $index => $category)
                            @php
                                $bookCount = $category->books_count
                                    ?? $category->books->count();

                                $categoryName = $category->name ?? 'Tanpa Nama';
                                $categoryDescription = $category->description ?? '';
                            @endphp

                            <tr
                                class="category-row"
                                data-search="{{ \Illuminate\Support\Str::lower($categoryName . ' ' . $categoryDescription . ' ' . $category->id) }}"
                            >
                                <td class="number-cell">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <div class="category-name-cell">
                                        <div class="category-book-icon">
                                            📚
                                        </div>

                                        <div class="category-name-info">
                                            <strong>{{ $categoryName }}</strong>
                                            <span>ID #{{ $category->id }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="description-cell">
                                    @if ($categoryDescription)
                                        {{ \Illuminate\Support\Str::limit($categoryDescription, 90) }}
                                    @else
                                        <span class="no-description">
                                            Belum ada deskripsi
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($bookCount > 0)
                                        <span class="book-count-badge has-books">
                                            <span class="count-badge-icon">📖</span>
                                            {{ $bookCount }} Buku
                                        </span>
                                    @else
                                        <span class="book-count-badge no-books">
                                            <span class="count-badge-icon">○</span>
                                            0 Buku
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="category-actions">
                                        <a
                                            href="{{ route('categories.edit', $category->id) }}"
                                            class="category-action-btn edit-category-btn"
                                            aria-label="Edit kategori {{ $categoryName }}"
                                        >
                                            <span>✎</span>
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('categories.destroy', $category->id) }}"
                                            method="POST"
                                            class="delete-category-form"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="category-action-btn delete-category-btn"
                                                data-category-name="{{ $categoryName }}"
                                                aria-label="Hapus kategori {{ $categoryName }}"
                                            >
                                                <span>⌫</span>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <tr id="categoryNoResults" hidden>
                            <td colspan="5">
                                <div class="category-empty-state search-empty-state">
                                    <div class="empty-state-icon">🔎</div>
                                    <h3>Kategori Tidak Ditemukan</h3>
                                    <p>Coba kata kunci yang berbeda.</p>
                                    <button
                                        type="button"
                                        id="resetCategorySearch"
                                        class="reset-category-search"
                                    >
                                        Reset Pencarian
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="category-empty-state">
                    <div class="empty-state-icon">📚</div>
                    <h3>Belum Ada Kategori</h3>
                    <p>
                        Belum ada kategori buku yang ditambahkan.
                        Tambahkan kategori agar koleksi perpustakaan lebih terorganisasi.
                    </p>

                    <a
                        href="{{ route('categories.create') }}"
                        class="category-primary-btn empty-add-btn"
                    >
                        <span>＋</span>
                        Tambah Kategori Pertama
                    </a>
                </div>
            @endif
        </div>

        @if ($categories->count() > 0)
            <div class="category-table-footer">
                <span>
                    Menampilkan <strong id="visibleCategoryCount">{{ $totalCategories }}</strong>
                    dari <strong>{{ $totalCategories }}</strong> kategori
                </span>

                <span class="category-footer-brand">
                    <span>♥</span> E-Library SMKN 5 Surakarta
                </span>
            </div>
        @endif
    </section>

    {{-- INFORMASI --}}
    <section class="category-info-card">
        <div class="info-icon">i</div>

        <div class="info-content">
            <h3>Informasi Kategori Buku</h3>
            <p>
                Kategori digunakan untuk mengelompokkan buku berdasarkan jenis
                atau bidangnya, seperti pemrograman, matematika, bahasa,
                dan sastra. Pengelompokan yang baik membantu siswa menemukan
                buku dengan lebih mudah.
            </p>
        </div>

        <div class="info-decoration" aria-hidden="true">✿</div>
    </section>

</div>
@endsection

@push('styles')
<style>
    :root {
        --cat-green: #72B995;
        --cat-dark: #285C45;
        --cat-green-light: #EAF6EF;
        --cat-pink: #F4C5D8;
        --cat-pink-light: #FFF0F5;
        --cat-white: #FFF9FC;
        --cat-text: #2E4537;
        --cat-muted: #849188;
        --cat-border: #E4EDE6;
    }

    .category-page {
        padding-bottom: 28px;
        color: var(--cat-text);
    }

    .category-page *,
    .category-page *::before,
    .category-page *::after {
        box-sizing: border-box;
    }

    .category-hero {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        min-height: 245px;
        padding: 34px 40px;
        margin-bottom: 25px;
        overflow: hidden;
        color: #FFFFFF;
        background: linear-gradient(115deg, #285C45 0%, #397C5B 60%, #72B995 100%);
        border-radius: 25px;
        box-shadow: 0 12px 30px rgba(40, 92, 69, .12);
    }

    .category-hero-content {
        position: relative;
        z-index: 2;
        max-width: 590px;
    }

    .category-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 8px 12px;
        margin-bottom: 17px;
        color: #F5FFF8;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.1px;
    }

    .eyebrow-dot {
        width: 7px;
        height: 7px;
        background: var(--cat-pink);
        border-radius: 50%;
    }

    .category-hero h1 {
        margin: 0 0 12px;
        color: #FFFFFF;
        font-size: clamp(26px, 3vw, 36px);
        font-weight: 850;
        line-height: 1.2;
        letter-spacing: -.8px;
    }

    .category-hero p {
        max-width: 520px;
        margin: 0 0 22px;
        color: rgba(255,255,255,.85);
        font-size: 13px;
        line-height: 1.8;
    }

    .category-primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 43px;
        padding: 12px 17px;
        color: var(--cat-dark);
        background: #FFFFFF;
        border: 1px solid rgba(255,255,255,.5);
        border-radius: 12px;
        text-decoration: none;
        font-family: inherit;
        font-size: 12px;
        font-weight: 850;
        box-shadow: 0 4px 12px rgba(0,0,0,.06);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .category-primary-btn:hover {
        color: var(--cat-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,.12);
    }

    .plus-icon {
        font-size: 19px;
        line-height: 1;
    }

    .category-hero-art {
        position: relative;
        display: grid;
        place-items: center;
        width: 205px;
        height: 175px;
        flex-shrink: 0;
    }

    .art-book-stack {
        position: relative;
        z-index: 2;
        display: grid;
        place-items: center;
        width: 112px;
        height: 112px;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.3);
        border-radius: 29px;
        transform: rotate(-8deg);
        backdrop-filter: blur(4px);
    }

    .art-book-stack span {
        font-size: 55px;
        transform: rotate(8deg);
    }

    .art-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(244,197,216,.25);
    }

    .art-circle-one {
        top: 0;
        right: 8px;
        width: 58px;
        height: 58px;
    }

    .art-circle-two {
        bottom: 4px;
        left: 5px;
        width: 39px;
        height: 39px;
        background: rgba(255,255,255,.17);
    }

    .art-small-label {
        position: absolute;
        right: 0;
        bottom: 4px;
        color: rgba(255,255,255,.75);
        font-size: 8px;
        font-weight: 800;
        letter-spacing: 1.3px;
    }

    .category-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .category-stat-card {
        min-width: 0;
        padding: 22px;
        background: #FFFFFF;
        border: 1px solid var(--cat-border);
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(40,92,69,.035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .category-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(40,92,69,.08);
    }

    .stat-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 18px;
    }

    .category-stat-icon {
        display: grid;
        place-items: center;
        width: 46px;
        height: 46px;
        border-radius: 15px;
        font-size: 21px;
    }

    .icon-green {
        background: var(--cat-green-light);
    }

    .icon-pink {
        background: var(--cat-pink-light);
    }

    .icon-peach {
        background: #FFF3E7;
    }

    .stat-card-tag {
        color: #849188;
        font-size: 10px;
        font-weight: 700;
    }

    .category-stat-number {
        margin-bottom: 5px;
        color: var(--cat-dark);
        font-size: 34px;
        font-weight: 850;
        line-height: 1.1;
        letter-spacing: -1px;
    }

    .category-stat-title {
        color: #43594A;
        font-size: 13px;
        font-weight: 800;
    }

    .category-stat-description {
        margin: 8px 0 0;
        color: var(--cat-muted);
        font-size: 11px;
        line-height: 1.6;
    }

    .category-card {
        margin-bottom: 24px;
        overflow: hidden;
        background: #FFFFFF;
        border: 1px solid var(--cat-border);
        border-radius: 22px;
        box-shadow: 0 6px 25px rgba(40,92,69,.04);
    }

    .category-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 25px 27px;
        border-bottom: 1px solid #EDF2EE;
    }

    .category-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .heading-icon {
        display: grid;
        place-items: center;
        width: 45px;
        height: 45px;
        flex-shrink: 0;
        background: var(--cat-pink-light);
        border-radius: 14px;
        font-size: 21px;
    }

    .category-section-label {
        margin-bottom: 7px;
        color: #BC6F91;
        font-size: 9px;
        font-weight: 850;
        letter-spacing: 1.4px;
    }

    .category-heading h2 {
        margin: 0 0 6px;
        color: var(--cat-dark);
        font-size: 20px;
        font-weight: 850;
    }

    .category-heading p {
        margin: 0;
        color: var(--cat-muted);
        font-size: 11px;
        line-height: 1.7;
    }

    .category-total-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 13px;
        flex-shrink: 0;
        color: var(--cat-dark);
        background: var(--cat-green-light);
        border-radius: 11px;
        font-size: 11px;
        font-weight: 800;
    }

    .total-badge-dot {
        width: 7px;
        height: 7px;
        background: var(--cat-green);
        border-radius: 50%;
    }

    .category-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 18px 27px;
        background: #FCFEFC;
        border-bottom: 1px solid #EDF2EE;
    }

    .category-search {
        display: flex;
        align-items: center;
        gap: 10px;
        width: min(100%, 480px);
        min-width: 0;
        padding: 0 13px;
        background: #FFFFFF;
        border: 1px solid #DDE8E0;
        border-radius: 12px;
        transition: border-color .2s, box-shadow .2s;
    }

    .category-search:focus-within {
        border-color: var(--cat-green);
        box-shadow: 0 0 0 3px rgba(114,185,149,.14);
    }

    .search-symbol {
        color: var(--cat-dark);
        font-size: 25px;
        line-height: 1;
    }

    .category-search input {
        width: 100%;
        min-width: 0;
        height: 44px;
        padding: 0;
        color: var(--cat-text);
        background: transparent;
        border: none;
        outline: none;
        font: inherit;
        font-size: 12px;
    }

    .category-search input::placeholder {
        color: #9BA69E;
    }

    .clear-search-btn {
        width: 27px;
        height: 27px;
        flex-shrink: 0;
        color: #A75378;
        background: var(--cat-pink-light);
        border: 0;
        border-radius: 8px;
        cursor: pointer;
        font-size: 19px;
    }

    .search-hint {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #8A978D;
        font-size: 10px;
        white-space: nowrap;
    }

    .search-hint span {
        color: #BC6F91;
        font-size: 18px;
    }

    .category-table-wrapper {
        width: 100%;
        overflow-x: auto;
        scrollbar-color: #C9E4D3 #F5F8F5;
        scrollbar-width: thin;
    }

    .category-table {
        width: 100%;
        min-width: 850px;
        border-collapse: separate;
        border-spacing: 0;
        text-align: left;
    }

    .category-table thead th {
        padding: 15px 16px;
        color: #6D7D72;
        background: #F7FAF7;
        border-bottom: 1px solid #E8EFE9;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .category-table thead th:first-child,
    .category-table tbody td:first-child {
        padding-left: 27px;
    }

    .category-table tbody td {
        padding: 17px 16px;
        color: #536258;
        border-bottom: 1px solid #EDF2EE;
        font-size: 12px;
        vertical-align: middle;
    }

    .category-table tbody tr:last-child td {
        border-bottom: none;
    }

    .category-table tbody tr.category-row {
        transition: background .15s ease;
    }

    .category-table tbody tr.category-row:hover {
        background: #FBFEFB;
    }

    .number-column {
        width: 65px;
    }

    .book-count-column {
        width: 135px;
    }

    .action-column {
        width: 175px;
    }

    .number-cell {
        color: #9BA69E !important;
        font-size: 11px !important;
        font-weight: 800;
    }

    .category-name-cell {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 180px;
    }

    .category-book-icon {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        color: var(--cat-dark);
        background: var(--cat-green-light);
        border: 1px solid #DDEFE3;
        border-radius: 13px;
        font-size: 19px;
    }

    .category-row:nth-child(even) .category-book-icon {
        background: var(--cat-pink-light);
        border-color: #F4DFE8;
    }

    .category-name-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 0;
    }

    .category-name-info strong {
        color: #344B3C;
        font-size: 12px;
        font-weight: 850;
        overflow-wrap: anywhere;
    }

    .category-name-info span {
        color: #98A39A;
        font-size: 10px;
    }

    .description-cell {
        max-width: 270px;
        color: #6D7D72 !important;
        font-size: 11px !important;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .no-description {
        color: #A4ADA6;
        font-size: 11px;
        font-style: italic;
    }

    .book-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 10px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 850;
        white-space: nowrap;
    }

    .has-books {
        color: #31734B;
        background: #EAF7ED;
        border-color: #D8EDDE;
    }

    .no-books {
        color: #A75378;
        background: var(--cat-pink-light);
        border-color: #F5DCE7;
    }

    .count-badge-icon {
        font-size: 12px;
    }

    .category-actions {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .delete-category-form {
        margin: 0;
    }

    .category-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 33px;
        padding: 7px 10px;
        border: 1px solid transparent;
        border-radius: 9px;
        text-decoration: none;
        font-family: inherit;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
        cursor: pointer;
        transition: background .15s, transform .15s;
    }

    .category-action-btn:hover {
        transform: translateY(-1px);
    }

    .edit-category-btn {
        color: var(--cat-dark);
        background: var(--cat-green-light);
        border-color: #D8EBDD;
    }

    .edit-category-btn:hover {
        color: var(--cat-dark);
        background: #DDF0E3;
    }

    .delete-category-btn {
        color: #A94D70;
        background: var(--cat-pink-light);
        border-color: #F3D9E4;
    }

    .delete-category-btn:hover {
        background: #F9DFE9;
    }

    .category-empty-state {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        min-height: 290px;
        padding: 40px 22px;
        text-align: center;
    }

    .empty-state-icon {
        display: grid;
        place-items: center;
        width: 74px;
        height: 74px;
        margin-bottom: 17px;
        background: var(--cat-pink-light);
        border-radius: 24px;
        font-size: 31px;
    }

    .category-empty-state h3 {
        margin: 0 0 8px;
        color: var(--cat-dark);
        font-size: 17px;
        font-weight: 850;
    }

    .category-empty-state p {
        max-width: 390px;
        margin: 0;
        color: var(--cat-muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .empty-add-btn {
        margin-top: 21px;
        color: #FFFFFF;
        background: var(--cat-dark);
        border-color: var(--cat-dark);
    }

    .empty-add-btn:hover {
        color: #FFFFFF;
        background: #397C5B;
    }

    .reset-category-search {
        margin-top: 17px;
        padding: 10px 15px;
        color: #FFFFFF;
        background: var(--cat-dark);
        border: 0;
        border-radius: 10px;
        font: inherit;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .category-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 17px 27px;
        color: #89968C;
        background: #FCFEFC;
        border-top: 1px solid #EDF2EE;
        font-size: 11px;
    }

    .category-table-footer strong {
        color: var(--cat-dark);
    }

    .category-footer-brand {
        color: #74877A;
        font-weight: 650;
    }

    .category-footer-brand span {
        color: #D985A6;
    }

    .category-info-card {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 23px 25px;
        overflow: hidden;
        background: linear-gradient(110deg, #FFFFFF 0%, #FFF9FC 100%);
        border: 1px solid #EFE4EA;
        border-radius: 20px;
    }

    .info-icon {
        display: grid;
        place-items: center;
        width: 39px;
        height: 39px;
        flex-shrink: 0;
        color: #FFFFFF;
        background: var(--cat-dark);
        border-radius: 12px;
        font-family: Georgia, serif;
        font-size: 19px;
        font-weight: 800;
        font-style: italic;
    }

    .info-content {
        position: relative;
        z-index: 1;
        max-width: 700px;
    }

    .info-content h3 {
        margin: 1px 0 7px;
        color: var(--cat-dark);
        font-size: 13px;
        font-weight: 850;
    }

    .info-content p {
        margin: 0;
        color: #819087;
        font-size: 11px;
        line-height: 1.9;
    }

    .info-decoration {
        position: absolute;
        right: 24px;
        bottom: -25px;
        color: #F5DCE7;
        font-size: 105px;
        line-height: 1;
    }

    [hidden] {
        display: none !important;
    }

    @media (max-width: 1000px) {
        .category-hero {
            padding: 30px;
        }

        .category-hero-art {
            width: 145px;
        }

        .category-stats {
            gap: 12px;
        }

        .category-stat-card {
            padding: 18px;
        }

        .category-toolbar {
            align-items: stretch;
            flex-direction: column;
        }

        .category-search {
            width: 100%;
        }
    }

    @media (max-width: 700px) {
        .category-hero {
            min-height: auto;
            padding: 27px 23px;
            border-radius: 20px;
        }

        .category-hero-art {
            width: 85px;
            height: 100px;
        }

        .art-book-stack {
            width: 67px;
            height: 67px;
            border-radius: 19px;
        }

        .art-book-stack span {
            font-size: 35px;
        }

        .art-small-label {
            display: none;
        }

        .category-hero h1 {
            font-size: 25px;
        }

        .category-hero p {
            font-size: 12px;
        }

        .category-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .category-stat-card:last-child {
            grid-column: 1 / -1;
        }

        .category-card-header {
            align-items: flex-start;
            padding: 21px 19px;
        }

        .category-heading h2 {
            font-size: 18px;
        }

        .category-toolbar {
            padding: 16px 19px;
        }

        .search-hint {
            white-space: normal;
        }

        .category-table thead th:first-child,
        .category-table tbody td:first-child {
            padding-left: 19px;
        }

        .category-table-footer {
            align-items: flex-start;
            flex-direction: column;
            padding: 16px 19px;
        }

        .category-info-card {
            padding: 20px;
        }
    }

    @media (max-width: 420px) {
        .category-hero-art {
            display: none;
        }

        .category-eyebrow {
            font-size: 9px;
        }

        .category-stats {
            gap: 10px;
        }

        .category-stat-card {
            padding: 15px;
            border-radius: 16px;
        }

        .category-stat-number {
            font-size: 29px;
        }

        .stat-card-tag {
            font-size: 9px;
        }

        .category-card-header {
            flex-direction: column;
            gap: 14px;
        }

        .category-total-badge {
            align-self: flex-start;
        }

        .info-decoration {
            right: 5px;
            font-size: 75px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('categorySearch');
    const clearButton = document.getElementById('clearCategorySearch');
    const resetButton = document.getElementById('resetCategorySearch');
    const noResults = document.getElementById('categoryNoResults');
    const categoryCount = document.getElementById('categoryCount');
    const visibleCount = document.getElementById('visibleCategoryCount');

    const rows = Array.from(document.querySelectorAll('.category-row'));

    function filterCategories() {
        const keyword = (searchInput.value || '').trim().toLocaleLowerCase('id-ID');
        let visible = 0;

        rows.forEach(function (row) {
            const searchText = (row.dataset.search || '').toLocaleLowerCase('id-ID');
            const matches = searchText.includes(keyword);

            row.hidden = !matches;

            if (matches) {
                visible++;
            }
        });

        if (noResults) {
            noResults.hidden = visible !== 0;
        }

        if (categoryCount) {
            categoryCount.textContent = visible;
        }

        if (visibleCount) {
            visibleCount.textContent = visible;
        }

        if (clearButton) {
            clearButton.hidden = searchInput.value.length === 0;
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterCategories);
    }

    if (clearButton) {
        clearButton.addEventListener('click', function () {
            searchInput.value = '';
            searchInput.focus();
            filterCategories();
        });
    }

    if (resetButton) {
        resetButton.addEventListener('click', function () {
            searchInput.value = '';
            filterCategories();
        });
    }

    document.querySelectorAll('.delete-category-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const button = form.querySelector('.delete-category-btn');
            const categoryName = button
                ? button.dataset.categoryName
                : 'kategori ini';

            const confirmed = window.confirm(
                'Yakin ingin menghapus kategori "' + categoryName + '"?'
            );

            if (!confirmed) {
                event.preventDefault();
            }
        });
    });

    filterCategories();
});
</script>
@endpush
