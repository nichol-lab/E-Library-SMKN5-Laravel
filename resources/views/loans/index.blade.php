
@extends('layouts.app')

@section('title', 'Kelola Peminjaman')
@section('header', 'Kelola Peminjaman Buku')

@section('content')
@php
    $totalLoans = $loans->count();
    $pendingLoans = $loans->where('status', 'pending')->count();
    $approvedLoans = $loans->where('status', 'approved')->count();
    $borrowedLoans = $loans->where('status', 'borrowed')->count();
    $returnedLoans = $loans->where('status', 'returned')->count();
    $rejectedLoans = $loans->where('status', 'rejected')->count();
@endphp

<div class="loan-page">

    {{-- HEADER --}}
    <section class="loan-hero">
        <div class="hero-content">
            <div class="hero-label">
                <span class="hero-dot"></span>
                PANEL PETUGAS PERPUSTAKAAN
            </div>

            <h1>Kelola Peminjaman Buku</h1>

            <p>
                Kelola pengajuan, persetujuan, penyerahan, dan pengembalian
                buku perpustakaan dengan mudah.
            </p>
        </div>

        <div class="hero-decoration" aria-hidden="true">
            <div class="hero-book">
                <span>📚</span>
            </div>
            <div class="decoration-circle circle-one"></div>
            <div class="decoration-circle circle-two"></div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="loan-stats">
        <article class="stat-card stat-total">
            <div class="stat-top">
                <div class="stat-icon">📋</div>
                <span class="stat-caption">Semua data</span>
            </div>
            <div class="stat-number">{{ $totalLoans }}</div>
            <div class="stat-title">Total Peminjaman</div>
        </article>

        <article class="stat-card stat-pending">
            <div class="stat-top">
                <div class="stat-icon">⏳</div>
                <span class="stat-caption">Perlu diperiksa</span>
            </div>
            <div class="stat-number">{{ $pendingLoans }}</div>
            <div class="stat-title">Menunggu Persetujuan</div>
        </article>

        <article class="stat-card stat-approved">
            <div class="stat-top">
                <div class="stat-icon">✓</div>
                <span class="stat-caption">Siap diproses</span>
            </div>
            <div class="stat-number">{{ $approvedLoans }}</div>
            <div class="stat-title">Disetujui</div>
        </article>

        <article class="stat-card stat-borrowed">
            <div class="stat-top">
                <div class="stat-icon">📖</div>
                <span class="stat-caption">Belum kembali</span>
            </div>
            <div class="stat-number">{{ $borrowedLoans }}</div>
            <div class="stat-title">Sedang Dipinjam</div>
        </article>
    </section>

    {{-- RINGKASAN STATUS --}}
    <section class="status-summary">
        <div class="summary-heading">
            <span class="summary-icon">📊</span>
            <div>
                <h2>Ringkasan Status</h2>
                <p>Ringkasan seluruh transaksi peminjaman.</p>
            </div>
        </div>

        <div class="summary-items">
            <div class="summary-item">
                <span class="summary-dot dot-pending"></span>
                <span>Menunggu</span>
                <strong>{{ $pendingLoans }}</strong>
            </div>

            <div class="summary-item">
                <span class="summary-dot dot-approved"></span>
                <span>Disetujui</span>
                <strong>{{ $approvedLoans }}</strong>
            </div>

            <div class="summary-item">
                <span class="summary-dot dot-borrowed"></span>
                <span>Dipinjam</span>
                <strong>{{ $borrowedLoans }}</strong>
            </div>

            <div class="summary-item">
                <span class="summary-dot dot-returned"></span>
                <span>Dikembalikan</span>
                <strong>{{ $returnedLoans }}</strong>
            </div>

            <div class="summary-item">
                <span class="summary-dot dot-rejected"></span>
                <span>Ditolak</span>
                <strong>{{ $rejectedLoans }}</strong>
            </div>
        </div>
    </section>

    {{-- TABEL PEMINJAMAN --}}
    <section class="loan-card">
        <div class="loan-card-header">
            <div>
                <div class="section-eyebrow">DATA TRANSAKSI</div>
                <h2>Daftar Peminjaman</h2>
                <p>Periksa informasi dan proses setiap pengajuan.</p>
            </div>

            <div class="record-count">
                <span class="record-count-dot"></span>
                <span id="visibleCount">{{ $totalLoans }}</span> data
            </div>
        </div>

        {{-- PENCARIAN DAN FILTER --}}
        <div class="loan-toolbar">
            <div class="search-box">
                <span class="search-icon">⌕</span>
                <input
                    type="search"
                    id="searchLoan"
                    placeholder="Cari kode, nama siswa, atau judul buku..."
                    autocomplete="off"
                    aria-label="Cari data peminjaman"
                >
                <button
                    type="button"
                    id="clearSearch"
                    class="clear-search"
                    aria-label="Hapus pencarian"
                    hidden
                >×</button>
            </div>

            <div class="filter-box">
                <label for="filterStatus">Status:</label>
                <select id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                    <option value="borrowed">Dipinjam</option>
                    <option value="returned">Dikembalikan</option>
                </select>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="table-scroll">
            <table class="loan-table">
                <thead>
                    <tr>
                        <th class="column-number">No.</th>
                        <th>Kode &amp; Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tenggat Kembali</th>
                        <th>Status</th>
                        <th class="column-action">Aksi</th>
                    </tr>
                </thead>

                <tbody id="loanTableBody">
                    @forelse ($loans as $loan)
                        @php
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'borrowed' => 'Dipinjam',
                                'returned' => 'Dikembalikan',
                            ];

                            $statusLabel = $statusLabels[$loan->status] ?? ucfirst($loan->status);

                            $studentName = $loan->user->name
                                ?? $loan->user->username
                                ?? 'Pengguna';

                            $studentClass = $loan->user->kelas
                                ?? $loan->user->username
                                ?? '-';

                            $bookTitles = $loan->loanDetails
                                ->map(function ($detail) {
                                    $title = $detail->book->title ?? 'Buku tidak tersedia';
                                    $quantity = $detail->quantity ?? 1;

                                    return $title . ' × ' . $quantity;
                                })
                                ->implode(', ');
                        @endphp

                        <tr
                            class="loan-row"
                            data-status="{{ $loan->status }}"
                            data-search="{{ strtolower(
                                ($loan->loan_code ?? '') . ' ' .
                                $studentName . ' ' .
                                $studentClass . ' ' .
                                $bookTitles
                            ) }}"
                        >
                            <td class="number-cell">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="borrower-info">
                                    <div class="borrower-avatar">
                                        {{ strtoupper(substr($studentName, 0, 1)) }}
                                    </div>

                                    <div class="borrower-detail">
                                        <span class="loan-code">
                                            {{ $loan->loan_code }}
                                        </span>
                                        <strong>{{ $studentName }}</strong>
                                        <small>{{ $studentClass }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="book-info">
                                    <span class="book-icon">📚</span>
                                    <div>
                                        <span class="book-title">
                                            {{ $bookTitles ?: 'Tidak ada detail buku' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="date-info">
                                    <span class="date-icon">🗓</span>
                                    <span>
                                        {{ $loan->loan_date
                                            ? \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y')
                                            : '-' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <div class="date-info">
                                    <span class="date-icon">📅</span>
                                    <span>
                                        {{ $loan->due_date
                                            ? \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y')
                                            : '-' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <span class="status-badge status-{{ $loan->status }}">
                                    <span class="status-dot"></span>
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">

                                    @if ($loan->status === 'pending')
                                        <form
                                            action="{{ route('loans.approve', $loan->id) }}"
                                            method="POST"
                                            class="action-form"
                                            onsubmit="return confirm('Setujui pengajuan peminjaman ini?')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn btn-approve">
                                                <span>✓</span> Setujui
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('loans.reject', $loan->id) }}"
                                            method="POST"
                                            class="action-form"
                                            onsubmit="return confirm('Tolak pengajuan peminjaman ini?')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn btn-reject">
                                                <span>×</span> Tolak
                                            </button>
                                        </form>

                                    @elseif ($loan->status === 'approved')
                                        <form
                                            action="{{ route('loans.handover', $loan->id) }}"
                                            method="POST"
                                            class="action-form"
                                            onsubmit="return confirm('Konfirmasi bahwa buku telah diserahkan kepada siswa?')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn btn-handover">
                                                <span>↗</span> Serahkan
                                            </button>
                                        </form>

                                    @elseif ($loan->status === 'borrowed')
                                        <form
                                            action="{{ route('loans.return', $loan->id) }}"
                                            method="POST"
                                            class="action-form"
                                            onsubmit="return confirm('Konfirmasi bahwa buku telah dikembalikan?')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn btn-return">
                                                <span>↩</span> Kembalikan
                                            </button>
                                        </form>

                                    @elseif ($loan->status === 'returned')
                                        <span class="action-finished">
                                            <span>✓</span> Selesai
                                        </span>

                                    @elseif ($loan->status === 'rejected')
                                        <span class="action-rejected">
                                            <span>×</span> Ditolak
                                        </span>

                                    @else
                                        <span class="action-unknown">Tidak ada aksi</span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyDataRow">
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">📚</div>
                                    <h3>Belum Ada Peminjaman</h3>
                                    <p>Data pengajuan peminjaman akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    @if ($loans->isNotEmpty())
                        <tr id="noSearchResult" hidden>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">🔎</div>
                                    <h3>Data Tidak Ditemukan</h3>
                                    <p>Coba gunakan kata kunci atau status yang berbeda.</p>
                                    <button type="button" id="resetFilter" class="reset-filter">
                                        Reset Pencarian
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span>
                Menampilkan <strong id="footerVisibleCount">{{ $totalLoans }}</strong>
                dari <strong>{{ $totalLoans }}</strong> data peminjaman
            </span>

            <span class="footer-note">
                <span class="footer-heart">♥</span>
                E-Library SMK Negeri 5 Surakarta
            </span>
        </div>
    </section>

    {{-- PANDUAN --}}
    <section class="workflow-card">
        <div class="workflow-heading">
            <div class="workflow-icon">💡</div>
            <div>
                <h2>Alur Peminjaman Buku</h2>
                <p>Ikuti tahapan berikut untuk memproses transaksi.</p>
            </div>
        </div>

        <div class="workflow-steps">
            <div class="workflow-step">
                <div class="step-number">01</div>
                <div class="step-content">
                    <h3>Periksa Pengajuan</h3>
                    <p>Periksa data siswa dan buku yang diajukan.</p>
                </div>
            </div>

            <div class="workflow-step">
                <div class="step-number">02</div>
                <div class="step-content">
                    <h3>Setujui Pengajuan</h3>
                    <p>Setujui atau tolak permohonan peminjaman.</p>
                </div>
            </div>

            <div class="workflow-step">
                <div class="step-number">03</div>
                <div class="step-content">
                    <h3>Serahkan Buku</h3>
                    <p>Konfirmasi penyerahan setelah buku diterima siswa.</p>
                </div>
            </div>

            <div class="workflow-step">
                <div class="step-number">04</div>
                <div class="step-content">
                    <h3>Proses Pengembalian</h3>
                    <p>Konfirmasi pengembalian sesuai kondisi transaksi.</p>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('styles')
<style>
    :root {
        --loan-green: #72B995;
        --loan-green-dark: #285C45;
        --loan-green-light: #EAF6EF;
        --loan-pink: #F4C5D8;
        --loan-pink-light: #FFF0F5;
        --loan-white: #FFF9FC;
        --loan-border: #E5EDE7;
        --loan-text: #263B31;
        --loan-muted: #829087;
    }

    .loan-page {
        color: var(--loan-text);
        padding-bottom: 28px;
    }

    .loan-page *,
    .loan-page *::before,
    .loan-page *::after {
        box-sizing: border-box;
    }

    .loan-hero {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 220px;
        padding: 36px 42px;
        margin-bottom: 26px;
        overflow: hidden;
        color: white;
        background: linear-gradient(115deg, #285C45 0%, #397C5B 58%, #72B995 100%);
        border-radius: 25px;
        box-shadow: 0 12px 30px rgba(40, 92, 69, .12);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 650px;
    }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 8px 12px;
        margin-bottom: 18px;
        color: #F5FFF8;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.2px;
    }

    .hero-dot {
        width: 7px;
        height: 7px;
        background: var(--loan-pink);
        border-radius: 50%;
    }

    .loan-hero h1 {
        margin: 0 0 12px;
        color: #FFFFFF;
        font-size: clamp(25px, 3vw, 36px);
        line-height: 1.2;
        font-weight: 850;
        letter-spacing: -.8px;
    }

    .loan-hero p {
        max-width: 580px;
        margin: 0;
        color: rgba(255,255,255,.86);
        font-size: 14px;
        line-height: 1.8;
    }

    .hero-decoration {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 190px;
        height: 150px;
        flex-shrink: 0;
    }

    .hero-book {
        position: relative;
        z-index: 2;
        display: grid;
        place-items: center;
        width: 105px;
        height: 105px;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 28px;
        transform: rotate(-8deg);
        backdrop-filter: blur(4px);
    }

    .hero-book span {
        font-size: 53px;
        transform: rotate(8deg);
    }

    .decoration-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(244,197,216,.24);
    }

    .circle-one {
        top: 2px;
        right: 5px;
        width: 55px;
        height: 55px;
    }

    .circle-two {
        bottom: 0;
        left: 5px;
        width: 35px;
        height: 35px;
        background: rgba(255,255,255,.17);
    }

    .loan-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .stat-card {
        min-width: 0;
        padding: 22px;
        background: #FFFFFF;
        border: 1px solid var(--loan-border);
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(40,92,69,.035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(40,92,69,.08);
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 19px;
    }

    .stat-icon {
        display: grid;
        place-items: center;
        width: 45px;
        height: 45px;
        flex-shrink: 0;
        background: var(--loan-green-light);
        border-radius: 15px;
        font-size: 21px;
    }

    .stat-pending .stat-icon {
        background: var(--loan-pink-light);
    }

    .stat-approved .stat-icon {
        color: var(--loan-green-dark);
        background: #DDF3E4;
        font-size: 24px;
        font-weight: 900;
    }

    .stat-borrowed .stat-icon {
        background: #F7F0E2;
    }

    .stat-caption {
        color: var(--loan-muted);
        font-size: 10px;
        font-weight: 650;
        text-align: right;
    }

    .stat-number {
        margin-bottom: 5px;
        color: var(--loan-green-dark);
        font-size: 34px;
        line-height: 1.1;
        font-weight: 850;
        letter-spacing: -1px;
    }

    .stat-pending .stat-number {
        color: #C16A91;
    }

    .stat-title {
        color: #53645A;
        font-size: 12px;
        font-weight: 750;
        line-height: 1.5;
    }

    .status-summary {
        padding: 23px 25px;
        margin-bottom: 25px;
        background: linear-gradient(120deg, #FFFFFF 0%, #FFF9FC 100%);
        border: 1px solid #F0E5EB;
        border-radius: 20px;
    }

    .summary-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 21px;
    }

    .summary-icon {
        display: grid;
        place-items: center;
        width: 43px;
        height: 43px;
        background: var(--loan-pink-light);
        border-radius: 14px;
        font-size: 21px;
    }

    .summary-heading h2,
    .loan-card-header h2,
    .workflow-heading h2 {
        margin: 0 0 5px;
        color: var(--loan-green-dark);
        font-size: 17px;
        font-weight: 850;
    }

    .summary-heading p,
    .loan-card-header p,
    .workflow-heading p {
        margin: 0;
        color: var(--loan-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .summary-items {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 12px;
    }

    .summary-item {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
        padding: 13px 12px;
        background: #FFFFFF;
        border: 1px solid #F0E8EC;
        border-radius: 13px;
    }

    .summary-item > span:nth-child(2) {
        overflow: hidden;
        color: #647168;
        font-size: 11px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .summary-item strong {
        margin-left: auto;
        color: var(--loan-green-dark);
        font-size: 14px;
        font-weight: 850;
    }

    .summary-dot,
    .status-dot {
        width: 8px;
        height: 8px;
        flex-shrink: 0;
        border-radius: 50%;
    }

    .dot-pending { background: #D89A37; }
    .dot-approved { background: #4B9C6D; }
    .dot-borrowed { background: #6488D8; }
    .dot-returned { background: #72B995; }
    .dot-rejected { background: #D97B9E; }

    .loan-card {
        overflow: hidden;
        margin-bottom: 25px;
        background: #FFFFFF;
        border: 1px solid var(--loan-border);
        border-radius: 22px;
        box-shadow: 0 6px 25px rgba(40,92,69,.04);
    }

    .loan-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 26px 27px 23px;
        border-bottom: 1px solid #EEF2EF;
    }

    .section-eyebrow {
        margin-bottom: 8px;
        color: #C16A91;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: 1.5px;
    }

    .loan-card-header h2 {
        margin-bottom: 7px;
        font-size: 21px;
    }

    .record-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        flex-shrink: 0;
        padding: 10px 13px;
        color: var(--loan-green-dark);
        background: var(--loan-green-light);
        border-radius: 12px;
        font-size: 12px;
        font-weight: 750;
    }

    .record-count-dot {
        width: 7px;
        height: 7px;
        background: var(--loan-green);
        border-radius: 50%;
    }

    .loan-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 27px;
        background: #FCFEFC;
        border-bottom: 1px solid #EEF2EF;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        width: min(100%, 510px);
        min-width: 0;
        padding: 0 13px;
        background: #FFFFFF;
        border: 1px solid #DDE8E0;
        border-radius: 12px;
        transition: border-color .2s, box-shadow .2s;
    }

    .search-box:focus-within {
        border-color: var(--loan-green);
        box-shadow: 0 0 0 3px rgba(114,185,149,.14);
    }

    .search-icon {
        color: var(--loan-green-dark);
        font-size: 25px;
        line-height: 1;
    }

    .search-box input {
        width: 100%;
        min-width: 0;
        height: 44px;
        padding: 0;
        color: var(--loan-text);
        background: transparent;
        border: none;
        outline: none;
        font: inherit;
        font-size: 12px;
    }

    .search-box input::placeholder {
        color: #9BA69E;
    }

    .clear-search {
        width: 27px;
        height: 27px;
        flex-shrink: 0;
        color: #8D6877;
        background: var(--loan-pink-light);
        border: 0;
        border-radius: 8px;
        cursor: pointer;
        font-size: 19px;
    }

    .filter-box {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-shrink: 0;
    }

    .filter-box label {
        color: #6D7C72;
        font-size: 12px;
        font-weight: 700;
    }

    .filter-box select {
        max-width: 180px;
        height: 44px;
        padding: 0 34px 0 12px;
        color: var(--loan-green-dark);
        background: #FFFFFF;
        border: 1px solid #DDE8E0;
        border-radius: 12px;
        outline: none;
        font: inherit;
        font-size: 12px;
        cursor: pointer;
    }

    .filter-box select:focus {
        border-color: var(--loan-green);
    }

    .table-scroll {
        width: 100%;
        overflow-x: auto;
        scrollbar-color: #C9E4D3 #F5F8F5;
        scrollbar-width: thin;
    }

    .loan-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: separate;
        border-spacing: 0;
        text-align: left;
    }

    .loan-table thead th {
        padding: 15px 15px;
        color: #6D7D72;
        background: #F7FAF7;
        border-bottom: 1px solid #E8EFE9;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: .55px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .loan-table thead th:first-child,
    .loan-table tbody td:first-child {
        padding-left: 27px;
    }

    .loan-table tbody td {
        padding: 18px 15px;
        color: #536258;
        border-bottom: 1px solid #EDF2EE;
        font-size: 12px;
        vertical-align: middle;
    }

    .loan-table tbody tr:last-child td {
        border-bottom: none;
    }

    .loan-table tbody tr.loan-row {
        transition: background .15s ease;
    }

    .loan-table tbody tr.loan-row:hover {
        background: #FBFEFB;
    }

    .column-number {
        width: 55px;
    }

    .column-action {
        width: 150px;
    }

    .number-cell {
        color: #9BA69E !important;
        font-size: 11px !important;
        font-weight: 750;
    }

    .borrower-info {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 190px;
    }

    .borrower-avatar {
        display: grid;
        place-items: center;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        color: var(--loan-green-dark);
        background: var(--loan-green-light);
        border: 1px solid #D9EDE0;
        border-radius: 13px;
        font-size: 15px;
        font-weight: 850;
    }

    .loan-row:nth-child(even) .borrower-avatar {
        color: #A75378;
        background: var(--loan-pink-light);
        border-color: #F4DFE8;
    }

    .borrower-detail {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .loan-code {
        color: #A45D7A;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .2px;
    }

    .borrower-detail strong {
        color: #344B3C;
        font-size: 12px;
        font-weight: 800;
    }

    .borrower-detail small {
        color: #98A39A;
        font-size: 10px;
    }

    .book-info {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        min-width: 160px;
        max-width: 230px;
    }

    .book-icon {
        display: grid;
        place-items: center;
        width: 31px;
        height: 31px;
        flex-shrink: 0;
        background: #F2F7F2;
        border-radius: 9px;
        font-size: 15px;
    }

    .book-title {
        display: block;
        padding-top: 3px;
        color: #405649;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .date-info {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .date-icon {
        font-size: 13px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 10px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-pending {
        color: #9A6A18;
        background: #FFF6E5;
        border-color: #F6E7C7;
    }

    .status-pending .status-dot { background: #D89A37; }

    .status-approved {
        color: #31734B;
        background: #EAF7ED;
        border-color: #D8EDDE;
    }

    .status-approved .status-dot { background: #4B9C6D; }

    .status-borrowed {
        color: #4868AD;
        background: #EEF2FF;
        border-color: #DCE4FF;
    }

    .status-borrowed .status-dot { background: #6488D8; }

    .status-returned {
        color: #31734B;
        background: #EAF7ED;
        border-color: #D8EDDE;
    }

    .status-returned .status-dot { background: #72B995; }

    .status-rejected {
        color: #A94D70;
        background: var(--loan-pink-light);
        border-color: #F5DCE7;
    }

    .status-rejected .status-dot { background: #D97B9E; }

    .action-buttons {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 7px;
        min-width: 105px;
    }

    .action-form {
        margin: 0;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        min-height: 34px;
        padding: 8px 10px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-family: inherit;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
        transition: transform .15s, background .15s;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .btn-approve,
    .btn-handover,
    .btn-return {
        color: #FFFFFF;
        background: var(--loan-green-dark);
    }

    .btn-approve:hover,
    .btn-handover:hover,
    .btn-return:hover {
        background: #397C5B;
    }

    .btn-reject {
        color: #A94D70;
        background: var(--loan-pink-light);
        border-color: #F3D9E4;
    }

    .btn-reject:hover {
        background: #F9DFE9;
    }

    .action-finished,
    .action-rejected,
    .action-unknown {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 7px;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .action-finished {
        color: #31734B;
        background: #EAF7ED;
    }

    .action-rejected {
        color: #A94D70;
        background: var(--loan-pink-light);
    }

    .action-unknown {
        color: #718076;
        background: #F3F6F3;
    }

    .empty-state {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        min-height: 245px;
        padding: 35px 20px;
        text-align: center;
    }

    .empty-icon {
        display: grid;
        place-items: center;
        width: 68px;
        height: 68px;
        margin-bottom: 17px;
        background: var(--loan-pink-light);
        border-radius: 23px;
        font-size: 30px;
    }

    .empty-state h3 {
        margin: 0 0 8px;
        color: var(--loan-green-dark);
        font-size: 16px;
        font-weight: 850;
    }

    .empty-state p {
        margin: 0;
        color: var(--loan-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    .reset-filter {
        margin-top: 17px;
        padding: 10px 15px;
        color: #FFFFFF;
        background: var(--loan-green-dark);
        border: none;
        border-radius: 10px;
        font: inherit;
        font-size: 11px;
        font-weight: 750;
        cursor: pointer;
    }

    .table-footer {
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

    .table-footer strong {
        color: var(--loan-green-dark);
    }

    .footer-note {
        color: #74877A;
        font-weight: 650;
    }

    .footer-heart {
        color: #D985A6;
    }

    .workflow-card {
        padding: 25px 27px;
        background: linear-gradient(120deg, #FFFFFF, #FFF9FC);
        border: 1px solid #EFE4EA;
        border-radius: 22px;
    }

    .workflow-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 24px;
    }

    .workflow-icon {
        display: grid;
        place-items: center;
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        background: #FFF0F5;
        border-radius: 14px;
        font-size: 21px;
    }

    .workflow-steps {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 13px;
    }

    .workflow-step {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 17px 14px;
        background: #FFFFFF;
        border: 1px solid #EBF0EC;
        border-radius: 15px;
    }

    .step-number {
        display: grid;
        place-items: center;
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        color: var(--loan-green-dark);
        background: var(--loan-green-light);
        border-radius: 11px;
        font-size: 11px;
        font-weight: 900;
    }

    .workflow-step:nth-child(even) .step-number {
        color: #A75378;
        background: var(--loan-pink-light);
    }

    .step-content h3 {
        margin: 1px 0 7px;
        color: #3B5445;
        font-size: 11px;
        font-weight: 850;
    }

    .step-content p {
        margin: 0;
        color: #87948A;
        font-size: 10px;
        line-height: 1.8;
    }

    [hidden] {
        display: none !important;
    }

    @media (max-width: 1200px) {
        .loan-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .summary-items {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .workflow-steps {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .loan-hero {
            min-height: auto;
            padding: 28px 24px;
            border-radius: 20px;
        }

        .hero-decoration {
            width: 90px;
            height: 100px;
        }

        .hero-book {
            width: 70px;
            height: 70px;
            border-radius: 20px;
        }

        .hero-book span {
            font-size: 36px;
        }

        .circle-one {
            width: 35px;
            height: 35px;
        }

        .circle-two {
            width: 23px;
            height: 23px;
        }

        .loan-hero h1 {
            font-size: 25px;
        }

        .loan-hero p {
            font-size: 12px;
        }

        .stat-card {
            padding: 18px;
        }

        .status-summary,
        .workflow-card {
            padding: 20px;
        }

        .summary-items {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .loan-card-header {
            align-items: flex-start;
            padding: 22px 20px;
        }

        .loan-toolbar {
            align-items: stretch;
            flex-direction: column;
            padding: 17px 20px;
        }

        .search-box {
            width: 100%;
        }

        .filter-box {
            justify-content: space-between;
        }

        .filter-box select {
            flex: 1;
            max-width: none;
        }

        .table-footer {
            align-items: flex-start;
            flex-direction: column;
            padding: 16px 20px;
        }
    }

    @media (max-width: 480px) {
        .loan-stats {
            gap: 10px;
        }

        .stat-card {
            padding: 14px;
            border-radius: 16px;
        }

        .stat-top {
            align-items: flex-start;
            flex-direction: column;
            gap: 9px;
            margin-bottom: 13px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
        }

        .stat-caption {
            text-align: left;
            font-size: 9px;
        }

        .stat-number {
            font-size: 29px;
        }

        .stat-title {
            font-size: 10px;
        }

        .hero-decoration {
            display: none;
        }

        .loan-hero {
            padding: 26px 22px;
        }

        .hero-label {
            font-size: 9px;
        }

        .summary-items {
            grid-template-columns: 1fr;
        }

        .summary-item {
            padding: 12px;
        }

        .loan-card-header {
            flex-direction: column;
            gap: 14px;
        }

        .workflow-steps {
            grid-template-columns: 1fr;
        }

        .workflow-card {
            padding: 18px;
        }

        .workflow-step {
            padding: 14px;
        }

        .footer-note {
            font-size: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchLoan');
    const filterStatus = document.getElementById('filterStatus');
    const clearButton = document.getElementById('clearSearch');
    const resetButton = document.getElementById('resetFilter');
    const noResultRow = document.getElementById('noSearchResult');
    const visibleCount = document.getElementById('visibleCount');
    const footerVisibleCount = document.getElementById('footerVisibleCount');

    const rows = Array.from(document.querySelectorAll('.loan-row'));
    const totalRows = rows.length;

    function filterLoans() {
        const keyword = (searchInput.value || '').trim().toLocaleLowerCase('id-ID');
        const selectedStatus = filterStatus.value;

        let visible = 0;

        rows.forEach(function (row) {
            const searchableText = (row.dataset.search || '').toLocaleLowerCase('id-ID');
            const rowStatus = row.dataset.status || '';

            const matchesKeyword = searchableText.includes(keyword);
            const matchesStatus = selectedStatus === '' || rowStatus === selectedStatus;
            const shouldShow = matchesKeyword && matchesStatus;

            row.hidden = !shouldShow;

            if (shouldShow) {
                visible++;
            }
        });

        if (noResultRow) {
            noResultRow.hidden = visible !== 0;
        }

        if (visibleCount) {
            visibleCount.textContent = visible;
        }

        if (footerVisibleCount) {
            footerVisibleCount.textContent = visible;
        }

        if (clearButton) {
            clearButton.hidden = searchInput.value.length === 0;
        }
    }

    searchInput.addEventListener('input', filterLoans);
    filterStatus.addEventListener('change', filterLoans);

    clearButton.addEventListener('click', function () {
        searchInput.value = '';
        searchInput.focus();
        filterLoans();
    });

    if (resetButton) {
        resetButton.addEventListener('click', function () {
            searchInput.value = '';
            filterStatus.value = '';
            filterLoans();
        });
    }

    filterLoans();
});
</script>
@endpush
