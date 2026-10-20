
@extends('layouts.app')

@section('title', 'Data Pengguna')
@section('header', 'Data Pengguna')

@section('content')
@php
    $totalUsers = $users->count();
    $totalSiswa = $users->where('role', 'siswa')->count();
    $totalPetugas = $users->where('role', 'petugas')->count();
    $totalAdmin = $users->where('role', 'admin')->count();
@endphp

<div class="users-page">

    {{-- HERO --}}
    <section class="users-hero">
        <div class="hero-content">
            <span class="hero-eyebrow">
                <span class="eyebrow-dot"></span>
                ADMINISTRATION CENTER
            </span>

            <h1>Data Pengguna<span>.</span></h1>

            <p>
                Kelola akun administrator, petugas perpustakaan, dan siswa
                dalam satu tempat dengan lebih mudah dan terorganisir.
            </p>

            <div class="hero-meta">
                <span><i class="meta-dot"></i> Sistem E-Library</span>
                <span><i class="meta-dot pink-dot"></i> Manajemen Akun</span>
            </div>
        </div>

        <div class="hero-visual" aria-hidden="true">
            <div class="visual-ring ring-one"></div>
            <div class="visual-ring ring-two"></div>
            <div class="visual-orbit">
                <span class="orbit-dot dot-one"></span>
                <span class="orbit-dot dot-two"></span>
            </div>
            <div class="visual-main-icon">
                <svg viewBox="0 0 100 100" fill="none">
                    <rect x="15" y="25" width="70" height="58" rx="13"
                          fill="white" fill-opacity=".95"/>
                    <circle cx="50" cy="43" r="12" fill="#72B995"/>
                    <path d="M29 72C29 61 38 55 50 55C62 55 71 61 71 72"
                          fill="#72B995"/>
                    <circle cx="77" cy="24" r="13" fill="#F4C5D8"/>
                    <path d="M72 24L76 28L83 20" stroke="#285C45"
                          stroke-width="3" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="floating-card floating-top">
                <span class="floating-icon">✦</span>
                <div>
                    <strong>{{ $totalUsers }} akun</strong>
                    <small>Terdaftar</small>
                </div>
            </div>
            <div class="floating-card floating-bottom">
                <span class="floating-avatar">✓</span>
                <div>
                    <strong>Akun terkelola</strong>
                    <small>Lebih praktis</small>
                </div>
            </div>
        </div>
    </section>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert-message alert-success">
            <span class="alert-symbol">✓</span>
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-close"
                    onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-message alert-error">
            <span class="alert-symbol">!</span>
            <span>{{ session('error') }}</span>
            <button type="button" class="alert-close"
                    onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    {{-- STATISTIK --}}
    <section class="user-stats">
        <article class="stat-card stat-total">
            <div class="stat-top">
                <div class="stat-icon"><i class="stat-symbol">♙</i></div>
                <span class="stat-tag">TOTAL</span>
            </div>
            <div class="stat-number">{{ $totalUsers }}</div>
            <div class="stat-name">Seluruh Pengguna</div>
            <div class="stat-bottom">
                <span class="stat-indicator"></span>
                Semua akun terdaftar
            </div>
        </article>

        <article class="stat-card stat-student">
            <div class="stat-top">
                <div class="stat-icon"><i class="stat-symbol">♧</i></div>
                <span class="stat-tag">SISWA</span>
            </div>
            <div class="stat-number">{{ $totalSiswa }}</div>
            <div class="stat-name">Anggota Siswa</div>
            <div class="stat-bottom">
                <span class="stat-indicator"></span>
                Pengguna perpustakaan
            </div>
        </article>

        <article class="stat-card stat-staff">
            <div class="stat-top">
                <div class="stat-icon"><i class="stat-symbol">▤</i></div>
                <span class="stat-tag">PETUGAS</span>
            </div>
            <div class="stat-number">{{ $totalPetugas }}</div>
            <div class="stat-name">Petugas Perpustakaan</div>
            <div class="stat-bottom">
                <span class="stat-indicator"></span>
                Pengelola layanan
            </div>
        </article>

        <article class="stat-card stat-admin">
            <div class="stat-top">
                <div class="stat-icon"><i class="stat-symbol">♔</i></div>
                <span class="stat-tag">ADMIN</span>
            </div>
            <div class="stat-number">{{ $totalAdmin }}</div>
            <div class="stat-name">Administrator</div>
            <div class="stat-bottom">
                <span class="stat-indicator"></span>
                Pengelola sistem
            </div>
        </article>
    </section>

    {{-- DAFTAR PENGGUNA --}}
    <section class="users-panel">
        <div class="panel-heading">
            <div class="panel-heading-text">
                <span class="section-kicker">USER DIRECTORY</span>
                <h2>Direktori Pengguna</h2>
                <p>Informasi akun dan akses pengguna E-Library.</p>
            </div>

            <a href="{{ route('users.create') }}" class="add-user-btn">
                <span class="plus-icon">+</span>
                Tambah Pengguna
            </a>
        </div>

        <div class="users-toolbar">
            <div class="toolbar-search">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor"
                            stroke-width="1.8"/>
                    <path d="M16 16L21 21" stroke="currentColor"
                          stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <input type="text" id="searchUser"
                       placeholder="Cari nama, username, email, NIS..."
                       autocomplete="off">
                <kbd>⌕</kbd>
            </div>

            <div class="toolbar-filter">
                <label for="filterRole">Role</label>
                <select id="filterRole">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="siswa">Siswa</option>
                </select>
            </div>

            <button type="button" id="resetFilter" class="reset-btn">
                Reset
            </button>
        </div>

        <div class="table-summary">
            <div class="summary-left">
                <span class="summary-live"></span>
                <span>Daftar akun pengguna</span>
            </div>
            <span class="summary-count">
                <strong id="visibleCount">{{ $totalUsers }}</strong>
                <span>pengguna ditampilkan</span>
            </span>
        </div>

        <div class="users-table-wrap">
            <table class="users-table">
                <thead>
                    <tr>
                        <th class="col-number">NO.</th>
                        <th>IDENTITAS PENGGUNA</th>
                        <th>USERNAME</th>
                        <th>EMAIL</th>
                        <th>ROLE AKUN</th>
                        <th>INFORMASI SISWA</th>
                        <th class="col-action">AKSI</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @forelse($users as $user)
                        @php
                            $role = strtolower($user->role ?? '');
                            $initial = strtoupper(
                                mb_substr($user->name ?? 'U', 0, 1)
                            );
                            $avatarClass = match($role) {
                                'admin' => 'avatar-admin',
                                'petugas' => 'avatar-staff',
                                default => 'avatar-student',
                            };
                        @endphp

                        <tr class="user-row" data-role="{{ $role }}">
                            <td class="number-cell">
                                <span class="row-number">{{ $loop->iteration }}</span>
                            </td>

                            <td>
                                <div class="identity-cell">
                                    <div class="user-avatar {{ $avatarClass }}">
                                        {{ $initial }}
                                    </div>
                                    <div class="identity-info">
                                        <strong>{{ $user->name }}</strong>
                                        <span>
                                            ID #{{ $user->id }}
                                            @if($user->no_telepon)
                                                <span class="identity-separator">·</span>
                                                {{ $user->no_telepon }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="username-text">
                                    {{ $user->username ?: '—' }}
                                </span>
                            </td>

                            <td>
                                <span class="email-text">
                                    {{ $user->email ?: '—' }}
                                </span>
                            </td>

                            <td>
                                @if($role === 'admin')
                                    <span class="role-badge role-admin">
                                        <span></span> Admin
                                    </span>
                                @elseif($role === 'petugas')
                                    <span class="role-badge role-staff">
                                        <span></span> Petugas
                                    </span>
                                @else
                                    <span class="role-badge role-student">
                                        <span></span> Siswa
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($role === 'siswa')
                                    <div class="student-info">
                                        <strong>{{ $user->kelas ?: 'Kelas belum diisi' }}</strong>
                                        <span>NIS: {{ $user->nis ?: '—' }}</span>
                                    </div>
                                @else
                                    <span class="not-student">Bukan anggota siswa</span>
                                @endif
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="action-btn edit-btn"
                                       title="Edit pengguna"
                                       aria-label="Edit {{ $user->name }}">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M12 20H21" stroke="currentColor"
                                                  stroke-width="1.8"
                                                  stroke-linecap="round"/>
                                            <path d="M16.5 3.5A2.12 2.12 0 0 1 19.5 6.5L8 18L4 19L5 15L16.5 3.5Z"
                                                  stroke="currentColor"
                                                  stroke-width="1.8"
                                                  stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>
                                    </a>

                                    @if((int) session('user_id') !== (int) $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}"
                                              method="POST"
                                              class="delete-user-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="action-btn delete-btn"
                                                    title="Hapus pengguna"
                                                    aria-label="Hapus {{ $user->name }}">
                                                <svg viewBox="0 0 24 24" fill="none">
                                                    <path d="M3 6H21" stroke="currentColor"
                                                          stroke-width="1.8"
                                                          stroke-linecap="round"/>
                                                    <path d="M8 6V4H16V6M19 6L18 20H6L5 6"
                                                          stroke="currentColor"
                                                          stroke-width="1.8"
                                                          stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                    <path d="M10 10V16M14 10V16"
                                                          stroke="currentColor"
                                                          stroke-width="1.8"
                                                          stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="self-account" title="Akun yang sedang digunakan">
                                            Anda
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">♙</div>
                                    <h3>Belum ada pengguna</h3>
                                    <p>Tambahkan pengguna pertama untuk mulai mengelola akun.</p>
                                    <a href="{{ route('users.create') }}" class="add-user-btn">
                                        + Tambah Pengguna
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div id="noSearchResults" class="no-results" hidden>
                <div class="empty-icon">⌕</div>
                <h3>Pengguna tidak ditemukan</h3>
                <p>Coba gunakan kata kunci lain atau ubah filter role.</p>
                <button type="button" id="resetEmptyFilter" class="reset-btn">
                    Tampilkan Semua
                </button>
            </div>
        </div>

        <div class="table-footer">
            <span>Menampilkan data pengguna yang tersedia di sistem.</span>
            <span class="footer-brand"><span>✦</span> E-Library SMKN 5 Surakarta</span>
        </div>
    </section>

    {{-- KETERANGAN ROLE --}}
    <section class="role-guide">
        <div class="guide-heading">
            <div class="guide-heading-icon">✦</div>
            <div>
                <h3>Panduan Hak Akses</h3>
                <p>Setiap role memiliki fungsi yang berbeda.</p>
            </div>
        </div>

        <div class="guide-grid">
            <div class="guide-item">
                <div class="guide-icon guide-admin">♔</div>
                <div>
                    <strong>Administrator</strong>
                    <p>Mengelola data dan pengaturan utama sistem perpustakaan.</p>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon guide-staff">▤</div>
                <div>
                    <strong>Petugas</strong>
                    <p>Membantu pelayanan perpustakaan dan proses peminjaman buku.</p>
                </div>
            </div>

            <div class="guide-item">
                <div class="guide-icon guide-student">♧</div>
                <div>
                    <strong>Siswa</strong>
                    <p>Menjelajahi katalog dan melihat informasi peminjaman pribadi.</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .users-page {
        --green: #285C45;
        --sage: #72B995;
        --sage-light: #EAF6EF;
        --pink: #F4C5D8;
        --pink-light: #FFF0F5;
        --paper: #FFF9FC;
        --ink: #263A30;
        --muted: #829087;
        --line: #E9EEE9;
        color: var(--ink);
        padding-bottom: 30px;
    }

    .users-page * { box-sizing: border-box; }

    .users-hero {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        min-height: 235px;
        padding: 34px 40px;
        overflow: hidden;
        border-radius: 25px;
        background: linear-gradient(115deg, #285C45 0%, #367A5C 62%, #72B995 100%);
        box-shadow: 0 14px 35px rgba(40, 92, 69, .13);
        color: #fff;
    }

    .hero-content { position: relative; z-index: 2; max-width: 620px; }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: #D8F0E1;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .eyebrow-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--pink);
        box-shadow: 0 0 0 4px rgba(244, 197, 216, .16);
    }

    .users-hero h1 {
        margin: 16px 0 10px;
        color: #fff;
        font-size: clamp(29px, 4vw, 43px);
        font-weight: 850;
        letter-spacing: -1.6px;
        line-height: 1.1;
    }

    .users-hero h1 span { color: var(--pink); }

    .users-hero p {
        max-width: 510px;
        margin: 0;
        color: rgba(255,255,255,.82);
        font-size: 13px;
        line-height: 1.9;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 20px;
        font-size: 11px;
        color: rgba(255,255,255,.9);
    }

    .hero-meta span { display: inline-flex; align-items: center; gap: 7px; }
    .meta-dot { width: 6px; height: 6px; border-radius: 50%; background: #AEE4C3; }
    .pink-dot { background: var(--pink); }

    .hero-visual {
        position: relative;
        flex: 0 0 225px;
        height: 190px;
        display: grid;
        place-items: center;
    }

    .visual-ring, .visual-orbit {
        position: absolute;
        border: 1px solid rgba(255,255,255,.22);
        border-radius: 50%;
    }

    .ring-one { width: 170px; height: 170px; }
    .ring-two { width: 132px; height: 132px; }
    .visual-orbit { width: 202px; height: 90px; transform: rotate(-35deg); }
    .orbit-dot { position: absolute; width: 11px; height: 11px; border-radius: 50%; }
    .dot-one { background: var(--pink); top: 7px; left: 28px; }
    .dot-two { background: #D7F1DF; right: 16px; bottom: 10px; }

    .visual-main-icon {
        z-index: 1;
        width: 94px;
        height: 94px;
        padding: 11px;
        border: 1px solid rgba(255,255,255,.5);
        border-radius: 27px;
        background: rgba(255,255,255,.16);
        box-shadow: 0 15px 35px rgba(18,55,38,.15);
        backdrop-filter: blur(8px);
        transform: rotate(-5deg);
    }

    .visual-main-icon svg { display: block; width: 100%; height: 100%; }

    .floating-card {
        position: absolute;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 10px 12px;
        border: 1px solid rgba(255,255,255,.7);
        border-radius: 13px;
        background: rgba(255,255,255,.96);
        box-shadow: 0 8px 24px rgba(24,66,44,.14);
        color: var(--green);
    }

    .floating-card strong, .floating-card small { display: block; white-space: nowrap; }
    .floating-card strong { font-size: 10px; font-weight: 800; }
    .floating-card small { margin-top: 3px; color: var(--muted); font-size: 9px; }
    .floating-top { top: 9px; right: -1px; }
    .floating-bottom { bottom: 4px; left: -4px; }
    .floating-icon, .floating-avatar {
        display: grid;
        place-items: center;
        width: 28px;
        height: 28px;
        flex: 0 0 28px;
        border-radius: 9px;
        background: var(--pink-light);
        color: #B65D82;
        font-size: 16px;
    }
    .floating-avatar { background: var(--sage-light); color: var(--green); }

    .alert-message {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 20px;
        padding: 14px 16px;
        border: 1px solid transparent;
        border-radius: 13px;
        font-size: 12px;
        font-weight: 600;
    }

    .alert-success { color: #285C45; background: #ECF8F0; border-color: #D2EBDD; }
    .alert-error { color: #9D3857; background: #FFF0F5; border-color: #F4D4E0; }
    .alert-symbol {
        display: grid;
        place-items: center;
        width: 25px;
        height: 25px;
        flex: 0 0 25px;
        border-radius: 50%;
        background: rgba(114,185,149,.2);
    }
    .alert-close {
        margin-left: auto;
        border: 0;
        background: transparent;
        color: inherit;
        font-size: 22px;
        cursor: pointer;
    }

    .user-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin: 22px 0;
    }

    .stat-card {
        position: relative;
        min-width: 0;
        padding: 19px;
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 19px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(33,67,47,.035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(33,67,47,.08);
    }

    .stat-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
    .stat-icon {
        display: grid;
        place-items: center;
        width: 43px;
        height: 43px;
        border-radius: 14px;
        background: var(--sage-light);
        color: var(--green);
    }

    .stat-symbol { font-style: normal; font-size: 24px; line-height: 1; }
    .stat-tag {
        padding: 5px 8px;
        border-radius: 7px;
        background: #F6F8F6;
        color: #819086;
        font-size: 8px;
        font-weight: 850;
        letter-spacing: 1px;
    }

    .stat-number {
        margin-top: 17px;
        color: var(--green);
        font-size: 32px;
        font-weight: 850;
        letter-spacing: -1px;
        line-height: 1;
    }

    .stat-name { margin-top: 8px; color: #34473B; font-size: 12px; font-weight: 750; }
    .stat-bottom { display: flex; align-items: center; gap: 7px; margin-top: 14px; color: #89958C; font-size: 10px; }
    .stat-indicator { width: 6px; height: 6px; flex: 0 0 6px; border-radius: 50%; background: var(--sage); }

    .stat-student .stat-icon { background: var(--pink-light); color: #B85F83; }
    .stat-student .stat-number { color: #B85F83; }
    .stat-student .stat-indicator { background: #E99BBA; }
    .stat-staff .stat-icon { background: #F0F2FF; color: #6D77BC; }
    .stat-staff .stat-number { color: #6D77BC; }
    .stat-staff .stat-indicator { background: #8E9AE1; }
    .stat-admin .stat-icon { background: #FFF2E5; color: #BD8650; }
    .stat-admin .stat-number { color: #BD8650; }
    .stat-admin .stat-indicator { background: #E8B67D; }

    .users-panel {
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 21px;
        background: #fff;
        box-shadow: 0 7px 25px rgba(33,67,47,.04);
    }

    .panel-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 25px 26px 22px;
    }

    .section-kicker {
        color: #72A88A;
        font-size: 9px;
        font-weight: 850;
        letter-spacing: 1.8px;
    }

    .panel-heading h2 { margin: 7px 0 5px; color: var(--green); font-size: 21px; font-weight: 850; letter-spacing: -.5px; }
    .panel-heading p { margin: 0; color: var(--muted); font-size: 11px; line-height: 1.7; }

    .add-user-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 43px;
        padding: 0 17px;
        border: 0;
        border-radius: 12px;
        background: var(--green);
        color: #fff !important;
        text-decoration: none !important;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
        box-shadow: 0 5px 12px rgba(40,92,69,.12);
        transition: background .2s ease, transform .2s ease;
    }

    .add-user-btn:hover { background: #367A5C; transform: translateY(-1px); }
    .plus-icon { font-size: 19px; line-height: 1; }

    .users-toolbar {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 26px;
        border-top: 1px solid #F0F3F0;
        border-bottom: 1px solid #F0F3F0;
        background: #FCFDFC;
    }

    .toolbar-search {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 150px;
        height: 43px;
        padding: 0 12px;
        border: 1px solid #E4EBE5;
        border-radius: 11px;
        background: #fff;
        color: #819087;
        transition: border-color .2s, box-shadow .2s;
    }

    .toolbar-search:focus-within {
        border-color: var(--sage);
        box-shadow: 0 0 0 3px rgba(114,185,149,.12);
    }

    .toolbar-search svg { width: 18px; height: 18px; flex: 0 0 18px; }
    .toolbar-search input { width: 100%; min-width: 0; border: 0; outline: 0; background: transparent; color: var(--ink); font: inherit; font-size: 11px; }
    .toolbar-search input::placeholder { color: #A1ABA4; }
    .toolbar-search kbd { display: none; padding: 3px 6px; border: 1px solid #E7ECE8; border-radius: 5px; color: #9AA49D; font-size: 10px; }

    .toolbar-filter { display: flex; align-items: center; gap: 9px; }
    .toolbar-filter label { color: #7E8C82; font-size: 11px; font-weight: 700; }

    .toolbar-filter select {
        height: 43px;
        min-width: 130px;
        padding: 0 30px 0 12px;
        border: 1px solid #E4EBE5;
        border-radius: 11px;
        outline: 0;
        background: #fff;
        color: #405247;
        font: inherit;
        font-size: 11px;
        cursor: pointer;
    }

    .toolbar-filter select:focus { border-color: var(--sage); }
    .reset-btn {
        min-height: 40px;
        padding: 0 13px;
        border: 1px solid #E4EBE5;
        border-radius: 10px;
        background: #fff;
        color: #627268;
        font: inherit;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .reset-btn:hover { border-color: var(--sage); background: var(--sage-light); color: var(--green); }

    .table-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 26px;
    }

    .summary-left { display: flex; align-items: center; gap: 8px; color: #526258; font-size: 11px; font-weight: 750; }
    .summary-live { width: 7px; height: 7px; border-radius: 50%; background: var(--sage); box-shadow: 0 0 0 4px #EAF6EF; }
    .summary-count { display: flex; align-items: center; gap: 5px; color: #89958C; font-size: 10px; }
    .summary-count strong { color: var(--green); font-size: 12px; }

    .users-table-wrap { width: 100%; overflow-x: auto; }
    .users-table { width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; }

    .users-table thead th {
        padding: 13px 14px;
        border-top: 1px solid #EFF2EF;
        border-bottom: 1px solid #E8EEE9;
        background: #F7FAF7;
        color: #7D8A80;
        font-size: 9px;
        font-weight: 850;
        letter-spacing: .65px;
        white-space: nowrap;
    }

    .users-table thead th:first-child,
    .users-table tbody td:first-child { padding-left: 26px; }

    .users-table tbody td {
        padding: 15px 14px;
        border-bottom: 1px solid #F0F3F0;
        color: #46564B;
        font-size: 11px;
        vertical-align: middle;
    }

    .users-table tbody tr:last-child td { border-bottom: 0; }
    .users-table tbody tr.user-row { transition: background .15s ease; }
    .users-table tbody tr.user-row:hover { background: #FBFDFB; }
    .col-number { width: 55px; }
    .col-action { width: 105px; text-align: center; }

    .row-number {
        display: grid;
        place-items: center;
        width: 27px;
        height: 27px;
        border-radius: 8px;
        background: #F4F7F4;
        color: #839087;
        font-size: 10px;
        font-weight: 750;
    }

    .identity-cell { display: flex; align-items: center; gap: 11px; min-width: 180px; }
    .user-avatar {
        display: grid;
        place-items: center;
        width: 39px;
        height: 39px;
        flex: 0 0 39px;
        border-radius: 13px;
        font-size: 14px;
        font-weight: 850;
    }

    .avatar-admin { background: #FFF0F5; color: #B75F82; }
    .avatar-staff { background: #EDF1FF; color: #6574BC; }
    .avatar-student { background: #EAF6EF; color: #397B58; }

    .identity-info { min-width: 0; }
    .identity-info strong { display: block; max-width: 190px; overflow: hidden; color: #2D4335; font-size: 11px; font-weight: 800; text-overflow: ellipsis; white-space: nowrap; }
    .identity-info > span { display: block; margin-top: 5px; color: #95A097; font-size: 9px; white-space: nowrap; }
    .identity-separator { padding: 0 3px; color: #C4CCC6; }
    .username-text { color: #496252; font-weight: 750; white-space: nowrap; }
    .email-text { display: inline-block; max-width: 185px; overflow: hidden; color: #7C8A80; text-overflow: ellipsis; white-space: nowrap; vertical-align: middle; }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 9px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .role-badge > span { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .role-admin { background: #FFF0F5; color: #B75F82; }
    .role-staff { background: #EEF1FF; color: #6574BC; }
    .role-student { background: #EAF6EF; color: #397B58; }

    .student-info strong { display: block; color: #405548; font-size: 10px; font-weight: 750; white-space: nowrap; }
    .student-info span { display: block; margin-top: 5px; color: #95A097; font-size: 9px; white-space: nowrap; }
    .not-student { color: #A4ADA6; font-size: 10px; }

    .action-buttons { display: flex; justify-content: center; align-items: center; gap: 7px; }
    .action-btn {
        display: grid;
        place-items: center;
        width: 33px;
        height: 33px;
        padding: 0;
        border: 1px solid transparent;
        border-radius: 10px;
        cursor: pointer;
        transition: .18s ease;
        text-decoration: none;
    }

    .action-btn svg { width: 15px; height: 15px; }
    .edit-btn { border-color: #DCEFE3; background: #EFF8F2; color: #3F805B; }
    .edit-btn:hover { border-color: #A9D8BA; background: #DDF1E4; }
    .delete-btn { border-color: #F4DCE5; background: #FFF3F7; color: #BD6386; }
    .delete-btn:hover { border-color: #E9B5CA; background: #FCE4ED; }
    .delete-user-form { display: inline-flex; margin: 0; }
    .self-account { padding: 6px 8px; border-radius: 7px; background: #F4F6F4; color: #839087; font-size: 9px; font-weight: 750; }

    .empty-state { padding: 50px 20px; text-align: center; }
    .empty-icon {
        display: grid;
        place-items: center;
        width: 58px;
        height: 58px;
        margin: 0 auto 14px;
        border-radius: 18px;
        background: var(--sage-light);
        color: var(--green);
        font-size: 30px;
    }

    .empty-state h3, .no-results h3 { margin: 0; color: var(--green); font-size: 16px; }
    .empty-state p, .no-results p { margin: 8px 0 18px; color: #8A968D; font-size: 11px; line-height: 1.7; }
    .no-results { padding: 45px 20px; text-align: center; }
    .no-results[hidden] { display: none !important; }

    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 26px;
        border-top: 1px solid #EFF2EF;
        background: #FCFDFC;
        color: #9AA49C;
        font-size: 9px;
    }

    .footer-brand { color: #647A6A; font-weight: 750; }
    .footer-brand span { margin-right: 5px; color: #D78BA9; }

    .role-guide {
        margin-top: 22px;
        padding: 23px 25px;
        border: 1px solid #F0E6EB;
        border-radius: 20px;
        background: linear-gradient(120deg, #FFF9FC 0%, #FFFFFF 62%, #F3FAF5 100%);
    }

    .guide-heading { display: flex; align-items: center; gap: 12px; margin-bottom: 21px; }
    .guide-heading-icon {
        display: grid;
        place-items: center;
        width: 39px;
        height: 39px;
        border-radius: 12px;
        background: var(--pink-light);
        color: #B75F82;
        font-size: 19px;
    }

    .guide-heading h3 { margin: 0; color: var(--green); font-size: 15px; font-weight: 850; }
    .guide-heading p { margin: 5px 0 0; color: #8A968D; font-size: 10px; }
    .guide-grid { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 17px; }
    .guide-item { display: flex; align-items: flex-start; gap: 11px; }
    .guide-icon {
        display: grid;
        place-items: center;
        width: 35px;
        height: 35px;
        flex: 0 0 35px;
        border-radius: 11px;
        font-size: 19px;
    }

    .guide-admin { background: #FFF0F5; color: #B75F82; }
    .guide-staff { background: #EEF1FF; color: #6574BC; }
    .guide-student { background: #EAF6EF; color: #397B58; }
    .guide-item strong { display: block; margin: 1px 0 6px; color: #354A3B; font-size: 11px; }
    .guide-item p { margin: 0; color: #829087; font-size: 10px; line-height: 1.8; }

    @media (max-width: 1100px) {
        .user-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .hero-visual { flex-basis: 190px; }
        .users-table { min-width: 1000px; }
    }

    @media (max-width: 700px) {
        .users-hero { min-height: auto; padding: 25px 23px; border-radius: 20px; }
        .users-hero h1 { font-size: 31px; }
        .users-hero p { font-size: 12px; }
        .hero-visual { display: none; }
        .hero-meta { gap: 11px; font-size: 10px; }
        .user-stats { gap: 10px; margin: 15px 0; }
        .stat-card { padding: 14px; border-radius: 15px; }
        .stat-icon { width: 36px; height: 36px; border-radius: 11px; }
        .stat-symbol { font-size: 20px; }
        .stat-tag { font-size: 7px; }
        .stat-number { margin-top: 14px; font-size: 27px; }
        .stat-name { min-height: 28px; font-size: 11px; line-height: 1.5; }
        .stat-bottom { align-items: flex-start; font-size: 9px; line-height: 1.5; }
        .panel-heading { align-items: flex-start; flex-direction: column; padding: 21px 17px; }
        .panel-heading h2 { font-size: 19px; }
        .add-user-btn { width: 100%; }
        .users-toolbar { align-items: stretch; flex-wrap: wrap; padding: 14px 16px; }
        .toolbar-search { flex-basis: 100%; }
        .toolbar-filter { flex: 1; justify-content: space-between; }
        .toolbar-filter select { flex: 1; }
        .reset-btn { align-self: center; }
        .table-summary { padding: 14px 17px; }
        .summary-left { font-size: 10px; }
        .summary-count { font-size: 9px; }
        .table-footer { align-items: flex-start; flex-direction: column; padding: 14px 17px; }
        .role-guide { padding: 19px 17px; }
        .guide-grid { grid-template-columns: 1fr; gap: 17px; }
    }

    @media (max-width: 380px) {
        .users-hero { padding: 22px 18px; }
        .users-hero h1 { font-size: 27px; }
        .stat-card { padding: 11px; }
        .stat-number { font-size: 24px; }
        .stat-tag { letter-spacing: .3px; }
        .summary-count { flex-direction: column; align-items: flex-end; gap: 2px; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchUser');
    const roleFilter = document.getElementById('filterRole');
    const resetButton = document.getElementById('resetFilter');
    const resetEmptyButton = document.getElementById('resetEmptyFilter');
    const rows = Array.from(document.querySelectorAll('#userTableBody .user-row'));
    const visibleCount = document.getElementById('visibleCount');
    const noResults = document.getElementById('noSearchResults');
    const tableBody = document.getElementById('userTableBody');

    function filterUsers() {
        const keyword = (searchInput.value || '').trim().toLowerCase();
        const selectedRole = (roleFilter.value || '').toLowerCase();
        let visible = 0;

        rows.forEach(function (row) {
            const rowText = row.textContent.toLowerCase();
            const matchesKeyword = rowText.includes(keyword);
            const matchesRole = !selectedRole || row.dataset.role === selectedRole;
            const show = matchesKeyword && matchesRole;

            row.style.display = show ? '' : 'none';

            if (show) {
                visible++;
            }
        });

        visibleCount.textContent = visible;

        if (rows.length > 0) {
            noResults.hidden = visible !== 0;
            tableBody.style.display = visible === 0 ? 'none' : '';
        }
    }

    function resetFilters() {
        searchInput.value = '';
        roleFilter.value = '';
        filterUsers();
        searchInput.focus();
    }

    searchInput.addEventListener('input', filterUsers);
    roleFilter.addEventListener('change', filterUsers);
    resetButton.addEventListener('click', resetFilters);

    if (resetEmptyButton) {
        resetEmptyButton.addEventListener('click', resetFilters);
    }

    document.querySelectorAll('.delete-user-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const confirmed = window.confirm(
                'Yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.'
            );

            if (!confirmed) {
                event.preventDefault();
            }
        });
    });

    filterUsers();
});
</script>
@endpush
