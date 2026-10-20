```blade
@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')
@section('header_title', 'Ajukan Peminjaman')

@push('styles')
<style>
    .loan-page {
        --green: #72B995;
        --dark-green: #285C45;
        --pink: #F4C5D8;
        --light-pink: #FFF0F5;
        --warm-white: #FFF9FC;
        --border: #E5EDE7;
        --muted: #788B80;
        color: #294337;
        animation: loanPageIn .4s ease;
    }

    .loan-page *,
    .loan-page *::before,
    .loan-page *::after {
        box-sizing: border-box;
    }

    @keyframes loanPageIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .loan-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 26px;
        margin-bottom: 22px;
        border-radius: 20px;
        color: #fff;
        background: linear-gradient(125deg, #285C45, #438363 60%, #72B995);
        box-shadow: 0 10px 28px rgba(40, 92, 69, .13);
    }

    .loan-hero::after {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        right: -55px;
        top: -105px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .10);
        pointer-events: none;
    }

    .loan-hero-content {
        position: relative;
        z-index: 1;
    }

    .loan-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
        padding: 7px 10px;
        border: 1px solid rgba(255,255,255,.24);
        border-radius: 30px;
        background: rgba(255,255,255,.12);
        font-size: 10px;
        font-weight: 700;
    }

    .loan-hero-badge span {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--pink);
    }

    .loan-hero h2 {
        position: relative;
        z-index: 1;
        margin: 0;
        color: #fff;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.3;
    }

    .loan-hero p {
        position: relative;
        z-index: 1;
        max-width: 560px;
        margin: 8px 0 0;
        color: rgba(255,255,255,.87);
        font-size: 11px;
        line-height: 1.8;
    }

    .loan-hero-icon {
        position: relative;
        z-index: 1;
        display: flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 20px;
        background: rgba(255,255,255,.13);
        font-size: 31px;
    }

    .loan-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.8fr) minmax(280px, .95fr);
        gap: 20px;
        align-items: start;
    }

    .loan-card,
    .info-box {
        overflow: hidden;
        border: 1px solid var(--border);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(40, 92, 69, .045);
    }

    .card-head {
        padding: 20px 22px;
        border-bottom: 1px solid #EDF2EE;
        background: #FFFCFD;
    }

    .card-head h3 {
        margin: 0;
        color: var(--dark-green);
        font-size: 15px;
        font-weight: 800;
    }

    .card-head p {
        margin: 5px 0 0;
        color: var(--muted);
        font-size: 11px;
        line-height: 1.6;
    }

    .card-body {
        padding: 22px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: var(--dark-green);
        font-size: 11px;
        font-weight: 700;
    }

    .required {
        color: #B43F6A;
    }

    .form-control {
        display: block;
        width: 100%;
        min-height: 44px;
        padding: 10px 13px;
        border: 1px solid #DCE8DE;
        border-radius: 10px;
        outline: none;
        background: var(--warm-white);
        color: #294337;
        font-family: inherit;
        font-size: 12px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .form-control:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(114,185,149,.18);
    }

    textarea.form-control {
        min-height: 95px;
        resize: vertical;
    }

    .form-help {
        margin-top: 6px;
        color: var(--muted);
        font-size: 10px;
        line-height: 1.6;
    }

    .validation-error {
        margin-top: 6px;
        color: #B43F6A;
        font-size: 10px;
    }

    /* BOOK LIST */

    .book-list {
        max-height: 485px;
        overflow-y: auto;
        padding: 2px 3px 3px;
        scrollbar-width: thin;
        scrollbar-color: var(--green) #F1F6F2;
    }

    .book-item {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 112px;
        margin-bottom: 12px;
        padding: 12px;
        border: 1px solid #E1EAE3;
        border-radius: 12px;
        background: #fff;
        cursor: pointer;
        transition: transform .2s ease, border-color .2s ease,
                    box-shadow .2s ease, background .2s ease;
    }

    .book-item:last-child {
        margin-bottom: 0;
    }

    .book-item:hover {
        transform: translateY(-2px);
        border-color: #A9D4B8;
        box-shadow: 0 7px 20px rgba(40,92,69,.07);
    }

    .book-item.selected {
        border-color: var(--green);
        background: #F2FAF4;
        box-shadow: 0 0 0 2px rgba(114,185,149,.12);
    }

    .book-check {
        width: 17px;
        height: 17px;
        flex: 0 0 17px;
        accent-color: var(--dark-green);
        cursor: pointer;
    }

    .book-cover {
        display: flex;
        flex: 0 0 62px;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 82px;
        overflow: hidden;
        border: 1px solid #E9DDE3;
        border-radius: 7px;
        background: var(--light-pink);
        color: #96516D;
        font-size: 23px;
    }

    .book-cover img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .book-item:hover .book-cover img {
        transform: scale(1.05);
    }

    .book-info {
        flex: 1;
        min-width: 0;
    }

    .book-title {
        margin: 0 0 5px;
        color: var(--dark-green);
        font-size: 12px;
        font-weight: 800;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .book-author {
        margin: 0 0 3px;
        color: #64776B;
        font-size: 10px;
    }

    .book-category {
        margin: 0 0 7px;
        color: #87978D;
        font-size: 10px;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 7px;
        border-radius: 6px;
        background: #EAF6EF;
        color: var(--dark-green);
        font-size: 9px;
        font-weight: 700;
    }

    .stock-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #438363;
    }

    .stock-badge.empty {
        background: var(--light-pink);
        color: #A23E64;
    }

    .stock-badge.empty .stock-dot {
        background: #C04E7B;
    }

    .empty-books {
        padding: 35px 16px;
        border: 1px dashed #DCE8DE;
        border-radius: 12px;
        background: #FFFCFD;
        color: var(--muted);
        font-size: 11px;
        line-height: 1.8;
        text-align: center;
    }

    /* SUMMARY */

    .summary-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .summary-label {
        color: var(--muted);
        font-size: 10px;
    }

    .summary-value {
        color: var(--dark-green);
        font-size: 10px;
        font-weight: 800;
        text-align: right;
    }

    .selected-books {
        min-height: 44px;
        margin-top: 17px;
        padding: 12px;
        border: 1px solid #E7EEE8;
        border-radius: 10px;
        background: #FFFCFD;
    }

    .selected-empty {
        padding: 8px 0;
        color: #87978D;
        font-size: 10px;
        text-align: center;
    }

    .selected-book-row {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 7px 0;
        border-bottom: 1px solid #E7EEE8;
    }

    .selected-book-row:last-child {
        border-bottom: 0;
    }

    .selected-book-mini {
        display: flex;
        flex: 0 0 30px;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 38px;
        overflow: hidden;
        border-radius: 4px;
        background: var(--light-pink);
        color: #96516D;
        font-size: 13px;
    }

    .selected-book-mini img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .selected-book-name {
        flex: 1;
        min-width: 0;
        color: var(--dark-green);
        font-size: 10px;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .submit-btn {
        width: 100%;
        min-height: 43px;
        margin-top: 15px;
        padding: 10px 12px;
        border: 0;
        border-radius: 10px;
        background: var(--dark-green);
        color: #fff;
        font-family: inherit;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 5px 14px rgba(40,92,69,.18);
        transition: background .2s ease, transform .2s ease;
    }

    .submit-btn:hover {
        transform: translateY(-1px);
        background: #347858;
    }

    .cancel-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 40px;
        margin-top: 9px;
        border: 1px solid #DCE8DE;
        border-radius: 10px;
        background: #fff;
        color: #64776B;
        font-size: 10px;
        text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }

    .cancel-btn:hover {
        background: var(--light-pink);
        color: var(--dark-green);
    }

    /* INFO */

    .info-box {
        margin-top: 20px;
        padding: 20px;
    }

    .info-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        margin-bottom: 10px;
        border-radius: 11px;
        background: #EAF6EF;
        color: var(--dark-green);
        font-size: 16px;
    }

    .info-box h4 {
        margin: 0 0 7px;
        color: var(--dark-green);
        font-size: 12px;
        font-weight: 800;
    }

    .info-box p {
        margin: 0;
        color: #64776B;
        font-size: 10px;
        line-height: 1.8;
    }

    /* ERRORS */

    .alert-error {
        margin-bottom: 18px;
        padding: 13px 15px;
        border: 1px solid #F1CADB;
        border-radius: 10px;
        background: var(--light-pink);
        color: #9F365D;
        font-size: 11px;
        line-height: 1.7;
    }

    .alert-error ul {
        padding-left: 18px;
    }

    @media (max-width: 1000px) {
        .loan-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 600px) {
        .loan-hero {
            padding: 20px;
        }

        .loan-hero h2 {
            font-size: 21px;
        }

        .loan-hero-icon {
            width: 52px;
            height: 52px;
            font-size: 24px;
        }

        .card-head,
        .card-body {
            padding: 16px;
        }

        .book-item {
            min-height: 100px;
            gap: 9px;
            padding: 10px;
        }

        .book-cover {
            width: 52px;
            height: 70px;
            flex-basis: 52px;
        }
    }

    @media (max-width: 380px) {
        .loan-hero-icon {
            display: none;
        }

        .book-item {
            gap: 7px;
        }

        .book-cover {
            width: 45px;
            height: 62px;
            flex-basis: 45px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .loan-page *,
        .loan-page *::before,
        .loan-page *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>
@endpush

@section('content')

@php
    /*
     * Mapping gambar opsional.
     * Sesuaikan nama file dengan gambar di folder public/books/.
     */
    $bookImages = [
        'Basis Data' => 'basis-data.jpg',
        'Flutter untuk Pemula' => 'flutter.jpg',
        'Kamus Bahasa Indonesia' => 'kamus-bahasa-indonesia-1.jpg',
        'Laskar Pelangi' => 'laskar-pelangi.jpg',
        'Matematika untuk SMK' => 'matematika-10.jpg',
        'Pemrograman PHP Dasar' => 'pemrograman-php.jpg',
        'Sejarah Indonesia' => 'sejarah-indonesia-10.jpg',
    ];
@endphp

<div class="loan-page">

    {{-- HERO --}}
    <section class="loan-hero">
        <div class="loan-hero-content">
            <div class="loan-hero-badge">
                <span></span>
                Layanan Perpustakaan
            </div>

            <h2>Ajukan Peminjaman</h2>

            <p>
                Pilih buku yang ingin kamu baca, tentukan tanggal peminjaman,
                lalu kirim pengajuan untuk diverifikasi petugas perpustakaan.
            </p>
        </div>

        <div class="loan-hero-icon" aria-hidden="true">📚</div>
    </section>

    @if ($errors->any())
        <div class="alert-error" role="alert">
            <strong>Periksa kembali data yang kamu masukkan.</strong>

            <ul style="margin:7px 0 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="loan-grid">

        {{-- FORM PEMINJAMAN --}}
        <section class="loan-card">
            <div class="card-head">
                <h3>Data Peminjaman</h3>
                <p>Tentukan tanggal dan pilih buku yang ingin dipinjam.</p>
            </div>

            <div class="card-body">
                <form
                    action="{{ route('loans.store') }}"
                    method="POST"
                    id="loanForm"
                >
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="loan_date">
                            Tanggal Peminjaman <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            name="loan_date"
                            id="loan_date"
                            class="form-control"
                            value="{{ old('loan_date', now()->format('Y-m-d')) }}"
                            required
                        >

                        @error('loan_date')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="due_date">
                            Tanggal Pengembalian <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            name="due_date"
                            id="due_date"
                            class="form-control"
                            value="{{ old('due_date') }}"
                            min="{{ old('loan_date', now()->format('Y-m-d')) }}"
                            required
                        >

                        <div class="form-help">
                            Pilih tanggal terakhir untuk mengembalikan buku.
                        </div>

                        @error('due_date')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Pilih Buku <span class="required">*</span>
                        </label>

                        <div class="book-list">
                            @forelse ($books as $book)
                                @php
                                    $imageName = $bookImages[$book->title] ?? null;
                                    $imageUrl = $imageName
                                        ? asset('books/' . $imageName)
                                        : null;

                                    $selectedIds = old('books', []);

                                    if (!is_array($selectedIds)) {
                                        $selectedIds = [];
                                    }

                                    $selectedIds = array_map(
                                        'strval',
                                        $selectedIds
                                    );

                                    $isSelected = (
                                        isset($selectedBookId)
                                        && (int) $selectedBookId === (int) $book->id
                                    ) || in_array(
                                        (string) $book->id,
                                        $selectedIds,
                                        true
                                    );

                                    $availableStock = (int) ($book->available_stock ?? 0);
                                @endphp

                                <label
                                    class="book-item {{ $isSelected ? 'selected' : '' }}"
                                    data-book-item
                                >
                                    <input
                                        type="checkbox"
                                        name="books[]"
                                        value="{{ $book->id }}"
                                        class="book-check book-checkbox"
                                        data-title="{{ $book->title }}"
                                        data-image="{{ $imageUrl ?? '' }}"
                                        {{ $isSelected ? 'checked' : '' }}
                                        {{ $availableStock < 1 ? 'disabled' : '' }}
                                    >

                                    <div class="book-cover">
                                        @if ($imageUrl)
                                            <img
                                                src="{{ $imageUrl }}"
                                                alt="Sampul {{ $book->title }}"
                                                loading="lazy"
                                                onerror="this.style.display='none';this.parentElement.textContent='📖';"
                                            >
                                        @else
                                            📖
                                        @endif
                                    </div>

                                    <div class="book-info">
                                        <h4 class="book-title">
                                            {{ $book->title }}
                                        </h4>

                                        <p class="book-author">
                                            {{ $book->author ?? 'Penulis tidak tersedia' }}
                                        </p>

                                        <p class="book-category">
                                            {{ $book->category->name ?? 'Tanpa kategori' }}
                                        </p>

                                        @if ($availableStock > 0)
                                            <span class="stock-badge">
                                                <span class="stock-dot"></span>
                                                {{ $availableStock }} tersedia
                                            </span>
                                        @else
                                            <span class="stock-badge empty">
                                                <span class="stock-dot"></span>
                                                Tidak tersedia
                                            </span>
                                        @endif
                                    </div>
                                </label>
                            @empty
                                <div class="empty-books">
                                    📚<br>
                                    Belum ada buku yang tersedia untuk dipinjam.
                                </div>
                            @endforelse
                        </div>

                        @error('books')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror

                        @error('books.*')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="notes">
                            Catatan <span style="font-weight:400;">(opsional)</span>
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            class="form-control"
                            placeholder="Tambahkan catatan jika diperlukan..."
                        >{{ old('notes') }}</textarea>

                        @error('notes')
                            <div class="validation-error">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
        </section>

        {{-- RINGKASAN --}}
        <aside>
            <section class="loan-card">
                <div class="card-head">
                    <h3>Ringkasan Pengajuan</h3>
                    <p>Periksa kembali sebelum mengirim.</p>
                </div>

                <div class="card-body">
                    <div class="summary-list">
                        <div class="summary-row">
                            <span class="summary-label">Jumlah Buku</span>
                            <span class="summary-value" id="summaryCount">0 buku</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Tanggal Pinjam</span>
                            <span class="summary-value" id="summaryLoanDate">-</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Jatuh Tempo</span>
                            <span class="summary-value" id="summaryDueDate">-</span>
                        </div>
                    </div>

                    <div class="selected-books" id="selectedBooks" aria-live="polite">
                        <div class="selected-empty">
                            Belum ada buku yang dipilih.
                        </div>
                    </div>

                    <button
                        type="submit"
                        form="loanForm"
                        class="submit-btn"
                    >
                        📚 Ajukan Peminjaman
                    </button>

                    <a
                        href="{{ route('dashboard') }}"
                        class="cancel-btn"
                    >
                        Batal
                    </a>
                </div>
            </section>

            <section class="info-box">
                <div class="info-icon" aria-hidden="true">ⓘ</div>

                <h4>Informasi Peminjaman</h4>

                <p>
                    Setelah pengajuan dikirim, petugas perpustakaan akan
                    memeriksa permintaanmu. Pantau status pengajuan secara
                    berkala melalui halaman Peminjaman Saya.
                </p>
            </section>
        </aside>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loanForm');
    const checkboxes = document.querySelectorAll('.book-checkbox');
    const bookItems = document.querySelectorAll('[data-book-item]');

    const summaryCount = document.getElementById('summaryCount');
    const summaryLoanDate = document.getElementById('summaryLoanDate');
    const summaryDueDate = document.getElementById('summaryDueDate');
    const selectedBooks = document.getElementById('selectedBooks');

    const loanDate = document.getElementById('loan_date');
    const dueDate = document.getElementById('due_date');

    function formatDate(value) {
        if (!value) {
            return '-';
        }

        const parts = value.split('-');

        if (parts.length !== 3) {
            return '-';
        }

        const date = new Date(
            Number(parts[0]),
            Number(parts[1]) - 1,
            Number(parts[2])
        );

        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function updateSummary() {
        const selected = document.querySelectorAll(
            '.book-checkbox:checked:not(:disabled)'
        );

        summaryCount.textContent = selected.length + ' buku';
        summaryLoanDate.textContent = formatDate(loanDate.value);
        summaryDueDate.textContent = formatDate(dueDate.value);

        selectedBooks.replaceChildren();

        if (selected.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'selected-empty';
            empty.textContent = 'Belum ada buku yang dipilih.';
            selectedBooks.appendChild(empty);
            return;
        }

        selected.forEach(function (checkbox) {
            const row = document.createElement('div');
            row.className = 'selected-book-row';

            const cover = document.createElement('div');
            cover.className = 'selected-book-mini';

            const imageUrl = checkbox.dataset.image || '';
            const title = checkbox.dataset.title || 'Buku';

            if (imageUrl) {
                const image = document.createElement('img');
                image.src = imageUrl;
                image.alt = 'Sampul ' + title;
                image.loading = 'lazy';

                image.addEventListener('error', function () {
                    cover.replaceChildren();
                    cover.textContent = '📖';
                }, { once: true });

                cover.appendChild(image);
            } else {
                cover.textContent = '📖';
            }

            const name = document.createElement('div');
            name.className = 'selected-book-name';
            name.textContent = title;

            row.appendChild(cover);
            row.appendChild(name);
            selectedBooks.appendChild(row);
        });
    }

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const item = checkbox.closest('[data-book-item]');

            if (item) {
                item.classList.toggle(
                    'selected',
                    checkbox.checked
                );
            }

            updateSummary();
        });
    });

    bookItems.forEach(function (item) {
        item.addEventListener('click', function (event) {
            if (
                event.target.closest('input') ||
                event.target.closest('a') ||
                event.target.closest('button')
            ) {
                return;
            }

            const checkbox = item.querySelector('.book-checkbox');

            if (!checkbox || checkbox.disabled) {
                return;
            }

            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });

    function updateDueDateMinimum() {
        if (!loanDate.value) {
            dueDate.removeAttribute('min');
            return;
        }

        dueDate.min = loanDate.value;

        if (dueDate.value && dueDate.value < loanDate.value) {
            dueDate.value = '';
        }
    }

    loanDate.addEventListener('change', function () {
        updateDueDateMinimum();
        updateSummary();
    });

    dueDate.addEventListener('change', updateSummary);

    form.addEventListener('submit', function (event) {
        const selected = document.querySelectorAll(
            '.book-checkbox:checked:not(:disabled)'
        );

        if (selected.length === 0) {
            event.preventDefault();
            alert('Pilih minimal satu buku yang tersedia.');
            return;
        }

        if (
            loanDate.value &&
            dueDate.value &&
            dueDate.value < loanDate.value
        ) {
            event.preventDefault();
            alert('Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.');
            dueDate.focus();
        }
    });

    updateDueDateMinimum();
    updateSummary();
});
</script>
@endpush
```