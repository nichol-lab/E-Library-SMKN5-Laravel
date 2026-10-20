@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('page_title', 'Detail Pengguna')

@section('content')

<div class="page-header">

    <div>
        <div class="page-eyebrow">USER MANAGEMENT</div>

        <h1 class="page-title">
            Detail Pengguna
        </h1>

        <p class="page-subtitle">
            Informasi lengkap pengguna E-Library SMKN 5 Surakarta.
        </p>
    </div>

    <div class="page-header-actions">

        <a
            href="{{ route('users.index') }}"
            class="btn btn-secondary"
        >
            ← Kembali
        </a>

        <a
            href="{{ route('users.edit', $user->id) }}"
            class="btn btn-primary"
        >
            ✎ Edit Pengguna
        </a>

    </div>

</div>


{{-- ALERT SUCCESS --}}
@if(session('success'))

    <div class="alert alert-success">

        <div class="alert-icon">
            ✓
        </div>

        <div>
            <strong>Berhasil!</strong>
            <span>{{ session('success') }}</span>
        </div>

    </div>

@endif


{{-- ALERT ERROR --}}
@if(session('error'))

    <div class="alert alert-danger">

        <div class="alert-icon">
            !
        </div>

        <div>
            <strong>Gagal!</strong>
            <span>{{ session('error') }}</span>
        </div>

    </div>

@endif


