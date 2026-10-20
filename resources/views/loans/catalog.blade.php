@extends('layouts.app')

@section('title', 'Katalog Buku')
@section('header_title', 'Katalog Buku')

@section('content')
@php
    $totalBooks = $books->count();

    $availableTitles = $books
        ->filter(fn ($book) => (int) ($book->available_stock ?? 0) > 0)
        ->count();
@endphp

<style>
/* ==========================================================
   BIBLIOSMK CATALOG
   Tema hijau, pink, putih
========================================================== */
.catalog-page {
    --green: #285C45;
    --green-2: #397858;
    --sage: #72B995;
    --green-soft: #EAF5ED;
    --pink: #F4C5D8;
    --pink-soft: #FFF0F5;
    --cream: #FFF9FC;
    --text: #294335;
    --muted: #819187;
    --border: #E3EDE5;

    color: var(--text);
    padding-bottom: 38px;
    font-family: inherit;
}

.catalog-page *,
.book-zoom-modal * {
    box-sizing: border-box;
}

.catalog-page button,
.catalog-page input {
    font: inherit;
}

.catalog-page button:focus-visible,
.catalog-page a:focus-visible,
.catalog-page input:focus-visible,
.book-zoom-modal button:focus-visible {
    outline: 3px solid var(--sage);
    outline-offset: 3px;
}

/* ANIMASI */
@keyframes catalogFadeIn {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes heroGlow {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(-10px, 8px) scale(1.06); }
}

@keyframes floatingBook {
    0%, 100% { transform: rotate(8deg) translateY(0); }
    50% { transform: rotate(3deg) translateY(-8px); }
}

