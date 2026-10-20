```blade
@extends('layouts.app')

@section('title', 'Peminjaman Saya')
@section('header_title', 'Peminjaman Saya')

@section('content')

@php
    $totalLoans = $loans->count();
    $pendingCount = $loans->where('status', 'pending')->count();
    $approvedCount = $loans->where('status', 'approved')->count();
    $borrowedCount = $loans->where('status', 'borrowed')->count();
    $returnedCount = $loans->where('status', 'returned')->count();
    $rejectedCount = $loans->where('status', 'rejected')->count();
@endphp

<style>
    .my-loans-page {
        --elib-green: #72B995;
        --elib-dark: #285C45;
        --elib-pink: #F4C5D8;
        --elib-pink-light: #FFF0F5;
        --elib-white: #FFF9FC;
        --elib-border: #E5EDE7;
        --elib-muted: #788B80;

        width: 100%;
        max-width: 1250px;
        margin: 0 auto;
        color: #294337;
    }

    .my-loans-page *,
    .my-loans-page *::before,
    .my-loans-page *::after {
        box-sizing: border-box;
    }

    /* HERO */
    .my-loans-page .loans-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid rgba(40, 92, 69, .08);
        border-radius: 22px;
        background: linear-gradient(125deg, #285C45 0%, #438363 58%, #72B995 100%);
        color: white;
        box-shadow: 0 12px 30px rgba(40, 92, 69, .13);
    }

    .my-loans-page .loans-hero::before {
        content: "";
        position: absolute;
        width: 280px;
        height: 280px;
        right: -90px;
        top: -170px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .10);
        pointer-events: none;
    }

    .my-loans-page .loans-hero::after {
        content: "";
        position: absolute;
        width: 160px;
        height: 160px;
        right: 170px;
        bottom: -120px;
        border-radius: 50%;
        background: rgba(244, 197, 216, .20);
        pointer-events: none;
    }

    .my-loans-page .hero-content {
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .my-loans-page .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 11px;
        margin-bottom: 13px;
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 999px;
        background: rgba(255, 255, 255, .12);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
    }

    .my-loans-page .hero-badge-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #F4C5D8;
    }

    .my-loans-page .hero-title {
        margin: 0;
        color: #fff;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.5px;
    }

    .my-loans-page .hero-description {
        max-width: 590px;
        margin: 9px 0 0;
        color: rgba(255, 255, 255, .86);
        font-size: 12px;
        line-height: 1.8;
    }

    .my-loans-page .hero-button,
    .my-loans-page .empty-button {
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 43px;
        padding: 0 17px;
        border: 1px solid transparent;
        border-radius: 11px;
        background: #FFF9FC;
        color: #285C45;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
        box-shadow: 0 6px 18px rgba(24, 57, 40, .13);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .my-loans-page .hero-button:hover,
    .my-loans-page .empty-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(24, 57, 40, .17);
    }

    /* SECTION TITLE */
    .my-loans-page .section-title {
        margin-bottom: 14px;
    }

    .my-loans-page .section-title h3 {
        margin: 0;
        color: #285C45;
        font-size: 16px;
        font-weight: 800;
    }

    .my-loans-page .section-title p {
        margin: 5px 0 0;
        color: var(--elib-muted);
        font-size: 11px;
    }

    /* STATISTICS */
    .my-loans-page .loan-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 13px;
        margin-bottom: 25px;
    }

    .my-loans-page .loan-stat {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        padding: 17px;
        border: 1px solid var(--elib-border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(40, 92, 69, .035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .my-loans-page .loan-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 22px rgba(40, 92, 69, .08);
    }

    .my-loans-page .loan-stat-icon {
        display: flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 13px;
        font-size: 18px;
    }

    .my-loans-page .loan-stat-icon.green {
        background: #EAF6EF;
        color: #285C45;
    }

    .my-loans-page .loan-stat-icon.pink {
        background: #FFF0F5;
        color: #B45C83;
    }

    .my-loans-page .loan-stat-icon.sage {
        background: #E4F3E9;
        color: #438363;
    }

    .my-loans-page .loan-stat-icon.gray {
        background: #F3F6F3;
        color: #66776B;
    }

    .my-loans-page .loan-stat-text {
        min-width: 0;
    }

    .my-loans-page .loan-stat-text span {
        display: block;
        color: #788B80;
        font-size: 10px;
        line-height: 1.5;
    }

    .my-loans-page .loan-stat-text strong {
        display: block;
        margin-top: 4px;
        color: #285C45;
        font-size: 23px;
        line-height: 1.1;
    }

    /* ALERTS */
    .my-loans-page .loan-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 15px;
        margin-bottom: 16px;
        border: 1px solid var(--elib-border);
        border-radius: 12px;
        font-size: 11px;
        line-height: 1.7;
    }

    .my-loans-page .loan-alert.success {
        background: #EAF6EF;
        border-color: #C8E7D3;
        color: #285C45;
    }

    .my-loans-page .loan-alert.error {
        background: #FFF0F5;
        border-color: #F1CADB;
        color: #9F365D;
    }

    /* HISTORY CARD */
    .my-loans-page .history-card {
        overflow: hidden;
        border: 1px solid var(--elib-border);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(40, 92, 69, .035);
    }

    .my-loans-page .history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 22px;
        border-bottom: 1px solid #EDF2EE;
        background: #FFFCFD;
    }

    .my-loans-page .history-header h3 {
        margin: 0;
        color: #285C45;
        font-size: 14px;
        font-weight: 800;
    }

    .my-loans-page .history-header p {
        margin: 5px 0 0;
        color: #788B80;
        font-size: 10px;
        line-height: 1.6;
    }

    .my-loans-page .history-count {
        flex: 0 0 auto;
        padding: 8px 11px;
        border: 1px solid #F1D5E1;
        border-radius: 9px;
        background: #FFF0F5;
        color: #96516D;
        font-size: 10px;
        font-weight: 800;
    }

    .my-loans-page .history-body {
        padding: 20px 22px 22px;
    }

    /* LOAN ITEMS */
    .my-loans-page .loan-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .my-loans-page .loan-item {
        position: relative;
        overflow: hidden;
        padding: 18px;
        border: 1px solid #E4EDE6;
        border-radius: 15px;
        background: #fff;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .my-loans-page .loan-item::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 4px;
        background: var(--elib-green);
    }

    .my-loans-page .loan-item:hover {
        border-color: #B9DCC5;
        box-shadow: 0 8px 22px rgba(40, 92, 69, .06);
    }

    .my-loans-page .loan-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        padding-bottom: 14px;
        border-bottom: 1px solid #EDF2EE;
    }

    .my-loans-page .loan-heading {
        min-width: 0;
    }

    .my-loans-page .loan-code {
        display: block;
        color: #285C45;
        font-size: 13px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .my-loans-page .loan-date {
        margin-top: 5px;
        color: #788B80;
        font-size: 10px;
    }

    /* STATUS */
    .my-loans-page .loan-status {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .my-loans-page .loan-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .my-loans-page .status-pending {
        color: #9B651D;
        background: #FFF5DF;
    }

    .my-loans-page .status-approved {
        color: #285C45;
        background: #EAF6EF;
    }

    .my-loans-page .status-borrowed {
        color: #397C59;
        background: #E3F3E8;
    }

    .my-loans-page .status-returned {
        color: #66776B;
        background: #F1F5F1;
    }

    .my-loans-page .status-rejected {
        color: #A23E64;
        background: #FFF0F5;
    }

    /* BOOK LIST */
    .my-loans-page .loan-books {
        display: flex;
        flex-direction: column;
        gap: 9px;
        margin-top: 14px;
    }

    .my-loans-page .book-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border: 1px solid #EDF2EE;
        border-radius: 11px;
        background: #FFFCFD;
    }

    .my-loans-page .book-cover-small {
        display: flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 64px;
        overflow: hidden;
        border: 1px solid #E5EDE7;
        border-radius: 7px;
        background: #FFF0F5;
        color: #B45C83;
        font-size: 21px;
    }

    .my-loans-page .book-cover-small img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .my-loans-page .book-info {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .my-loans-page .book-info strong {
        overflow: hidden;
        color: #285C45;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.5;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .my-loans-page .book-info span {
        overflow: hidden;
        color: #788B80;
        font-size: 10px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .my-loans-page .book-quantity {
        display: inline-flex;
        width: fit-content;
        padding: 4px 7px;
        border-radius: 6px;
        background: #EAF6EF;
        color: #285C45 !important;
        font-size: 9px !important;
        font-weight: 700;
    }

    /* META */
    .my-loans-page .loan-meta {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #EDF2EE;
    }

    .my-loans-page .meta-box {
        min-width: 0;
        padding: 11px;
        border: 1px solid #EDF2EE;
        border-radius: 10px;
        background: #FFFCFD;
    }

    .my-loans-page .meta-box span {
        display: block;
        color: #87978D;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: .3px;
        text-transform: uppercase;
    }

    .my-loans-page .meta-box strong {
        display: block;
        overflow: hidden;
        margin-top: 6px;
        color: #285C45;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.5;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* NOTES AND STATUS MESSAGES */
    .my-loans-page .loan-note,
    .my-loans-page .status-info {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        padding: 11px 12px;
        margin-top: 12px;
        border: 1px solid #E8EFE9;
        border-radius: 10px;
        font-size: 10px;
        line-height: 1.7;
    }

    .my-loans-page .loan-note {
        background: #FFFCFD;
        color: #64776B;
    }

    .my-loans-page .loan-note strong {
        color: #285C45;
    }

    .my-loans-page .status-info.warning {
        background: #FFF7E8;
        border-color: #F4E5C4;
        color: #92621F;
    }

    .my-loans-page .status-info.info {
        background: #F0F7F2;
        border-color: #D9EADF;
        color: #285C45;
    }

    .my-loans-page .status-info.success {
        background: #EAF6EF;
        border-color: #C8E7D3;
        color: #285C45;
    }

    .my-loans-page .status-info.secondary {
        background: #F5F7F5;
        border-color: #E5EBE6;
        color: #66776B;
    }

    .my-loans-page .status-info.danger {
        background: #FFF0F5;
        border-color: #F1CADB;
        color: #9F365D;
    }

    .my-loans-page .status-info-icon {
        flex: 0 0 auto;
        font-weight: 800;
    }

    /* EMPTY STATE */
    .my-loans-page .empty-state {
        padding: 52px 20px;
        text-align: center;
    }

    .my-loans-page .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 66px;
        height: 66px;
        margin: 0 auto 16px;
        border: 1px solid #F1D5E1;
        border-radius: 20px;
        background: #FFF0F5;
        font-size: 27px;
    }

    .my-loans-page .empty-state h3 {
        margin: 0;
        color: #285C45;
        font-size: 16px;
        font-weight: 800;
    }

    .my-loans-page .empty-state p {
        max-width: 380px;
        margin: 9px auto 20px;
        color: #788B80;
        font-size: 11px;
        line-height: 1.8;
    }

    .my-loans-page .empty-button {
        background: #285C45;
        color: #fff;
    }

    /* INFORMATION CARD */
    .my-loans-page .information-card {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-top: 18px;
        padding: 17px;
        border: 1px solid #F1D5E1;
        border-radius: 15px;
        background: linear-gradient(110deg, #FFF0F5, #FFFCFD);
    }

    .my-loans-page .information-icon {
        display: flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        width: 37px;
        height: 37px;
        border-radius: 11px;
        background: #F4C5D8;
        color: #7D3C59;
        font-size: 15px;
        font-weight: 800;
    }

    .my-loans-page .information-content {
        min-width: 0;
    }

    .my-loans-page .information-content strong {
        display: block;
        color: #285C45;
        font-size: 11px;
        font-weight: 800;
    }

    .my-loans-page .information-content p {
        margin: 6px 0 0;
        color: #6F8175;
        font-size: 10px;
        line-height: 1.8;
    }

    /* RESPONSIVE */
    @media (max-width: 1000px) {
        .my-loans-page .loan-stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 700px) {
        .my-loans-page .loans-hero {
            flex-direction: column;
            align-items: flex-start;
            padding: 23px 20px;
        }

        .my-loans-page .hero-title {
            font-size: 23px;
        }

        .my-loans-page .hero-button {
            width: 100%;
        }

        .my-loans-page .loan-stat-grid {
            gap: 10px;
        }

        .my-loans-page .loan-stat {
            padding: 13px;
            gap: 9px;
        }

        .my-loans-page .loan-stat-icon {
            width: 37px;
            height: 37px;
            font-size: 15px;
        }

        .my-loans-page .loan-stat-text span {
            font-size: 9px;
        }

        .my-loans-page .loan-stat-text strong {
            font-size: 20px;
        }

        .my-loans-page .history-header {
            padding: 16px;
        }

        .my-loans-page .history-body {
            padding: 14px;
        }

        .my-loans-page .loan-item {
            padding: 14px;
        }

        .my-loans-page .loan-meta {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 450px) {
        .my-loans-page .hero-title {
            font-size: 21px;
        }

        .my-loans-page .loan-stat {
            align-items: flex-start;
            padding: 11px;
        }

        .my-loans-page .loan-stat-icon {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }

        .my-loans-page .loan-stat-text span {
            font-size: 8px;
        }

        .my-loans-page .loan-stat-text strong {
            font-size: 18px;
        }

        .my-loans-page .loan-top {
            flex-direction: column;
            align-items: flex-start;
            gap: 9px;
        }

        .my-loans-page .book-cover-small {
            width: 43px;
            height: 58px;
        }

        .my-loans-page .book-info strong {
            font-size: 11px;
        }

        .my-loans-page .book-info span {
            font-size: 9px;
        }

        .my-loans-page .meta-box {
            padding: 9px;
        }

        .my-loans-page .meta-box strong {
            font-size: 9px;
        }

        .my-loans-page .history-count {
            font-size: 9px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .my-loans-page *,
        .my-loans-page *::before,
        .my-loans-page *::after {
            transition: none !important;
        }
    }
</style>

<div class="my-loans-page">

    {{-- HERO --}}
    <section class="loans-hero">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Aktivitas Perpustakaan
            </div>

            <h1 class="hero-title">Peminjaman Saya</h1>

            <p class="hero-description">
                Pantau pengajuan, status peminjaman, dan riwayat buku yang pernah kamu pinjam melalui E-Library SMK Negeri 5 Surakarta.
            </p>
        </div>

        <a href="{{ route('catalog') }}" class="hero-button">
            <span>＋</span>
            Ajukan Peminjaman
        </a>
    </section>

    {{-- STATISTIK --}}
    <div class="section-title">
        <h3>Ringkasan Peminjaman</h3>
        <p>Informasi aktivitas peminjaman kamu.</p>
    </div>

    <div class="loan-stat-grid">
        <div class="loan-stat">
            <div class="loan-stat-icon green">📚</div>
            <div class="loan-stat-text">
                <span>Total Peminjaman</span>
                <strong>{{ $totalLoans }}</strong>
            </div>
        </div>

        <div class="loan-stat">
            <div class="loan-stat-icon pink">⏳</div>
            <div class="loan-stat-text">
                <span>Menunggu</span>
                <strong>{{ $pendingCount }}</strong>
            </div>
        </div>

        <div class="loan-stat">
            <div class="loan-stat-icon sage">✓</div>
            <div class="loan-stat-text">
                <span>Sedang Dipinjam</span>
                <strong>{{ $borrowedCount }}</strong>
            </div>
        </div>

        <div class="loan-stat">
            <div class="loan-stat-icon gray">↻</div>
            <div class="loan-stat-text">
                <span>Selesai</span>
                <strong>{{ $returnedCount }}</strong>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="loan-alert success">
            <strong>✓</strong>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="loan-alert error">
            <strong>!</strong>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="loan-alert error">
            <strong>!</strong>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- RIWAYAT --}}
    <section class="history-card">
        <div class="history-header">
            <div>
                <h3>Riwayat Peminjaman</h3>
                <p>Daftar pengajuan dan transaksi buku kamu.</p>
            </div>

            <div class="history-count">
                {{ $totalLoans }} Transaksi
            </div>
        </div>

        <div class="history-body">
            @if($loans->count() > 0)
                <div class="loan-list">
                    @foreach($loans as $loan)
                        @php
                            $statusClass = match($loan->status) {
                                'pending' => 'status-pending',
                                'approved' => 'status-approved',
                                'borrowed' => 'status-borrowed',
                                'returned' => 'status-returned',
                                'rejected' => 'status-rejected',
                                default => 'status-returned',
                            };

                            $statusText = match($loan->status) {
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui',
                                'borrowed' => 'Sedang Dipinjam',
                                'returned' => 'Dikembalikan',
                                'rejected' => 'Ditolak',
                                default => ucfirst($loan->status),
                            };
                        @endphp

                        <article class="loan-item">
                            <div class="loan-top">
                                <div class="loan-heading">
                                    <span class="loan-code">
                                        {{ $loan->loan_code }}
                                    </span>

                                    <div class="loan-date">
                                        Diajukan pada
                                        {{ $loan->loan_date?->format('d M Y') ?? '-' }}
                                    </div>
                                </div>

                                <span class="loan-status {{ $statusClass }}">
                                    <span class="loan-status-dot"></span>
                                    {{ $statusText }}
                                </span>
                            </div>

                            {{-- DAFTAR BUKU --}}
                            <div class="loan-books">
                                @forelse($loan->loanDetails as $detail)
                                    <div class="book-row">
                                        <div class="book-cover-small">
                                            @if($detail->book?->cover)
                                                <img
                                                    src="{{ asset('storage/' . $detail->book->cover) }}"
                                                    alt="{{ $detail->book->title }}"
                                                    loading="lazy"
                                                >
                                            @else
                                                📖
                                            @endif
                                        </div>

                                        <div class="book-info">
                                            <strong>
                                                {{ $detail->book?->title ?? 'Buku tidak ditemukan' }}
                                            </strong>

                                            <span>
                                                {{ $detail->book?->author ?? 'Penulis tidak tersedia' }}
                                            </span>

                                            <span class="book-quantity">
                                                Jumlah: {{ $detail->quantity }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="loan-note">
                                        <strong>!</strong>
                                        <div>Detail buku tidak tersedia.</div>
                                    </div>
                                @endforelse
                            </div>

                            {{-- INFORMASI TRANSAKSI --}}
                            <div class="loan-meta">
                                <div class="meta-box">
                                    <span>Tanggal Pinjam</span>
                                    <strong>
                                        {{ $loan->loan_date?->format('d M Y') ?? '-' }}
                                    </strong>
                                </div>

                                <div class="meta-box">
                                    <span>Batas Pengembalian</span>
                                    <strong>
                                        {{ $loan->due_date?->format('d M Y') ?? '-' }}
                                    </strong>
                                </div>

                                <div class="meta-box">
                                    <span>Diproses Oleh</span>
                                    <strong>
                                        {{ $loan->approvedBy?->name ?? 'Belum Diproses' }}
                                    </strong>
                                </div>
                            </div>

                            {{-- CATATAN --}}
                            @if($loan->notes)
                                <div class="loan-note">
                                    <strong>i</strong>
                                    <div>
                                        <strong>Catatan:</strong>
                                        {{ $loan->notes }}
                                    </div>
                                </div>
                            @endif

                            {{-- KETERANGAN STATUS --}}
                            @if($loan->status === 'pending')
                                <div class="status-info warning">
                                    <span class="status-info-icon">⏳</span>
                                    <div>
                                        Pengajuan sedang menunggu verifikasi petugas perpustakaan.
                                    </div>
                                </div>
                            @elseif($loan->status === 'approved')
                                <div class="status-info info">
                                    <span class="status-info-icon">✓</span>
                                    <div>
                                        Pengajuan telah disetujui. Silakan datang ke perpustakaan untuk mengambil buku.
                                    </div>
                                </div>
                            @elseif($loan->status === 'borrowed')
                                <div class="status-info success">
                                    <span class="status-info-icon">📚</span>
                                    <div>
                                        Buku sedang kamu pinjam. Jangan lupa mengembalikan sebelum
                                        <strong>{{ $loan->due_date?->format('d M Y') ?? '-' }}</strong>.
                                    </div>
                                </div>
                            @elseif($loan->status === 'returned')
                                <div class="status-info secondary">
                                    <span class="status-info-icon">✓</span>
                                    <div>
                                        Buku sudah dikembalikan dan transaksi telah selesai.
                                    </div>
                                </div>
                            @elseif($loan->status === 'rejected')
                                <div class="status-info danger">
                                    <span class="status-info-icon">✕</span>
                                    <div>
                                        Pengajuan peminjaman ditolak oleh petugas.
                                    </div>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">📚</div>

                    <h3>Belum Ada Peminjaman</h3>

                    <p>
                        Kamu belum memiliki riwayat peminjaman. Cari buku yang ingin kamu baca melalui katalog E-Library.
                    </p>

                    <a href="{{ route('catalog') }}" class="empty-button">
                        Lihat Katalog Buku
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- INFORMASI --}}
    <div class="information-card">
        <div class="information-icon">i</div>

        <div class="information-content">
            <strong>Informasi Peminjaman</strong>

            <p>
                Setelah pengajuan disetujui oleh petugas, status berubah menjadi <b>Disetujui</b>. Buku dapat diambil di perpustakaan dan status kemudian berubah menjadi <b>Sedang Dipinjam</b>.
            </p>

            <p>
                Pastikan buku dikembalikan sebelum tanggal jatuh tempo untuk menghindari denda keterlambatan.
            </p>
        </div>
    </div>

</div>

@endsection
```