<div class="user-detail-layout">


    {{-- PROFILE --}}
    <div class="card profile-card">

        <div class="profile-cover">
            <div class="profile-circle"></div>
        </div>


        <div class="profile-body">

            <div class="avatar">

                {{ strtoupper(
                    substr($user->name, 0, 1)
                ) }}

            </div>


            <h2>
                {{ $user->name }}
            </h2>


            @if($user->role === 'admin')

                <span class="role-badge role-admin">
                    Administrator
                </span>

            @elseif($user->role === 'petugas')

                <span class="role-badge role-petugas">
                    Petugas Perpustakaan
                </span>

            @else

                <span class="role-badge role-siswa">
                    Siswa
                </span>

            @endif


            <div class="profile-divider"></div>


            <div class="profile-item">

                <span>
                    Username
                </span>

                <strong>
                    {{ $user->username }}
                </strong>

            </div>


            <div class="profile-item">

                <span>
                    Email
                </span>

                <strong>
                    {{ $user->email }}
                </strong>

            </div>


            <div class="profile-item">

                <span>
                    Terdaftar Sejak
                </span>

                <strong>
                    {{ $user->created_at?->format('d M Y') ?? '-' }}
                </strong>

            </div>

        </div>

    </div>


    {{-- INFORMATION --}}
    <div>

        <div class="card information-card">

            <div class="card-title">

                <div>
                    <h2>
                        Informasi Pengguna
                    </h2>

                    <p>
                        Data pribadi dan informasi akademik pengguna.
                    </p>
                </div>

            </div>


            <div class="info-grid">


                {{-- NAMA --}}
                <div class="info-box">

                    <span>
                        Nama Lengkap
                    </span>

                    <strong>
                        {{ $user->name }}
                    </strong>

                </div>


                {{-- USERNAME --}}
                <div class="info-box">

                    <span>
                        Username
                    </span>

                    <strong>
                        {{ $user->username }}
                    </strong>

                </div>


                {{-- EMAIL --}}
                <div class="info-box">

                    <span>
                        Email
                    </span>

                    <strong>
                        {{ $user->email }}
                    </strong>

                </div>


                {{-- ROLE --}}
                <div class="info-box">

                    <span>
                        Role
                    </span>

                    <strong>

                        @if($user->role === 'admin')
                            Administrator
                        @elseif($user->role === 'petugas')
                            Petugas Perpustakaan
                        @else
                            Siswa
                        @endif

                    </strong>

                </div>


                {{-- NIS --}}
                <div class="info-box">

                    <span>
                        NIS
                    </span>

                    <strong>
                        {{ $user->nis ?: '-' }}
                    </strong>

                </div>


                {{-- KELAS --}}
                <div class="info-box">

                    <span>
                        Kelas
                    </span>

                    <strong>
                        {{ $user->kelas ?: '-' }}
                    </strong>

                </div>


                {{-- TELEPON --}}
                <div class="info-box">

                    <span>
                        No. Telepon
                    </span>

                    <strong>
                        {{ $user->no_telepon ?: '-' }}
                    </strong>

                </div>


                {{-- ALAMAT --}}
                <div class="info-box info-full">

                    <span>
                        Alamat
                    </span>

                    <strong>
                        {{ $user->alamat ?: 'Belum diisi' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- LOAN HISTORY --}}
        <div class="card loan-history-card">

            <div class="card-title">

                <div>
                    <h2>
                        Riwayat Peminjaman
                    </h2>

                    <p>
                        Daftar transaksi peminjaman pengguna.
                    </p>
                </div>

                <div class="loan-count">

                    {{ $user->loans->count() }}

                    transaksi

                </div>

            </div>


            @if($user->loans->count() > 0)

                <div class="table-wrapper">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    Kode
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Buku
                                </th>

                                <th>
                                    Jatuh Tempo
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($user->loans as $loan)

                                <tr>

                                    <td>

                                        <strong class="loan-code">
                                            {{ $loan->loan_code }}
                                        </strong>

                                    </td>


                                    <td>

                                        {{ $loan->loan_date
                                            ? $loan->loan_date->format('d/m/Y')
                                            : '-'
                                        }}

                                    </td>


                                    <td>

                                        <div class="book-list">

                                            @foreach($loan->loanDetails as $detail)

                                                <div class="book-row">

                                                    <span class="book-dot">
                                                        •
                                                    </span>

                                                    <span>
                                                        {{ $detail->book->title ?? '-' }}

                                                        @if($detail->quantity > 1)
                                                            × {{ $detail->quantity }}
                                                        @endif
                                                    </span>

                                                </div>

                                            @endforeach

                                        </div>

                                    </td>


                                    <td>

                                        {{ $loan->due_date
                                            ? $loan->due_date->format('d/m/Y')
                                            : '-'
                                        }}

                                    </td>


                                    <td>

                                        @if($loan->status === 'pending')

                                            <span class="status-badge status-pending">
                                                Pending
                                            </span>

                                        @elseif($loan->status === 'approved')

                                            <span class="status-badge status-approved">
                                                Approved
                                            </span>

                                        @elseif($loan->status === 'borrowed')

                                            <span class="status-badge status-borrowed">
                                                Dipinjam
                                            </span>

                                        @elseif($loan->status === 'returned')

                                            <span class="status-badge status-returned">
                                                Dikembalikan
                                            </span>

                                        @elseif($loan->status === 'rejected')

                                            <span class="status-badge status-rejected">
                                                Ditolak
                                            </span>

                                        @else

                                            <span class="status-badge">
                                                {{ ucfirst($loan->status) }}
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        📚
                    </div>

                    <h3>
                        Belum Ada Peminjaman
                    </h3>

                    <p>
                        Pengguna ini belum memiliki riwayat peminjaman buku.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

    .user-detail-layout {
        display: grid;
        grid-template-columns: 310px minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }


    /* PROFILE */

    .profile-card {
        padding: 0;
        overflow: hidden;
    }


    .profile-cover {
        height: 115px;

        position: relative;
        overflow: hidden;

        background:
            linear-gradient(
                135deg,
                #2563eb,
                #3b82f6,
                #60a5fa
            );
    }


    .profile-circle {
        position: absolute;

        width: 190px;
        height: 190px;

        right: -60px;
        top: -90px;

        border: 25px solid rgba(255,255,255,.10);

        border-radius: 50%;
    }


    .profile-body {
        padding: 0 24px 25px;

        text-align: center;
    }


    .avatar {
        width: 82px;
        height: 82px;

        margin: -41px auto 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #fff;

        border: 5px solid #fff;

        box-shadow:
            0 8px 25px rgba(15,23,42,.15);

        color: #2563eb;

        font-size: 28px;
        font-weight: 800;

        position: relative;
    }


    .profile-body h2 {
        margin: 0 0 9px;

        color: #111827;

        font-size: 19px;
        font-weight: 800;
    }


    .role-badge {
        display: inline-flex;

        padding: 6px 12px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 700;
    }


    .role-admin {
        background: #ede9fe;
        color: #7c3aed;
    }


    .role-petugas {
        background: #dbeafe;
        color: #2563eb;
    }


    .role-siswa {
        background: #dcfce7;
        color: #15803d;
    }


    .profile-divider {
        height: 1px;

        background: #e5e7eb;

        margin: 22px 0 5px;
    }


    .profile-item {
        padding: 13px 0;

        text-align: left;

        border-bottom: 1px solid #f1f5f9;
    }


    .profile-item:last-child {
        border-bottom: none;
    }


    .profile-item span {
        display: block;

        margin-bottom: 4px;

        color: #94a3b8;

        font-size: 10px;
        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: .04em;
    }


    .profile-item strong {
        color: #334155;

        font-size: 13px;

        word-break: break-word;
    }


    /* INFORMATION */

    .information-card,
    .loan-history-card {
        padding: 0;
        overflow: hidden;

        margin-bottom: 24px;
    }


    .card-title {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 23px 25px;

        border-bottom: 1px solid #eef2f7;
    }


    .card-title h2 {
        margin: 0 0 4px;

        color: #111827;

        font-size: 17px;
    }


    .card-title p {
        margin: 0;

        color: #64748b;

        font-size: 12px;
    }


    .info-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 15px;

        padding: 24px 25px;
    }


    .info-box {
        padding: 15px;

        border: 1px solid #edf1f5;

        border-radius: 10px;

        background: #fafbfc;
    }


    .info-box span {
        display: block;

        margin-bottom: 6px;

        color: #94a3b8;

        font-size: 10px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .04em;
    }


    .info-box strong {
        display: block;

        color: #334155;

        font-size: 13px;

        line-height: 1.5;

        word-break: break-word;
    }


    .info-full {
        grid-column: 1 / -1;
    }


    /* LOAN */

    .loan-count {
        padding: 6px 10px;

        border-radius: 7px;

        background: #eff6ff;

        color: #2563eb;

        font-size: 11px;
        font-weight: 700;
    }


    .table-wrapper {
        overflow-x: auto;
    }


    table {
        width: 100%;

        border-collapse: collapse;

        min-width: 700px;
    }


    th {
        padding: 12px 20px;

        background: #f8fafc;

        color: #64748b;

        font-size: 10px;
        font-weight: 800;

        text-align: left;

        text-transform: uppercase;

        letter-spacing: .04em;

        border-bottom: 1px solid #e5e7eb;
    }


    td {
        padding: 14px 20px;

        color: #475569;

        font-size: 12px;

        border-bottom: 1px solid #f1f5f9;

        vertical-align: middle;
    }


    tbody tr:last-child td {
        border-bottom: none;
    }


    tbody tr:hover {
        background: #fafcff;
    }


    .loan-code {
        color: #2563eb;

        font-size: 12px;
    }


    .book-list {
        display: flex;
        flex-direction: column;

        gap: 4px;
    }


    .book-row {
        display: flex;
        align-items: flex-start;

        gap: 5px;

        color: #475569;

        line-height: 1.4;
    }


    .book-dot {
        color: #2563eb;

        font-weight: 900;
    }


    /* STATUS */

    .status-badge {
        display: inline-flex;

        padding: 5px 9px;

        border-radius: 999px;

        font-size: 10px;
        font-weight: 700;
    }


    .status-pending {
        background: #fef3c7;
        color: #b45309;
    }


    .status-approved {
        background: #dbeafe;
        color: #1d4ed8;
    }


    .status-borrowed {
        background: #ede9fe;
        color: #7c3aed;
    }


    .status-returned {
        background: #dcfce7;
        color: #15803d;
    }


    .status-rejected {
        background: #fee2e2;
        color: #dc2626;
    }


    /* EMPTY */

    .empty-state {
        padding: 45px 25px;

        text-align: center;
    }


    .empty-icon {
        width: 55px;
        height: 55px;

        margin: 0 auto 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background: #f1f5f9;

        font-size: 23px;
    }


    .empty-state h3 {
        margin: 0 0 5px;

        color: #334155;

        font-size: 14px;
    }


    .empty-state p {
        margin: 0;

        color: #94a3b8;

        font-size: 12px;
    }


    /* RESPONSIVE */

    @media (max-width: 950px) {

        .user-detail-layout {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 650px) {

        .info-grid {
            grid-template-columns: 1fr;
        }

        .info-full {
            grid-column: auto;
        }

        .card-title {
            padding: 20px;
        }

        .info-grid {
            padding: 20px;
        }

        .page-header-actions {
            flex-wrap: wrap;
        }

    }

</style>

@endpush