@keyframes coverEntrance {
    from { opacity: 0; transform: scale(.92) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

@keyframes modalEntrance {
    from { opacity: 0; transform: scale(.94); }
    to { opacity: 1; transform: scale(1); }
}

/* HERO */
.catalog-hero {
    position: relative;
    isolation: isolate;
    overflow: hidden;
    padding: 30px;
    margin-bottom: 23px;
    border-radius: 23px;
    color: #fff;
    background: linear-gradient(125deg, #285C45, #397858 65%, #72B995);
    box-shadow: 0 12px 28px rgba(40, 92, 69, .13);
    animation: catalogFadeIn .65s ease both;
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
    width: 240px;
    height: 240px;
    top: -120px;
    right: -35px;
    background: rgba(244, 197, 216, .22);
    animation: heroGlow 7s ease-in-out infinite;
}

.catalog-hero::after {
    width: 160px;
    height: 160px;
    right: 100px;
    bottom: -110px;
    background: rgba(255, 255, 255, .12);
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
    margin-bottom: 15px;
    border: 1px solid rgba(255,255,255,.24);
    border-radius: 30px;
    background: rgba(255,255,255,.12);
    color: #FFEAF2;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.2px;
}

.hero-eyebrow span {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--pink);
    box-shadow: 0 0 0 4px rgba(244,197,216,.15);
}

.catalog-hero h1 {
    max-width: 540px;
    margin: 0;
    color: #fff;
    font-size: clamp(27px, 3vw, 38px);
    font-weight: 850;
    line-height: 1.2;
    letter-spacing: -1px;
}

.catalog-hero h1 em {
    color: #F8D9E5;
    font-style: normal;
}

.catalog-hero p {
    max-width: 450px;
    margin: 13px 0 0;
    color: #E2F0E6;
    font-size: 13px;
    line-height: 1.9;
}

.hero-decoration {
    position: absolute;
    right: 38px;
    bottom: 17px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 95px;
    height: 95px;
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 27px;
    background: rgba(255,255,255,.12);
    color: #FFE8F0;
    font-size: 43px;
    pointer-events: none;
    animation: floatingBook 4s ease-in-out infinite;
}

/* RINGKASAN */
.catalog-summary {
    display: grid;
    grid-template-columns: 1.4fr 1fr 1fr;
    gap: 13px;
    margin-bottom: 28px;
    animation: catalogFadeIn .65s .08s ease both;
}

.summary-card {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
    padding: 17px;
    border: 1px solid var(--border);
    border-radius: 17px;
    background: #fff;
    box-shadow: 0 4px 14px rgba(40,92,69,.035);
    transition: transform .25s ease, box-shadow .25s ease;
}

.summary-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 22px rgba(40,92,69,.08);
}

.summary-icon {
    display: flex;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: var(--green-soft);
    font-size: 22px;
}

.summary-card.pink .summary-icon {
    background: var(--pink-soft);
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

/* JUDUL BAGIAN */
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
    letter-spacing: -.4px;
}

.catalog-section-heading p {
    margin: 6px 0 0;
    color: var(--muted);
    font-size: 12px;
    line-height: 1.7;
}

.result-count {
    flex-shrink: 0;
    padding: 8px 12px;
    border: 1px solid #E8D5DF;
    border-radius: 10px;
    background: var(--pink-soft);
    color: #9B5F79;
    font-size: 10px;
    font-weight: 800;
}

/* PENCARIAN */
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

.search-icon {
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
    padding: 0 45px;
    border: 1px solid #DFE9E1;
    border-radius: 14px;
    outline: none;
    background: #fff;
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
    background: var(--pink-soft);
    color: #9B5F79;
    font-size: 20px;
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

/* GRID BUKU */
.books-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 21px;
}

.book-card {
    min-width: 0;
    overflow: hidden;
    border: 1px solid var(--border);
    border-radius: 19px;
    background: #fff;
    box-shadow: 0 5px 18px rgba(40,92,69,.045);
    animation: catalogFadeIn .55s ease both;
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}

.book-card:hover {
    transform: translateY(-5px);
    border-color: #B9DCC5;
    box-shadow: 0 15px 30px rgba(40,92,69,.11);
}

.book-card[hidden] {
    display: none !important;
}

/* AREA SAMPUL */
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
    background: rgba(255,255,255,.9);
    color: var(--green);
    font-size: 9px;
    font-weight: 800;
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
    border: 0;
    border-radius: 5px;
    background: #fff;
    box-shadow: 0 12px 24px rgba(33,65,45,.22);
    cursor: zoom-in;
    animation: coverEntrance .55s ease both;
    transition: transform .25s ease, box-shadow .25s ease;
}

.book-cover-frame:hover {
    transform: translateY(-4px) rotate(-1deg) scale(1.025);
    box-shadow: 0 17px 30px rgba(33,65,45,.26);
}

.book-cover-frame img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    background: #fff;
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
    overflow-wrap: anywhere;
    background: linear-gradient(145deg, #EAF5ED, #FFF0F5);
    color: var(--green);
    text-align: center;
    font-size: 11px;
    font-weight: 800;
}

.cover-fallback span {
    font-size: 37px;
}

/* INFORMASI BUKU */
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
    background: var(--pink-soft);
    color: #995B77;
    font-size: 9px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.book-title {
    min-height: 42px;
    margin: 0;
    color: var(--green);
    font-size: 15px;
    font-weight: 850;
    line-height: 1.5;
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
    line-height: 1.7;
    overflow-wrap: anywhere;
}

