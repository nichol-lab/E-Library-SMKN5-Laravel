```php
@extends('layouts.app')

@section('title', 'Katalog Buku')
@section('header_title', 'Katalog Buku')

@section('content')

@php
    $bookImages = [
        'Basis Data' => 'basis-data.jpg',
        'Kamus Bahasa Indonesia' => 'kamus-bahasa-indonesia-1.jpg',
        'Laravel untuk Pemula' => 'flutter.jpg',
        'Laskar Pelangi' => 'laskar-pelangi.jpg',
        'Matematika untuk SMK' => 'matematika-10.jpg',
        'Pemrograman PHP Dasar' => 'pemrograman-php.jpg',
        'Sejarah Indonesia' => 'sejarah-indonesia-10.jpg',
    ];
@endphp

<style>
/* =====================================================
   BIBLIOSMK CATALOG — PINK, GREEN & WHITE
===================================================== */

.catalog-page {
    --sage: #72B995;
    --green: #285C45;
    --green-light: #EAF5ED;
    --pink: #F4C5D8;
    --pink-light: #FFF0F5;
    --white: #FFFFFF;
    --cream: #FFF9FC;
    --text: #294335;
    --muted: #819187;
    --border: #E5EDE6;

    color: var(--text);
    padding-bottom: 42px;
    font-family: inherit;
}

.catalog-page * {
    box-sizing: border-box;
}

.catalog-page button,
.catalog-page input {
    font: inherit;
}

/* HERO */

.catalog-hero {
    position: relative;
    overflow: hidden;
    isolation: isolate;
    padding: 30px;
    margin-bottom: 25px;
    border-radius: 24px;
    background: linear-gradient(125deg, #285C45 0%, #397858 65%, #72B995 100%);
    color: white;
    box-shadow: 0 12px 30px rgba(40, 92, 69, .14);
}

.catalog-hero::before,
.catalog-hero::after {
    content: "";
    position: absolute;
    z-index: -1;
    border-radius: 50%;
    pointer-events: none;
}

.catalog-hero::before {
    width: 230px;
    height: 230px;
    right: -50px;
    top: -115px;
    background: rgba(244, 197, 216, .20);
}

.catalog-hero::after {
    width: 145px;
    height: 145px;
    right: 100px;
    bottom: -95px;
    background: rgba(255, 255, 255, .10);
}

.hero-content {
    position: relative;
    z-index: 1;
    max-width: 650px;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 12px;
    margin-bottom: 17px;
    border: 1px solid rgba(255,255,255,.23);
    border-radius: 30px;
    background: rgba(255,255,255,.12);
    color: #FFEAF2;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.3px;
}

.hero-eyebrow span {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--pink);
}

.catalog-hero h1 {
    max-width: 540px;
    margin: 0;
    color: #FFFFFF;
    font-size: clamp(27px, 3vw, 38px);
    font-weight: 850;
    line-height: 1.18;
    letter-spacing: -1.1px;
}

.catalog-hero h1 em {
    color: #F8D9E5;
    font-style: normal;
}

.catalog-hero p {
    max-width: 440px;
    margin: 13px 0 0;
    color: #E2F0E6;
    font-size: 13px;
    line-height: 1.9;
}

.hero-decoration {
    position: absolute;
    right: 35px;
    bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 28px;
    background: rgba(255,255,255,.12);
    color: #FFE8F0;
    font-size: 45px;
    transform: rotate(9deg);
    pointer-events: none;
}

/* COLLECTION SUMMARY */

.catalog-summary {
    display: grid;
    grid-template-columns: minmax(0, 1.4fr) repeat(2, minmax(0, 1fr));
    gap: 13px;
    margin-bottom: 28px;
}

.summary-card {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
    padding: 17px;
    border: 1px solid var(--border);
    border-radius: 17px;
    background: var(--white);
    box-shadow: 0 4px 14px rgba(40, 92, 69, .035);
}

.summary-icon {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: var(--green-light);
    font-size: 22px;
}

.summary-card.pink .summary-icon {
    background: var(--pink-light);
}

.summary-card strong {
    display: block;
    color: var(--green);
    font-size: 22px;
    font-weight: 850;
    line-height: 1.25;
}

.summary-card small {
    display: block;
    margin-top: 4px;
    color: var(--muted);
    font-size: 10px;
    line-height: 1.5;
}

/* SECTION HEADING */

.catalog-section-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 17px;
}

.catalog-section-heading h2 {
    margin: 0;
    color: var(--green);
    font-size: 22px;
    font-weight: 850;
    letter-spacing: -.45px;
}

.catalog-section-heading p {
    margin: 6px 0 0;
    color: var(--muted);
    font-size: 12px;
    line-height: 1.6;
}

.result-count {
    flex-shrink: 0;
    padding: 8px 12px;
    border: 1px solid #E8D5DF;
    border-radius: 10px;
    background: var(--pink-light);
    color: #9B5F79;
    font-size: 10px;
    font-weight: 800;
}

/* SEARCH BAR */

.catalog-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 23px;
}

.catalog-search {
    position: relative;
    flex: 1;
    min-width: 0;
}

.catalog-search .search-icon {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    font-size: 16px;
    pointer-events: none;
}

.catalog-search input {
    width: 100%;
    height: 48px;
    padding: 0 44px 0 45px;
    border: 1px solid #DFE9E1;
    border-radius: 14px;
    outline: none;
    background: #FFFFFF;
    color: var(--text);
    font-size: 12px;
    transition: border-color .2s, box-shadow .2s;
}

.catalog-search input::placeholder {
    color: #9AA99F;
}

.catalog-search input:focus {
    border-color: var(--sage);
    box-shadow: 0 0 0 4px rgba(114,185,149,.13);
}

.clear-search {
    position: absolute;
    top: 50%;
    right: 10px;
    display: none;
    align-items: center;
    justify-content: center;
    width: 29px;
    height: 29px;
    transform: translateY(-50%);
    border: none;
    border-radius: 9px;
    background: var(--pink-light);
    color: #9B5F79;
    cursor: pointer;
}

.clear-search.visible {
    display: flex;
}

.catalog-toolbar-note {
    flex-shrink: 0;
    color: var(--muted);
    font-size: 11px;
    white-space: nowrap;
}

/* BOOK GRID */

.books-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 21px;
}

/* BOOK CARD */

.book-card {
    min-width: 0;
    overflow: hidden;
    border: 1px solid #E4EDE5;
    border-radius: 19px;
    background: #FFFFFF;
    box-shadow: 0 5px 18px rgba(40,92,69,.045);
    animation: cardEnter .4s ease both;
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}

.book-card:hover {
    transform: translateY(-5px);
    border-color: #C2DFCB;
    box-shadow: 0 15px 30px rgba(40,92,69,.11);
}

/* BOOK COVER */

.book-image-area {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 255px;
    overflow: hidden;
    background:
        radial-gradient(ellipse at 20% 20%, rgba(244,197,216,.48), transparent 43%),
        radial-gradient(ellipse at 85% 85%, rgba(114,185,149,.28), transparent 45%),
        #F6FAF6;
}

.cover-label {
    position: absolute;
    top: 13px;
    left: 13px;
    z-index: 2;
    padding: 6px 9px;
    border: 1px solid rgba(255,255,255,.8);
    border-radius: 8px;
    background: rgba(255,255,255,.83);
    color: var(--green);
    font-size: 9px;
    font-weight: 800;
    backdrop-filter: blur(8px);
}

.cover-decoration {
    position: absolute;
    right: 14px;
    bottom: 11px;
    color: rgba(40,92,69,.35);
    font-size: 19px;
    pointer-events: none;
}

.book-cover-frame {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 148px;
    height: 202px;
    overflow: hidden;
    border-radius: 5px;
    background: white;
    box-shadow: 0 12px 24px rgba(33,65,45,.22);
    cursor: zoom-in;
    transition: transform .25s, box-shadow .25s;
}

.book-cover-frame:hover {
    transform: translateY(-3px) rotate(-1deg);
    box-shadow: 0 17px 30px rgba(33,65,45,.26);
}

.book-cover-frame img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.cover-fallback {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 9px;
    width: 100%;
    height: 100%;
    padding: 12px;
    background: linear-gradient(145deg, #EAF5ED, #FFF0F5);
    color: var(--green);
    text-align: center;
    font-size: 11px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.cover-fallback span {
    font-size: 37px;
}

/* BOOK DETAILS */

.book-info {
    padding: 19px 18px 17px;
}

.book-category {
    display: inline-flex;
    max-width: 100%;
    padding: 6px 10px;
    margin-bottom: 12px;
    border: 1px solid #F0D9E3;
    border-radius: 8px;
    background: #FFF0F5;
    color: #995B77;
    font-size: 9px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.book-title {
    min-height: 42px;
    margin: 0;
    color: #285C45;
    font-size: 15px;
    font-weight: 850;
    line-height: 1.45;
    overflow-wrap: anywhere;
}

.book-author-block {
    margin-top: 13px;
}

.book-label {
    margin-bottom: 5px;
    color: #9BA99F;
    font-size: 10px;
}

.book-author {
    margin: 0;
    color: #425B49;
    font-size: 11px;
    font-weight: 750;
    line-height: 1.6;
    overflow-wrap: anywhere;
}

.book-meta {
    min-height: 31px;
    margin-top: 8px;
    color: #91A096;
    font-size: 10px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

/* CARD FOOTER */

.book-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-top: 15px;
    padding-top: 14px;
    border-top: 1px solid #EAF0EB;
}

.availability {
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-width: 0;
}

.availability-status {
    display: flex;
    align-items: center;
    gap: 7px;
    color: #347953;
    font-size: 10px;
    font-weight: 850;
}

.availability-dot {
    width: 7px;
    height: 7px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #72B995;
    box-shadow: 0 0 0 4px #EAF5ED;
}

.availability-count {
    color: #94A198;
    font-size: 9px;
}

.availability.out-of-stock .availability-status {
    color: #BD617D;
}

.availability.out-of-stock .availability-dot {
    background: #D97994;
    box-shadow: 0 0 0 4px #FFF0F5;
}

/* BUTTON */

.btn-pinjam {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-width: 95px;
    min-height: 39px;
    padding: 0 13px;
    border: 1px solid var(--green);
    border-radius: 11px;
    background: var(--green);
    color: #FFFFFF;
    font-size: 10px;
    font-weight: 850;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 5px 12px rgba(40,92,69,.12);
    transition: background .2s, transform .2s, box-shadow .2s;
}

.btn-pinjam:hover {
    transform: translateY(-2px);
    background: #397858;
    color: #FFFFFF;
    box-shadow: 0 8px 16px rgba(40,92,69,.19);
}

.btn-disabled {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 85px;
    min-height: 39px;
    padding: 0 12px;
    border: 1px solid #F0D8E2;
    border-radius: 11px;
    background: #FFF0F5;
    color: #BD8298;
    font-size: 10px;
    font-weight: 800;
}

/* EMPTY STATES */

.catalog-empty,
.catalog-no-books {
    padding: 42px 20px;
    border: 1px dashed #D4E5D8;
    border-radius: 18px;
    background: #FFFFFF;
    color: var(--muted);
    text-align: center;
    line-height: 1.8;
}

.catalog-empty {
    display: none;
    margin-top: 18px;
}

.catalog-no-books {
    grid-column: 1 / -1;
}

.empty-icon {
    margin-bottom: 12px;
    font-size: 42px;
}

.catalog-empty strong,
.catalog-no-books strong {
    color: var(--green);
    font-size: 15px;
}

.catalog-empty p,
.catalog-no-books p {
    margin: 6px 0 0;
    font-size: 12px;
}

/* ZOOM MODAL */

.book-zoom-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 25px;
    background: rgba(24,45,33,.91);
    backdrop-filter: blur(8px);
}

.book-zoom-modal.active {
    display: flex;
}

.zoom-container {
    display: flex;
    align-items: center;
    justify-content: center;
    width: min(80vw, 650px);
    height: min(76vh, 720px);
    overflow: hidden;
    touch-action: none;
}

.zoom-image {
    display: block;
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    user-select: none;
    -webkit-user-drag: none;
    cursor: grab;
    transform: translate(0,0) scale(1);
    transition: transform .15s ease;
}

.zoom-image.dragging {
    cursor: grabbing;
    transition: none;
}

.zoom-close {
    position: fixed;
    top: 20px;
    right: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 50%;
    background: rgba(255,255,255,.12);
    color: white;
    font-size: 27px;
    cursor: pointer;
}

.zoom-controls {
    position: fixed;
    bottom: 24px;
    left: 50%;
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 8px;
    border: 1px solid rgba(255,255,255,.16);
    border-radius: 15px;
    background: rgba(40,92,69,.96);
    transform: translateX(-50%);
}

.zoom-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 10px;
    background: rgba(255,255,255,.1);
    color: white;
    font-size: 20px;
    cursor: pointer;
}

.zoom-btn:hover {
    background: rgba(244,197,216,.25);
}

.zoom-value {
    min-width: 55px;
    color: white;
    font-size: 11px;
    font-weight: 800;
    text-align: center;
}

/* ANIMATION */

@keyframes cardEnter {
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* RESPONSIVE */

@media (min-width: 1450px) {
    .books-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

@media (max-width: 1050px) {
    .books-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .catalog-summary {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .hero-decoration {
        right: 25px;
    }
}

@media (max-width: 650px) {
    .catalog-hero {
        padding: 23px 20px;
        border-radius: 20px;
    }

    .catalog-hero h1 {
        max-width: 390px;
        font-size: 29px;
    }

    .catalog-hero p {
        max-width: 330px;
        font-size: 12px;
    }

    .hero-decoration {
        right: -15px;
        bottom: -10px;
        width: 75px;
        height: 75px;
        font-size: 32px;
        opacity: .65;
    }

    .catalog-summary {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 9px;
        margin-bottom: 25px;
    }

    .summary-card {
        gap: 10px;
        padding: 12px;
        border-radius: 14px;
    }

    .summary-card:first-child {
        grid-column: 1 / -1;
    }

    .summary-icon {
        width: 40px;
        height: 40px;
        font-size: 19px;
    }

    .summary-card strong {
        font-size: 19px;
    }

    .catalog-section-heading h2 {
        font-size: 20px;
    }

    .catalog-toolbar-note {
        display: none;
    }

    .books-grid {
        gap: 12px;
    }

    .book-image-area {
        height: 200px;
    }

    .book-cover-frame {
        width: 120px;
        height: 165px;
    }

    .book-info {
        padding: 14px 12px;
    }

    .book-title {
        min-height: 40px;
        font-size: 13px;
    }

    .book-bottom {
        align-items: stretch;
        flex-direction: column;
    }

    .btn-pinjam,
    .btn-disabled {
        width: 100%;
    }
}

@media (max-width: 380px) {
    .catalog-hero h1 {
        font-size: 25px;
    }

    .catalog-section-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .books-grid {
        grid-template-columns: 1fr;
    }

    .book-image-area {
        height: 245px;
    }

    .book-cover-frame {
        width: 150px;
        height: 205px;
    }

    .book-bottom {
        align-items: center;
        flex-direction: row;
    }

    .btn-pinjam,
    .btn-disabled {
        width: auto;
    }
}

@media (prefers-reduced-motion: reduce) {
    .catalog-page *,
    .catalog-page *::before,
    .catalog-page *::after {
        animation-duration: .01ms !important;
        transition-duration: .01ms !important;
    }
}
</style>

<div class="catalog-page">

    {{-- HERO --}}
    <section class="catalog-hero">
        <div class="hero-content">
            <div class="hero-eyebrow">
                <span></span>
                BIBLIOSMK LIBRARY
            </div>

            <h1>
                Setiap buku punya
                <em>cerita.</em>
                Temukan ceritamu.
            </h1>

            <p>
                Jelajahi koleksi bacaan pilihanmu, temukan pengetahuan
                baru, dan mulai petualangan membaca hari ini.
            </p>
        </div>

        <div class="hero-decoration" aria-hidden="true">♡</div>
    </section>

    {{-- SUMMARY --}}
    <section class="catalog-summary">
        <div class="summary-card">
            <div class="summary-icon">📚</div>
            <div>
                <strong>{{ $books->count() }}</strong>
                <small>Koleksi buku</small>
            </div>
        </div>

        <div class="summary-card pink">
            <div class="summary-icon">🌸</div>
            <div>
                <strong>{{ $books->where('available_stock', '>', 0)->count() }}</strong>
                <small>Judul tersedia</small>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">🌿</div>
            <div>
                <strong>Let's read</strong>
                <small>Tambah wawasanmu</small>
            </div>
        </div>
    </section>

    {{-- SECTION HEADING --}}
    <div class="catalog-section-heading">
        <div>
            <h2>Jelajahi Buku</h2>
            <p>Pilih buku yang ingin kamu baca berikutnya.</p>
        </div>

        <div class="result-count" id="resultCount">
            {{ $books->count() }} buku
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="catalog-toolbar">
        <div class="catalog-search">
            <span class="search-icon" aria-hidden="true">🔍</span>

            <input
                type="search"
                id="bookSearch"
                placeholder="Cari judul, penulis, atau kategori..."
                autocomplete="off"
                aria-label="Cari buku berdasarkan judul, penulis, atau kategori"
            >

            <button
                type="button"
                class="clear-search"
                id="clearSearch"
                aria-label="Hapus pencarian"
            >×</button>
        </div>

        <div class="catalog-toolbar-note">
            ✨ Temukan bacaan favoritmu
        </div>
    </div>

    {{-- BOOK GRID --}}
    <div class="books-grid" id="booksGrid">

        @forelse($books as $index => $book)

            @php
                $imageName = $bookImages[$book->title] ?? null;

                if (!$imageName && !empty($book->cover)) {
                    $imageUrl = asset('storage/' . $book->cover);
                } elseif ($imageName) {
                    $imageUrl = asset('books/' . $imageName);
                } else {
                    $imageUrl = asset('book-icon.jpg');
                }

                $available = (int) ($book->available_stock ?? 0);
                $categoryName = $book->category->name ?? 'Umum';
                $bookTitle = $book->title ?? 'Tanpa Judul';
                $bookAuthor = $book->author ?? '-';
            @endphp

            <article
                class="book-card"
                data-search="{{ \Illuminate\Support\Str::lower($bookTitle . ' ' . $bookAuthor . ' ' . $categoryName . ' ' . ($book->publisher ?? '')) }}"
                style="animation-delay: {{ min($index * 0.045, 0.5) }}s"
            >

                <div class="book-image-area">
                    <span class="cover-label">BIBLIOSMK ♡</span>

                    <div
                        class="book-cover-frame"
                        data-image="{{ $imageUrl }}"
                        data-title="{{ $bookTitle }}"
                        role="button"
                        tabindex="0"
                        aria-label="Perbesar sampul {{ $bookTitle }}"
                    >
                        <img
                            src="{{ $imageUrl }}"
                            alt="Sampul {{ $bookTitle }}"
                            loading="lazy"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
                        >

                        <div class="cover-fallback">
                            <span>📖</span>
                            {{ $bookTitle }}
                        </div>
                    </div>

                    <span class="cover-decoration" aria-hidden="true">✿</span>
                </div>

                <div class="book-info">
                    <div class="book-category">
                        {{ $categoryName }}
                    </div>

                    <h3 class="book-title">
                        {{ $bookTitle }}
                    </h3>

                    <div class="book-author-block">
                        <div class="book-label">PENULIS</div>

                        <p class="book-author">
                            {{ $bookAuthor }}
                        </p>
                    </div>

                    <div class="book-meta">
                        {{ $book->publisher ?? 'Penerbit tidak tersedia' }}

                        @if($book->year)
                            · {{ $book->year }}
                        @endif
                    </div>

                    <div class="book-bottom">
                        @if($available > 0)
                            <div class="availability">
                                <div class="availability-status">
                                    <span class="availability-dot"></span>
                                    Tersedia
                                </div>

                                <div class="availability-count">
                                    {{ $available }} buku
                                </div>
                            </div>

                            <a
                                href="{{ route('loans.create', ['book_id' => $book->id]) }}"
                                class="btn-pinjam"
                            >
                                Pinjam <span aria-hidden="true">→</span>
                            </a>
                        @else
                            <div class="availability out-of-stock">
                                <div class="availability-status">
                                    <span class="availability-dot"></span>
                                    Stok habis
                                </div>

                                <div class="availability-count">
                                    Belum tersedia
                                </div>
                            </div>

                            <span class="btn-disabled">
                                Habis
                            </span>
                        @endif
                    </div>
                </div>
            </article>

        @empty
            <div class="catalog-no-books">
                <div class="empty-icon">📚</div>
                <strong>Belum ada buku di katalog</strong>
                <p>Koleksi buku akan muncul di sini setelah ditambahkan.</p>
            </div>
        @endforelse

    </div>

    {{-- SEARCH EMPTY --}}
    <div class="catalog-empty" id="catalogEmpty" role="status">
        <div class="empty-icon">🔎</div>
        <strong>Buku belum ditemukan</strong>
        <p>Coba kata kunci lain, ya. Siapa tahu buku favoritmu ada di sana.</p>
    </div>

</div>

{{-- ZOOM MODAL --}}
<div
    class="book-zoom-modal"
    id="bookZoomModal"
    role="dialog"
    aria-modal="true"
    aria-label="Pratinjau sampul buku"
>
    <button
        type="button"
        class="zoom-close"
        id="zoomClose"
        aria-label="Tutup"
    >×</button>

    <div class="zoom-container" id="zoomContainer">
        <img
            src=""
            alt=""
            class="zoom-image"
            id="zoomImage"
            draggable="false"
        >
    </div>

    <div class="zoom-controls">
        <button type="button" class="zoom-btn" id="zoomOut" aria-label="Perkecil">−</button>
        <button type="button" class="zoom-btn" id="zoomReset" aria-label="Reset zoom">⟳</button>
        <div class="zoom-value" id="zoomValue">100%</div>
        <button type="button" class="zoom-btn" id="zoomIn" aria-label="Perbesar">+</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* SEARCH */
    const searchInput = document.getElementById('bookSearch');
    const clearSearch = document.getElementById('clearSearch');
    const cards = Array.from(document.querySelectorAll('.book-card'));
    const emptyMessage = document.getElementById('catalogEmpty');
    const resultCount = document.getElementById('resultCount');

    function filterBooks() {
        const keyword = (searchInput.value || '').trim().toLowerCase();
        let visible = 0;

        cards.forEach(function (card) {
            const matches = (card.dataset.search || '').includes(keyword);
            card.style.display = matches ? '' : 'none';

            if (matches) visible++;
        });

        emptyMessage.style.display =
            keyword !== '' && visible === 0 && cards.length > 0
                ? 'block'
                : 'none';

        resultCount.textContent = visible + ' buku';
        clearSearch.classList.toggle('visible', keyword !== '');
    }

    searchInput.addEventListener('input', filterBooks);

    clearSearch.addEventListener('click', function () {
        searchInput.value = '';
        filterBooks();
        searchInput.focus();
    });

    /* ZOOM */
    const modal = document.getElementById('bookZoomModal');
    const zoomImage = document.getElementById('zoomImage');
    const zoomContainer = document.getElementById('zoomContainer');
    const zoomClose = document.getElementById('zoomClose');
    const zoomIn = document.getElementById('zoomIn');
    const zoomOut = document.getElementById('zoomOut');
    const zoomReset = document.getElementById('zoomReset');
    const zoomValue = document.getElementById('zoomValue');

    let zoom = 1;
    const minZoom = 1;
    const maxZoom = 4;
    const step = 0.25;

    let x = 0;
    let y = 0;
    let dragging = false;
    let startX = 0;
    let startY = 0;
    let originX = 0;
    let originY = 0;
    let oldOverflow = '';

    function updateZoom() {
        zoomImage.style.transform =
            `translate(${x}px, ${y}px) scale(${zoom})`;

        zoomValue.textContent = Math.round(zoom * 100) + '%';
    }

    function resetZoom() {
        zoom = 1;
        x = 0;
        y = 0;
        updateZoom();
    }

    function openZoom(src, title) {
        if (!src) return;

        zoomImage.src = src;
        zoomImage.alt = 'Sampul ' + title;
        resetZoom();

        oldOverflow = document.body.style.overflow;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        zoomClose.focus();
    }

    function closeZoom() {
        modal.classList.remove('active');
        document.body.style.overflow = oldOverflow;
        dragging = false;
        zoomImage.classList.remove('dragging');
        zoomImage.src = '';
    }

    function changeZoom(amount) {
        zoom = Math.max(minZoom, Math.min(maxZoom, zoom + amount));

        if (zoom === 1) {
            x = 0;
            y = 0;
        }

        updateZoom();
    }

    document.querySelectorAll('.book-cover-frame').forEach(function (cover) {
        function showCover() {
            const image = cover.querySelector('img');

            if (image && image.style.display === 'none') return;

            openZoom(cover.dataset.image, cover.dataset.title || 'Buku');
        }

        cover.addEventListener('click', showCover);

        cover.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                showCover();
            }
        });
    });

    zoomIn.addEventListener('click', function () {
        changeZoom(step);
    });

    zoomOut.addEventListener('click', function () {
        changeZoom(-step);
    });

    zoomReset.addEventListener('click', resetZoom);
    zoomClose.addEventListener('click', closeZoom);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) closeZoom();
    });

    document.addEventListener('keydown', function (event) {
        if (!modal.classList.contains('active')) return;

        if (event.key === 'Escape') closeZoom();
        if (event.key === '+' || event.key === '=') changeZoom(step);
        if (event.key === '-') changeZoom(-step);
    });

    zoomContainer.addEventListener('wheel', function (event) {
        event.preventDefault();
        changeZoom(event.deltaY < 0 ? step : -step);
    }, { passive: false });

    /* MOUSE DRAG */
    zoomImage.addEventListener('mousedown', function (event) {
        if (zoom <= 1) return;

        dragging = true;
        zoomImage.classList.add('dragging');

        startX = event.clientX;
        startY = event.clientY;
        originX = x;
        originY = y;

        event.preventDefault();
    });

    document.addEventListener('mousemove', function (event) {
        if (!dragging) return;

        x = originX + event.clientX - startX;
        y = originY + event.clientY - startY;
        updateZoom();
    });

    function stopDragging() {
        dragging = false;
        zoomImage.classList.remove('dragging');
    }

    document.addEventListener('mouseup', stopDragging);

    /* TOUCH DRAG */
    zoomImage.addEventListener('touchstart', function (event) {
        if (zoom <= 1 || event.touches.length !== 1) return;

        dragging = true;
        startX = event.touches[0].clientX;
        startY = event.touches[0].clientY;
        originX = x;
        originY = y;
    }, { passive: true });

    zoomImage.addEventListener('touchmove', function (event) {
        if (!dragging || event.touches.length !== 1) return;

        x = originX + event.touches[0].clientX - startX;
        y = originY + event.touches[0].clientY - startY;
        updateZoom();
    }, { passive: true });

    zoomImage.addEventListener('touchend', stopDragging);
    zoomImage.addEventListener('touchcancel', stopDragging);
});
</script>

@endsection
```