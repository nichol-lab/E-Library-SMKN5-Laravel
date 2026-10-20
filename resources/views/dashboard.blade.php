```php
@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
@php
    $isStaff = in_array($user->role, ['admin', 'petugas']);
    $isAdmin = $user->role === 'admin';
@endphp

<style>
    :root {
        --db-green: #72B995;
        --db-dark: #285C45;
        --db-pink: #F4C5D8;
        --db-pink-light: #FFF0F5;
        --db-white: #FFF9FC;
        --db-text: #244536;
        --db-muted: #7B9084;
        --db-border: #E5EEE8;
    }

    .dashboard-page {
        color: var(--db-text);
        padding-bottom: 24px;
    }

    .dashboard-page * {
        box-sizing: border-box;
    }

    .dashboard-page .welcome-banner {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 22px;
        overflow: hidden;
        padding: 30px;
        margin-bottom: 23px;
        border-radius: 22px;
        background: linear-gradient(120deg, #285C45 0%, #39785B 68%, #72B995 100%);
        box-shadow: 0 12px 30px rgba(40, 92, 69, .13);
    }

    .dashboard-page .welcome-banner::before {
        content: "";
        position: absolute;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        right: 8%;
        top: -130px;
        background: rgba(255, 240, 245, .13);
    }

    .dashboard-page .welcome-banner::after {
        content: "";
        position: absolute;
        width: 145px;
        height: 145px;
        border-radius: 50%;
        right: -28px;
        bottom: -85px;
        background: rgba(244, 197, 216, .30);
    }

    .dashboard-page .welcome-copy,
    .dashboard-page .welcome-button {
        position: relative;
        z-index: 1;
    }

    .dashboard-page .welcome-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        margin-bottom: 14px;
        border-radius: 20px;
        background: rgba(255,255,255,.14);
        color: #FFE7F0;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .6px;
    }

    .dashboard-page .welcome-title {
        color: #fff !important;
        font-size: clamp(22px, 3vw, 30px);
        font-weight: 800;
        line-height: 1.35;
        margin: 0 0 9px;
        overflow-wrap: anywhere;
    }

    .dashboard-page .welcome-description {
        color: #E6F4EA !important;
        font-size: 13px;
        line-height: 1.8;
        margin: 0;
        max-width: 560px;
    }

    .dashboard-page .welcome-decoration {
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 92px;
        height: 92px;
        border-radius: 27px;
        background: rgba(255, 255, 255, .13);
        border: 1px solid rgba(255, 255, 255, .2);
        color: #FFF0F5;
        font-size: 43px;
        transform: rotate(5deg);
    }

    .dashboard-page .db-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 17px;
        border-radius: 12px;
        background: #FFF0F5;
        border: 1px solid #F4C5D8;
        color: #285C45 !important;
        text-decoration: none !important;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
        transition: .2s ease;
    }

    .dashboard-page .db-button:hover {
        background: #F4C5D8;
        transform: translateY(-2px);
    }

    .dashboard-page .section-heading {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 12px;
        margin: 26px 0 14px;
    }

    .dashboard-page .section-title {
        color: var(--db-dark) !important;
        font-size: 16px;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .dashboard-page .section-description {
        color: var(--db-muted) !important;
        font-size: 11px;
        line-height: 1.7;
        margin: 0;
    }

    .dashboard-page .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 22px;
    }

    .dashboard-page .stat-card {
        position: relative;
        min-width: 0;
        padding: 19px;
        overflow: hidden;
        border: 1px solid var(--db-border);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(40, 92, 69, .035);
        transition: transform .2s, box-shadow .2s;
    }

    .dashboard-page .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(40, 92, 69, .09);
    }

    .dashboard-page .stat-card::after {
        content: "";
        position: absolute;
        width: 75px;
        height: 75px;
        border-radius: 50%;
        right: -30px;
        bottom: -40px;
        background: var(--stat-tint, #EAF5EE);
        opacity: .8;
    }

    .dashboard-page .stat-card.pink {
        --stat-tint: #FFF0F5;
    }

    .dashboard-page .stat-card.green {
        --stat-tint: #EAF5EE;
    }

    .dashboard-page .stat-card.cream {
        --stat-tint: #F8F3E8;
    }

    .dashboard-page .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 19px;
    }

    .dashboard-page .stat-label {
        color: var(--db-muted) !important;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.6;
    }

    .dashboard-page .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 41px;
        height: 41px;
        flex-shrink: 0;
        border-radius: 14px;
        background: #EAF5EE;
        color: var(--db-dark);
        font-size: 19px;
    }

    .dashboard-page .stat-card.pink .stat-icon {
        background: var(--db-pink-light);
        color: #9A5574;
    }

    .dashboard-page .stat-card.cream .stat-icon {
        background: #F8F3E8;
        color: #92733B;
    }

    .dashboard-page .stat-number {
        position: relative;
        z-index: 1;
        color: #173D2D !important;
        font-size: 29px;
        font-weight: 850;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }

    .dashboard-page .stat-caption {
        color: var(--db-muted);
        font-size: 10px;
        margin-top: 7px;
    }

    .dashboard-page .main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.35fr) minmax(280px, .85fr);
        gap: 18px;
        margin-bottom: 22px;
    }

    .dashboard-page .panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--db-border);
        border-radius: 19px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(40, 92, 69, .035);
    }

    .dashboard-page .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 19px 21px;
        border-bottom: 1px solid var(--db-border);
        background: linear-gradient(100deg, #FFFFFF, #FFF9FC);
    }

    .dashboard-page .panel-title {
        color: var(--db-dark) !important;
        font-size: 14px;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .dashboard-page .panel-subtitle {
        color: var(--db-muted) !important;
        font-size: 10px;
        line-height: 1.7;
        margin: 0;
    }

    .dashboard-page .panel-body {
        padding: 19px 21px;
    }

    .dashboard-page .panel-link {
        color: var(--db-dark) !important;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none !important;
        white-space: nowrap;
    }

    .dashboard-page .panel-link:hover {
        color: #A65F80 !important;
    }

    .dashboard-page .status-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .dashboard-page .status-row {
        display: grid;
        grid-template-columns: 39px minmax(0, 1fr) auto;
        align-items: center;
        gap: 12px;
    }

    .dashboard-page .status-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 39px;
        height: 39px;
        border-radius: 13px;
        background: #FFF0F5;
        color: #9A5574;
        font-size: 16px;
        font-weight: 800;
    }

    .dashboard-page .status-row:nth-child(2) .status-icon {
        background: #EAF5EE;
        color: var(--db-dark);
    }

    .dashboard-page .status-row:nth-child(3) .status-icon {
        background: #F5F0FB;
        color: #7956A5;
    }

    .dashboard-page .status-row:nth-child(4) .status-icon {
        background: #F1F5F2;
        color: #64786D;
    }

    .dashboard-page .status-name {
        color: var(--db-text);
        font-size: 12px;
        font-weight: 750;
        margin-bottom: 4px;
    }

    .dashboard-page .status-note {
        color: var(--db-muted);
        font-size: 10px;
    }

    .dashboard-page .status-count {
        min-width: 39px;
        padding: 8px 10px;
        border-radius: 11px;
        background: #FFF0F5;
        color: #8C4D6A;
        text-align: center;
        font-size: 13px;
        font-weight: 800;
    }

    .dashboard-page .status-row:nth-child(2) .status-count {
        background: #EAF5EE;
        color: var(--db-dark);
    }

    .dashboard-page .status-row:nth-child(3) .status-count {
        background: #F5F0FB;
        color: #7956A5;
    }

    .dashboard-page .status-row:nth-child(4) .status-count {
        background: #F1F5F2;
        color: #64786D;
    }

    .dashboard-page .quick-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .dashboard-page .quick-action {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        padding: 13px;
        border: 1px solid var(--db-border);
        border-radius: 14px;
        background: #fff;
        color: var(--db-dark) !important;
        text-decoration: none !important;
        transition: .2s ease;
    }

    .dashboard-page .quick-action:hover {
        border-color: var(--db-pink);
        background: var(--db-pink-light);
        transform: translateX(3px);
    }

    .dashboard-page .quick-action-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 39px;
        height: 39px;
        flex-shrink: 0;
        border-radius: 13px;
        background: #EAF5EE;
        color: var(--db-dark);
        font-size: 17px;
    }

    .dashboard-page .quick-action:nth-child(even) .quick-action-icon {
        background: var(--db-pink-light);
        color: #9A5574;
    }

    .dashboard-page .quick-action-text {
        min-width: 0;
        flex: 1;
    }

    .dashboard-page .quick-action-text strong {
        display: block;
        color: var(--db-dark) !important;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .dashboard-page .quick-action-text small {
        display: block;
        color: var(--db-muted) !important;
        font-size: 10px;
        line-height: 1.6;
    }

    .dashboard-page .quick-arrow {
        color: #9CB7A6;
        font-size: 17px;
    }

    .dashboard-page .guide-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 13px;
    }

    .dashboard-page .guide-item {
        padding: 18px;
        border: 1px solid var(--db-border);
        border-radius: 16px;
        background: #fff;
        transition: .2s ease;
    }

    .dashboard-page .guide-item:nth-child(2) {
        background: #FFF9FC;
    }

    .dashboard-page .guide-item:hover {
        border-color: var(--db-pink);
        transform: translateY(-2px);
    }

    .dashboard-page .guide-number {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 36px;
        height: 36px;
        margin-bottom: 15px;
        border-radius: 12px;
        background: #EAF5EE;
        color: var(--db-dark);
        font-size: 12px;
        font-weight: 850;
    }

    .dashboard-page .guide-item:nth-child(2) .guide-number {
        background: var(--db-pink);
        color: #79465C;
    }

    .dashboard-page .guide-item:nth-child(3) .guide-number {
        background: #FFF0F5;
        color: #9A5574;
    }

    .dashboard-page .guide-item strong {
        display: block;
        color: var(--db-dark);
        font-size: 12px;
        margin-bottom: 7px;
    }

    .dashboard-page .guide-item p {
        color: var(--db-muted);
        font-size: 10px;
        line-height: 1.8;
        margin: 0;
    }

    .dashboard-page .bottom-note {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 20px;
        padding: 15px 18px;
        border: 1px solid #F2D8E3;
        border-radius: 15px;
        background: linear-gradient(100deg, #FFF0F5, #FFF9FC);
    }

    .dashboard-page .bottom-note-icon {
        font-size: 22px;
    }

    .dashboard-page .bottom-note strong {
        display: block;
        color: var(--db-dark);
        font-size: 11px;
        margin-bottom: 4px;
    }

    .dashboard-page .bottom-note p {
        color: var(--db-muted);
        font-size: 10px;
        line-height: 1.7;
        margin: 0;
    }

    @media (max-width: 1100px) {
        .dashboard-page .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-page .main-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .dashboard-page .welcome-banner {
            padding: 22px 19px;
            border-radius: 18px;
        }

        .dashboard-page .welcome-decoration {
            display: none;
        }

        .dashboard-page .welcome-title {
            font-size: 23px;
        }

        .dashboard-page .welcome-description {
            font-size: 12px;
        }

        .dashboard-page .welcome-button {
            width: 100%;
        }

        .dashboard-page .welcome-button .db-button {
            width: 100%;
        }

        .dashboard-page .stats-grid {
            gap: 10px;
        }

        .dashboard-page .stat-card {
            padding: 15px;
            border-radius: 15px;
        }

        .dashboard-page .stat-icon {
            width: 35px;
            height: 35px;
            border-radius: 11px;
        }

        .dashboard-page .stat-number {
            font-size: 25px;
        }

        .dashboard-page .panel-header,
        .dashboard-page .panel-body {
            padding: 16px;
        }

        .dashboard-page .guide-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-page .guide-item {
            padding: 15px;
        }

        .dashboard-page .section-heading {
            margin-top: 22px;
        }
    }

    @media (max-width: 360px) {
        .dashboard-page .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-page .panel-header {
            align-items: flex-start;
        }
    }
</style>

<div class="dashboard-page">

    {{-- BANNER SAMBUTAN --}}
    <section class="welcome-banner">
        <div class="welcome-copy">
            <div class="welcome-label">
                <span>✦</span> BIBLIOSMK · DIGITAL LIBRARY
            </div>

            <h1 class="welcome-title">
                Hai, {{ $user->name }}! 👋
            </h1>

            <p class="welcome-description">
                @if ($user->role === 'siswa')
                    Selamat datang di perpustakaan digital SMK Negeri 5 Surakarta.
                    Temukan buku favoritmu dan mulai petualangan membaca hari ini.
                @elseif ($isAdmin)
                    Selamat datang di panel administrator.
                    Pantau koleksi buku, pengguna, dan aktivitas perpustakaan dari satu tempat.
                @else
                    Selamat datang di panel petugas perpustakaan.
                    Kelola koleksi dan proses peminjaman dengan lebih mudah.
                @endif
            </p>
        </div>

        <div class="welcome-decoration" aria-hidden="true">📚</div>

        <div class="welcome-button">
            @if ($user->role === 'siswa')
                <a href="{{ route('catalog') }}" class="db-button">
                    Jelajahi Buku <span>↗</span>
                </a>
            @else
                <a href="{{ route('loans.index') }}" class="db-button">
                    Kelola Peminjaman <span>↗</span>
                </a>
            @endif
        </div>
    </section>

    {{-- STATISTIK UTAMA --}}
    <div class="section-heading">
        <div>
            <h2 class="section-title">Ringkasan Perpustakaan</h2>
            <p class="section-description">Informasi utama koleksi dan aktivitas saat ini.</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card green">
            <div class="stat-top">
                <span class="stat-label">Total Koleksi Buku</span>
                <div class="stat-icon">▤</div>
            </div>
            <div class="stat-number">{{ $totalBooks }}</div>
            <div class="stat-caption">Koleksi buku perpustakaan</div>
        </div>

        <div class="stat-card pink">
            <div class="stat-top">
                <span class="stat-label">Kategori Buku</span>
                <div class="stat-icon">▦</div>
            </div>
            <div class="stat-number">{{ $totalCategories }}</div>
            <div class="stat-caption">Kategori koleksi tersedia</div>
        </div>

        @if ($isStaff)
            <div class="stat-card cream">
                <div class="stat-top">
                    <span class="stat-label">Total Pengguna</span>
                    <div class="stat-icon">♙</div>
                </div>
                <div class="stat-number">{{ $totalUsers }}</div>
                <div class="stat-caption">Akun terdaftar di sistem</div>
            </div>
        @endif

        <div class="stat-card {{ $isStaff ? 'pink' : 'green' }}">
            <div class="stat-top">
                <span class="stat-label">
                    {{ $isStaff ? 'Total Peminjaman' : 'Peminjaman Saya' }}
                </span>
                <div class="stat-icon">↗</div>
            </div>
            <div class="stat-number">{{ $totalLoans }}</div>
            <div class="stat-caption">
                {{ $isStaff ? 'Seluruh transaksi peminjaman' : 'Total transaksi akunmu' }}
            </div>
        </div>
    </div>

    {{-- AKTIVITAS DAN MENU --}}
    <div class="main-grid">

        <section class="panel">
            <div class="panel-header">
                <div>
                    <h3 class="panel-title">
                        {{ $isStaff ? 'Status Peminjaman' : 'Aktivitas Peminjaman' }}
                    </h3>
                    <p class="panel-subtitle">
                        {{ $isStaff ? 'Ringkasan seluruh transaksi perpustakaan' : 'Pantau perkembangan pengajuan bukumu' }}
                    </p>
                </div>

                @if ($isStaff)
                    <a href="{{ route('loans.index') }}" class="panel-link">Lihat semua ↗</a>
                @else
                    <a href="{{ route('loans.mine') }}" class="panel-link">Riwayat saya ↗</a>
                @endif
            </div>

            <div class="panel-body">
                <div class="status-list">
                    <div class="status-row">
                        <div class="status-icon">◷</div>
                        <div>
                            <div class="status-name">Menunggu Persetujuan</div>
                            <div class="status-note">Pengajuan yang belum diproses</div>
                        </div>
                        <div class="status-count">{{ $pendingLoans }}</div>
                    </div>

                    <div class="status-row">
                        <div class="status-icon">✓</div>
                        <div>
                            <div class="status-name">Disetujui</div>
                            <div class="status-note">Peminjaman telah disetujui</div>
                        </div>
                        <div class="status-count">{{ $approvedLoans }}</div>
                    </div>

                    <div class="status-row">
                        <div class="status-icon">↗</div>
                        <div>
                            <div class="status-name">Sedang Dipinjam</div>
                            <div class="status-note">Buku belum dikembalikan</div>
                        </div>
                        <div class="status-count">{{ $borrowedLoans }}</div>
                    </div>

                    <div class="status-row">
                        <div class="status-icon">✓</div>
                        <div>
                            <div class="status-name">Selesai</div>
                            <div class="status-note">Buku sudah dikembalikan</div>
                        </div>
                        <div class="status-count">{{ $returnedLoans }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <div>
                    <h3 class="panel-title">Menu Pintasan</h3>
                    <p class="panel-subtitle">Akses halaman yang sering digunakan.</p>
                </div>
            </div>

            <div class="panel-body">
                <div class="quick-list">
                    @if ($isAdmin)
                        <a href="{{ route('books.index') }}" class="quick-action">
                            <span class="quick-action-icon">▤</span>
                            <span class="quick-action-text">
                                <strong>Data Buku</strong>
                                <small>Kelola koleksi perpustakaan</small>
                            </span>
                            <span class="quick-arrow">›</span>
                        </a>

                        <a href="{{ route('categories.index') }}" class="quick-action">
                            <span class="quick-action-icon">▦</span>
                            <span class="quick-action-text">
                                <strong>Kategori Buku</strong>
                                <small>Atur kategori koleksi</small>
                            </span>
                            <span class="quick-arrow">›</span>
                        </a>

                        <a href="{{ route('users.index') }}" class="quick-action">
                            <span class="quick-action-icon">♙</span>
                            <span class="quick-action-text">
                                <strong>Data Pengguna</strong>
                                <small>Kelola akun pengguna</small>
                            </span>
                            <span class="quick-arrow">›</span>
                        </a>
                    @elseif ($user->role === 'petugas')
                        <a href="{{ route('books.index') }}" class="quick-action">
                            <span class="quick-action-icon">▤</span>
                            <span class="quick-action-text">
                                <strong>Data Buku</strong>
                                <small>Lihat dan kelola koleksi buku</small>
                            </span>
                            <span class="quick-arrow">›</span>
                        </a>

                        <a href="{{ route('categories.index') }}" class="quick-action">
                            <span class="quick-action-icon">▦</span>
                            <span class="quick-action-text">
                                <strong>Kategori Buku</strong>
                                <small>Lihat kategori koleksi</small>
                            </span>
                            <span class="quick-arrow">›</span>
                        </a>
                    @else
                        <a href="{{ route('catalog') }}" class="quick-action">
                            <span class="quick-action-icon">▤</span>
                            <span class="quick-action-text">
                                <strong>Katalog Buku</strong>
                                <small>Temukan buku yang ingin dibaca</small>
                            </span>
                            <span class="quick-arrow">›</span>
                        </a>

                        <a href="{{ route('loans.create') }}" class="quick-action">
                            <span class="quick-action-icon">＋</span>
                            <span class="quick-action-text">
                                <strong>Ajukan Peminjaman</strong>
                                <small>Kirim permintaan peminjaman buku</small>
                            </span>
                            <span class="quick-arrow">›</span>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="quick-action">
                            <span class="quick-action-icon">◎</span>
                            <span class="quick-action-text">
                                <strong>Profil Saya</strong>
                                <small>Periksa informasi akun</small>
                            </span>
                            <span class="quick-arrow">›</span>
                        </a>
                    @endif

                    <a href="{{ $isStaff ? route('loans.index') : route('loans.mine') }}" class="quick-action">
                        <span class="quick-action-icon">↗</span>
                        <span class="quick-action-text">
                            <strong>{{ $isStaff ? 'Kelola Peminjaman' : 'Peminjaman Saya' }}</strong>
                            <small>{{ $isStaff ? 'Periksa dan proses transaksi' : 'Periksa status dan riwayat buku' }}</small>
                        </span>
                        <span class="quick-arrow">›</span>
                    </a>
                </div>
            </div>
        </section>
    </div>

    {{-- PANDUAN KHUSUS SISWA --}}
    @if ($user->role === 'siswa')
        <div class="section-heading">
            <div>
                <h2 class="section-title">Mulai dari Sini 🌸</h2>
                <p class="section-description">Tiga langkah sederhana menggunakan perpustakaan digital.</p>
            </div>
        </div>

        <section class="panel">
            <div class="panel-body">
                <div class="guide-grid">
                    <div class="guide-item">
                        <div class="guide-number">01</div>
                        <strong>Temukan Buku</strong>
                        <p>Buka katalog, cari judul yang kamu inginkan, lalu periksa ketersediaannya.</p>
                    </div>

                    <div class="guide-item">
                        <div class="guide-number">02</div>
                        <strong>Ajukan Peminjaman</strong>
                        <p>Pilih buku dan isi pengajuan sesuai ketentuan perpustakaan.</p>
                    </div>

                    <div class="guide-item">
                        <div class="guide-number">03</div>
                        <strong>Pantau Status</strong>
                        <p>Periksa riwayat untuk mengetahui perkembangan pengajuan peminjamanmu.</p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <div class="bottom-note">
        <span class="bottom-note-icon">🌷</span>
        <div>
            <strong>Read more, learn more. ♡</strong>
            <p>
                BiblioSMK — Perpustakaan Digital SMK Negeri 5 Surakarta.
                {{ $isStaff ? 'Terima kasih telah membantu menjaga layanan perpustakaan.' : 'Selamat membaca dan terus kembangkan pengetahuanmu.' }}
            </p>
        </div>
    </div>

</div>
@endsection
```