.book-meta {
    margin-top: 8px;
    color: #91A096;
    font-size: 10px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

/* DESKRIPSI */
.book-description {
    margin-top: 12px;
    padding-top: 11px;
    border-top: 1px dashed #E5EDE6;
    color: #65796B;
    font-size: 11px;
    line-height: 1.85;
    overflow-wrap: anywhere;
    white-space: normal;
}

.book-description-label {
    display: block;
    margin-bottom: 5px;
    color: #819187;
    font-size: 9px;
    font-weight: 850;
    letter-spacing: .7px;
}

.book-description-text {
    display: -webkit-box;
    overflow: hidden;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4;
}

.book-description-text.expanded {
    display: block;
    overflow: visible;
    -webkit-line-clamp: unset;
}

.description-toggle {
    display: inline-block;
    padding: 0;
    margin-top: 5px;
    border: none;
    background: transparent;
    color: var(--green-2);
    font-size: 10px;
    font-weight: 800;
    cursor: pointer;
}

.description-toggle:hover {
    color: #9B5F79;
    text-decoration: underline;
}

.book-description-empty {
    color: #A0AAA3;
    font-style: italic;
}

/* STOK DAN TOMBOL PINJAM */
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
    background: var(--sage);
    box-shadow: 0 0 0 4px var(--green-soft);
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
    box-shadow: 0 0 0 4px var(--pink-soft);
}

.btn-pinjam,
.btn-disabled {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-width: 95px;
    min-height: 39px;
    padding: 0 13px;
    border: 1px solid var(--green);
    border-radius: 11px;
    font-size: 10px;
    font-weight: 850;
    text-decoration: none;
    white-space: nowrap;
}

.btn-pinjam {
    background: var(--green);
    color: #fff;
    box-shadow: 0 5px 12px rgba(40,92,69,.12);
    transition: background .2s, transform .2s, box-shadow .2s;
}

.btn-pinjam:hover {
    transform: translateY(-2px);
    background: var(--green-2);
    color: #fff;
    box-shadow: 0 8px 16px rgba(40,92,69,.19);
}

.btn-disabled {
    border-color: #F0D8E2;
    background: var(--pink-soft);
    color: #BD8298;
}

/* KONDISI KOSONG */
.catalog-empty,
.catalog-no-books {
    padding: 42px 20px;
    border: 1px dashed #D4E5D8;
    border-radius: 18px;
    background: #fff;
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

/* MODAL ZOOM */
.book-zoom-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 25px;
    background: rgba(20, 38, 28, .94);
    backdrop-filter: blur(8px);
}

.book-zoom-modal.active {
    display: flex;
    animation: catalogFadeIn .2s ease both;
}

.zoom-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: min(88vw, 850px);
    height: min(78vh, 780px);
    animation: modalEntrance .25s ease both;
}

.zoom-title {
    max-width: 90%;
    margin: 0 0 12px;
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    text-align: center;
    overflow-wrap: anywhere;
}

.zoom-container {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    min-height: 0;
    overflow: hidden;
    touch-action: none;
    cursor: grab;
}

.zoom-container.dragging {
    cursor: grabbing;
}

.zoom-image {
    display: block;
    flex: 0 1 auto;
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    user-select: none;
    -webkit-user-drag: none;
    transform: translate(0,0) scale(1);
    transform-origin: center center;
    will-change: transform;
}

.zoom-close {
    position: fixed;
    top: 19px;
    right: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 50%;
    background: rgba(255,255,255,.12);
    color: #fff;
    font-size: 27px;
    cursor: pointer;
    transition: transform .2s, background .2s;
}

.zoom-close:hover {
    transform: rotate(90deg);
    background: rgba(244,197,216,.25);
}

.zoom-controls {
    position: fixed;
    bottom: 23px;
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
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    transition: background .2s, transform .2s;
}

.zoom-btn:hover {
    transform: translateY(-2px);
    background: rgba(244,197,216,.25);
}

.zoom-value {
    min-width: 55px;
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    text-align: center;
}

.zoom-help {
    position: fixed;
    bottom: 83px;
    left: 50%;
    max-width: calc(100vw - 24px);
    color: rgba(255,255,255,.75);
    font-size: 11px;
    text-align: center;
    transform: translateX(-50%);
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

    .zoom-content {
        width: 94vw;
        height: 72vh;
    }

    .zoom-close {
        top: 12px;
        right: 12px;
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

    .zoom-help {
        bottom: 83px;
        font-size: 9px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .catalog-page *,
    .catalog-page *::before,
    .catalog-page *::after,
    .book-zoom-modal * {
        animation-duration: .01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: .01ms !important;
        scroll-behavior: auto !important;
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

    {{-- RINGKASAN --}}
    <section class="catalog-summary">
        <div class="summary-card">
            <div class="summary-icon">📚</div>
            <div>
                <strong>{{ $totalBooks }}</strong>
                <small>Koleksi buku</small>
            </div>
        </div>

        <div class="summary-card pink">
            <div class="summary-icon">🌸</div>
            <div>
                <strong>{{ $availableTitles }}</strong>
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

    {{-- JUDUL KATALOG --}}
    <div class="catalog-section-heading">
        <div>
            <h2>Jelajahi Buku</h2>
            <p>Pilih buku yang ingin kamu baca berikutnya.</p>
        </div>

        <div class="result-count" id="resultCount" aria-live="polite">
            {{ $totalBooks }} buku
        </div>
    </div>

    {{-- PENCARIAN --}}
    <div class="catalog-toolbar">
        <div class="catalog-search">
            <span class="search-icon" aria-hidden="true">🔍</span>

            <input
                type="search"
                id="bookSearch"
                placeholder="Cari judul, penulis, kategori, penerbit, atau deskripsi..."
                autocomplete="off"
                aria-label="Cari buku"
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

    {{-- DAFTAR BUKU --}}
    <div class="books-grid" id="booksGrid">

        @forelse($books as $index => $book)
            @php
                $bookTitle = $book->title ?? 'Tanpa Judul';
                $bookAuthor = $book->author ?: 'Belum terverifikasi';

                $categoryName = $book->category
                    ? $book->category->name
                    : 'Umum';

                // Accessor cover_url dari model Book.
                $imageUrl = $book->cover_url;

                $available = (int) ($book->available_stock ?? 0);
                $description = trim((string) ($book->description ?? ''));

                $publisher = $book->publisher ?: 'Penerbit tidak tersedia';
                $year = $book->year ?? null;

                $searchText = \Illuminate\Support\Str::lower(
                    $bookTitle . ' ' .
                    $bookAuthor . ' ' .
                    $categoryName . ' ' .
                    $publisher . ' ' .
                    $description
                );
            @endphp

            <article
                class="book-card"
                data-search="{{ $searchText }}"
                style="animation-delay: {{ min($index * 0.045, 0.45) }}s"
            >
                {{-- SAMPUL --}}
                <div class="book-image-area">
                    <span class="cover-label">BIBLIOSMK ♡</span>

                    <button
                        type="button"
                        class="book-cover-frame"
                        data-image="{{ $imageUrl }}"
                        data-title="{{ $bookTitle }}"
                        aria-label="Perbesar sampul {{ $bookTitle }}"
                    >
                        <img
                            src="{{ $imageUrl }}"
                            alt="Sampul {{ $bookTitle }}"
                            loading="{{ $index < 4 ? 'eager' : 'lazy' }}"
                            onerror="
                                this.style.display='none';
                                this.nextElementSibling.style.display='flex';
                            "
                        >

                        <span class="cover-fallback">
                            <span>📖</span>
                            {{ $bookTitle }}
                        </span>
                    </button>

                    <span class="cover-decoration" aria-hidden="true">✿</span>
                </div>

                {{-- INFORMASI --}}
                <div class="book-info">
                    <div class="book-category">{{ $categoryName }}</div>

                    <h3 class="book-title">{{ $bookTitle }}</h3>

                    <div class="book-author-block">
                        <div class="book-label">PENULIS</div>
                        <p class="book-author">{{ $bookAuthor }}</p>
                    </div>

                    <div class="book-meta">
                        {{ $publisher }}

                        @if($year)
                            · {{ $year }}
                        @endif
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="book-description">
                        <span class="book-description-label">
                            DESKRIPSI BUKU
                        </span>

                        @if($description !== '')
                            <div class="book-description-text">
                                {{ $description }}
                            </div>

                            @if(\Illuminate\Support\Str::length($description) > 180)
                                <button
                                    type="button"
                                    class="description-toggle"
                                    aria-expanded="false"
                                >
                                    Baca selengkapnya ↓
                                </button>
                            @endif
                        @else
                            <div class="book-description-empty">
                                Deskripsi buku belum tersedia.
                            </div>
                        @endif
                    </div>

                    {{-- STOK DAN PEMINJAMAN --}}
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

                            <span class="btn-disabled">Habis</span>
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

    {{-- HASIL PENCARIAN KOSONG --}}
    <div class="catalog-empty" id="catalogEmpty" role="status">
        <div class="empty-icon">🔎</div>
        <strong>Buku belum ditemukan</strong>
        <p>
            Coba kata kunci lain, ya. Siapa tahu buku favoritmu ada di sana.
        </p>
    </div>
</div>

{{-- MODAL ZOOM SAMPUL --}}
<div
    class="book-zoom-modal"
    id="bookZoomModal"
    role="dialog"
    aria-modal="true"
    aria-label="Pratinjau sampul buku"
    aria-hidden="true"
>
    <button
        type="button"
        class="zoom-close"
        id="zoomClose"
        aria-label="Tutup pratinjau"
    >×</button>

    <div class="zoom-content">
        <h3 class="zoom-title" id="zoomTitle"></h3>

        <div class="zoom-container" id="zoomContainer">
            <img
                src=""
                alt=""
                class="zoom-image"
                id="zoomImage"
                draggable="false"
            >
        </div>
    </div>

    <div class="zoom-help">
        Roda mouse untuk zoom · Seret gambar untuk menggeser · Esc untuk menutup
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
    'use strict';

    /* =====================================================
       PENCARIAN BUKU
    ===================================================== */
    const searchInput = document.getElementById('bookSearch');
    const clearSearch = document.getElementById('clearSearch');
    const cards = Array.from(document.querySelectorAll('.book-card'));
    const emptyMessage = document.getElementById('catalogEmpty');
    const resultCount = document.getElementById('resultCount');

    function filterBooks() {
        const keyword = (searchInput.value || '').trim().toLocaleLowerCase();
        let visible = 0;

        cards.forEach(function (card) {
            const text = (card.dataset.search || '').toLocaleLowerCase();
            const matches = text.includes(keyword);

            card.hidden = !matches;

            if (matches) {
                visible++;
            }
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

    /* =====================================================
       TOMBOL BACA SELENGKAPNYA
    ===================================================== */
    document.querySelectorAll('.description-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const description = button.previousElementSibling;
            const expanded = description.classList.toggle('expanded');

            button.setAttribute('aria-expanded', String(expanded));
            button.textContent = expanded
                ? 'Tampilkan lebih sedikit ↑'
                : 'Baca selengkapnya ↓';
        });
    });

    /* =====================================================
       MODAL ZOOM SAMPUL
    ===================================================== */
    const modal = document.getElementById('bookZoomModal');
    const zoomImage = document.getElementById('zoomImage');
    const zoomTitle = document.getElementById('zoomTitle');
    const zoomContainer = document.getElementById('zoomContainer');

    const zoomClose = document.getElementById('zoomClose');
    const zoomIn = document.getElementById('zoomIn');
    const zoomOut = document.getElementById('zoomOut');
    const zoomReset = document.getElementById('zoomReset');
    const zoomValue = document.getElementById('zoomValue');

    const minZoom = 1;
    const maxZoom = 4;
    const zoomStep = 0.25;

    let zoom = 1;
    let x = 0;
    let y = 0;
    let dragging = false;
    let startX = 0;
    let startY = 0;
    let originX = 0;
    let originY = 0;
    let activePointerId = null;
    let oldOverflow = '';
    let lastFocusedElement = null;

    function updateZoom() {
        zoomImage.style.transform =
            'translate(' + x + 'px, ' + y + 'px) scale(' + zoom + ')';

        zoomValue.textContent = Math.round(zoom * 100) + '%';
    }

    function resetZoom() {
        zoom = 1;
        x = 0;
        y = 0;
        updateZoom();
    }

    function openZoom(src, title, triggerElement) {
        if (!src) {
            alert('Alamat gambar sampul belum tersedia.');
            return;
        }

        const testImage = new Image();

        testImage.onload = function () {
            lastFocusedElement = triggerElement || document.activeElement;

            zoomImage.src = testImage.src;
            zoomImage.alt = 'Sampul ' + title;
            zoomTitle.textContent = title;

            resetZoom();

            oldOverflow = document.body.style.overflow;
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            zoomClose.focus();
        };

        testImage.onerror = function () {
            alert(
                'Sampul gagal dimuat. Periksa nama file dan lokasi gambar di public/books.'
            );
        };

        testImage.src = src;
    }

    function closeZoom() {
        if (!modal.classList.contains('active')) {
            return;
        }

        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = oldOverflow;

        stopDragging();
        zoomImage.removeAttribute('src');

        if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
            lastFocusedElement.focus();
        }
    }

    function changeZoom(amount) {
        const nextZoom = Math.max(minZoom, Math.min(maxZoom, zoom + amount));

        if (nextZoom === zoom) {
            return;
        }

        zoom = nextZoom;

        if (zoom === 1) {
            x = 0;
            y = 0;
        }

        updateZoom();
    }

    document.querySelectorAll('.book-cover-frame').forEach(function (cover) {
        cover.addEventListener('click', function () {
            const image = cover.querySelector('img');

            if (!image || image.style.display === 'none') {
                alert('Gambar sampul tidak tersedia untuk diperbesar.');
                return;
            }

            openZoom(
                cover.dataset.image,
                cover.dataset.title || 'Buku',
                cover
            );
        });
    });

    zoomIn.addEventListener('click', function () {
        changeZoom(zoomStep);
    });

    zoomOut.addEventListener('click', function () {
        changeZoom(-zoomStep);
    });

    zoomReset.addEventListener('click', resetZoom);
    zoomClose.addEventListener('click', closeZoom);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeZoom();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!modal.classList.contains('active')) {
            return;
        }

        if (event.key === 'Escape') {
            closeZoom();
        } else if (event.key === '+' || event.key === '=') {
            changeZoom(zoomStep);
        } else if (event.key === '-') {
            changeZoom(-zoomStep);
        }
    });

    /* Zoom dengan roda mouse */
    zoomContainer.addEventListener('wheel', function (event) {
        if (!modal.classList.contains('active')) {
            return;
        }

        event.preventDefault();
        changeZoom(event.deltaY < 0 ? zoomStep : -zoomStep);
    }, { passive: false });

    /* =====================================================
       GESER GAMBAR DENGAN MOUSE / TOUCH
    ===================================================== */
    zoomContainer.addEventListener('pointerdown', function (event) {
        if (zoom <= 1 || event.button !== 0) {
            return;
        }

        dragging = true;
        activePointerId = event.pointerId;

        startX = event.clientX;
        startY = event.clientY;
        originX = x;
        originY = y;

        zoomContainer.classList.add('dragging');
        zoomContainer.setPointerCapture(event.pointerId);
        event.preventDefault();
    });

    zoomContainer.addEventListener('pointermove', function (event) {
        if (!dragging || event.pointerId !== activePointerId) {
            return;
        }

        x = originX + event.clientX - startX;
        y = originY + event.clientY - startY;
        updateZoom();
    });

    function stopDragging() {
        dragging = false;
        activePointerId = null;
        zoomContainer.classList.remove('dragging');
    }

    zoomContainer.addEventListener('pointerup', stopDragging);
    zoomContainer.addEventListener('pointercancel', stopDragging);
    zoomContainer.addEventListener('lostpointercapture', stopDragging);
});
</script>
@endsection