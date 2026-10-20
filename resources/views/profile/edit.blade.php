
@extends('layouts.app')

@section('title', 'Profil Saya')
@section('header', 'Profil Saya')

@section('content')
@php
    $user = $user ?? auth()->user();

    if (!$user) {
        $user = \App\Models\User::find(session('user_id'));
    }

    $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
@endphp

<style>
    .profile-page {
        color: #285C45;
    }

    .profile-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 24px;
        padding: 30px;
        margin-bottom: 24px;
        border-radius: 24px;
        background: linear-gradient(120deg, #EAF5EE 0%, #FFF0F5 100%);
        border: 1px solid #E4EEE7;
    }

    .profile-hero::after {
        content: "";
        position: absolute;
        width: 190px;
        height: 190px;
        border-radius: 50%;
        right: -50px;
        top: -85px;
        background: rgba(114, 185, 149, .15);
    }

    .profile-avatar {
        width: 92px;
        height: 92px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 27px;
        background: #285C45;
        color: white;
        font-size: 34px;
        font-weight: 800;
        box-shadow: 0 10px 25px rgba(40, 92, 69, .18);
        border: 5px solid rgba(255, 255, 255, .8);
    }

    .profile-hero-info {
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .profile-eyebrow {
        display: inline-flex;
        padding: 5px 10px;
        border-radius: 30px;
        background: rgba(255,255,255,.8);
        color: #285C45;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .6px;
        text-transform: uppercase;
        margin-bottom: 9px;
    }

    .profile-name {
        font-size: 25px;
        line-height: 1.3;
        font-weight: 850;
        letter-spacing: -.5px;
        overflow-wrap: anywhere;
    }

    .profile-email {
        color: #71877A;
        font-size: 12px;
        margin-top: 5px;
        overflow-wrap: anywhere;
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        padding: 6px 11px;
        border-radius: 30px;
        background: #FFFFFF;
        border: 1px solid #DCEBE0;
        font-size: 10px;
        font-weight: 750;
        text-transform: capitalize;
    }

    .profile-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(240px, .8fr);
        gap: 22px;
        align-items: start;
    }

    .profile-card {
        background: #FFFFFF;
        border: 1px solid #E4EEE7;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(40, 92, 69, .045);
        margin-bottom: 20px;
    }

    .profile-card-header {
        padding: 21px 23px;
        border-bottom: 1px solid #EAF1EC;
    }

    .profile-card-title {
        font-size: 15px;
        font-weight: 850;
        color: #285C45;
    }

    .profile-card-subtitle {
        font-size: 11px;
        color: #84968B;
        margin-top: 4px;
    }

    .profile-card-body {
        padding: 23px;
    }

    .profile-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 19px;
    }

    .profile-field {
        min-width: 0;
    }

    .profile-field.full {
        grid-column: 1 / -1;
    }

    .profile-label {
        display: block;
        margin-bottom: 8px;
        color: #385A46;
        font-size: 11px;
        font-weight: 750;
    }

    .profile-input {
        display: block;
        width: 100%;
        min-height: 45px;
        padding: 11px 13px;
        border: 1px solid #DCE9E0;
        border-radius: 12px;
        background: #FFFCFD;
        color: #285C45;
        font-family: inherit;
        font-size: 12px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .profile-input:focus {
        border-color: #72B995;
        box-shadow: 0 0 0 4px rgba(114,185,149,.13);
    }

    .profile-input::placeholder {
        color: #A0B0A6;
    }

    .profile-input:disabled {
        background: #F3F7F4;
        color: #84968B;
        cursor: not-allowed;
    }

    .profile-hint {
        margin-top: 6px;
        font-size: 10px;
        color: #8A9B90;
        line-height: 1.6;
    }

    .profile-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #EAF1EC;
    }

    .profile-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        min-height: 43px;
        padding: 11px 17px;
        border-radius: 12px;
        border: none;
        text-decoration: none;
        font-family: inherit;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        transition: transform .2s, background .2s;
    }

    .profile-btn:hover {
        transform: translateY(-2px);
    }

    .profile-btn-primary {
        background: #285C45;
        color: #FFFFFF;
        box-shadow: 0 6px 15px rgba(40,92,69,.13);
    }

    .profile-btn-primary:hover {
        background: #72B995;
        color: #173D2D;
    }

    .profile-btn-light {
        background: #FFF0F5;
        color: #285C45;
    }

    .profile-btn-light:hover {
        background: #F4C5D8;
    }

    .profile-side-card {
        padding: 22px;
        background: #FFFFFF;
        border: 1px solid #E4EEE7;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(40,92,69,.045);
        margin-bottom: 20px;
    }

    .profile-side-heading {
        font-size: 14px;
        font-weight: 850;
        margin-bottom: 17px;
    }

    .profile-info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid #EDF3EF;
    }

    .profile-info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .profile-info-icon {
        width: 37px;
        height: 37px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #EAF5EE;
        color: #285C45;
        font-size: 15px;
    }

    .profile-info-text {
        min-width: 0;
    }

    .profile-info-label {
        color: #84968B;
        font-size: 10px;
        margin-bottom: 4px;
    }

    .profile-info-value {
        color: #285C45;
        font-size: 11px;
        font-weight: 750;
        overflow-wrap: anywhere;
        text-transform: capitalize;
    }

    .profile-note {
        padding: 17px;
        border-radius: 15px;
        background: #FFF0F5;
        border: 1px solid #F6DCE6;
        color: #6C5962;
        font-size: 11px;
        line-height: 1.8;
    }

    .profile-note strong {
        color: #285C45;
    }

    .profile-alert {
        padding: 13px 16px;
        border-radius: 12px;
        margin-bottom: 18px;
        font-size: 12px;
    }

    .profile-alert-success {
        background: #EAF5EE;
        color: #285C45;
        border: 1px solid #CDE5D5;
    }

    .profile-alert-error {
        background: #FFF0F5;
        color: #A83250;
        border: 1px solid #F4C5D8;
    }

    @media (max-width: 900px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .profile-hero {
            padding: 21px;
            gap: 15px;
            border-radius: 19px;
        }

        .profile-avatar {
            width: 68px;
            height: 68px;
            border-radius: 21px;
            font-size: 26px;
        }

        .profile-name {
            font-size: 19px;
        }

        .profile-email {
            font-size: 10px;
        }

        .profile-card-header,
        .profile-card-body {
            padding: 17px;
        }

        .profile-form-grid {
            grid-template-columns: 1fr;
        }

        .profile-field.full {
            grid-column: auto;
        }

        .profile-actions {
            flex-direction: column-reverse;
        }

        .profile-actions .profile-btn {
            width: 100%;
        }
    }
</style>

<div class="profile-page">

    @if(session('success'))
        <div class="profile-alert profile-alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="profile-alert profile-alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="profile-alert profile-alert-error">
            <strong>Periksa kembali data yang kamu masukkan.</strong>
            <ul style="padding-left: 18px; margin-top: 7px; list-style: disc;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PROFILE HERO --}}
    <div class="profile-hero">
        <div class="profile-avatar">{{ $initial }}</div>

        <div class="profile-hero-info">
            <span class="profile-eyebrow">✦ Akun E-Library</span>

            <h2 class="profile-name">
                {{ $user->name ?? 'Pengguna' }}
            </h2>

            <p class="profile-email">
                {{ $user->email ?? 'Email belum tersedia' }}
            </p>

            <span class="profile-role">
                <span>●</span>
                {{ $user->role ?? 'Pengguna' }}
            </span>
        </div>
    </div>

    <div class="profile-layout">

        {{-- FORM PROFIL --}}
        <div>
            <div class="profile-card">
                <div class="profile-card-header">
                    <h3 class="profile-card-title">Informasi Pribadi</h3>
                    <p class="profile-card-subtitle">
                        Perbarui informasi akunmu di bawah ini.
                    </p>
                </div>

                <div class="profile-card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="profile-form-grid">

                            <div class="profile-field full">
                                <label class="profile-label" for="name">
                                    Nama Lengkap
                                </label>

                                <input
                                    class="profile-input"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name ?? '') }}"
                                    placeholder="Masukkan nama lengkap"
                                    maxlength="255"
                                    required
                                >
                            </div>

                            <div class="profile-field full">
                                <label class="profile-label" for="email">
                                    Alamat Email
                                </label>

                                <input
                                    class="profile-input"
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email ?? '') }}"
                                    placeholder="nama@email.com"
                                    maxlength="255"
                                    required
                                >

                                <p class="profile-hint">
                                    Gunakan email yang aktif dan belum digunakan akun lain.
                                </p>
                            </div>

                            <div class="profile-field">
                                <label class="profile-label" for="username">
                                    Username
                                </label>

                                <input
                                    class="profile-input"
                                    type="text"
                                    id="username"
                                    value="{{ $user->username ?? '-' }}"
                                    disabled
                                >

                                <p class="profile-hint">
                                    Username ditampilkan sebagai informasi akun.
                                </p>
                            </div>

                            <div class="profile-field">
                                <label class="profile-label" for="role">
                                    Peran Akun
                                </label>

                                <input
                                    class="profile-input"
                                    type="text"
                                    id="role"
                                    value="{{ ucfirst($user->role ?? 'Pengguna') }}"
                                    disabled
                                >

                                <p class="profile-hint">
                                    Peran akun dikelola oleh sistem.
                                </p>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <a href="{{ route('dashboard') }}" class="profile-btn profile-btn-light">
                                ← Kembali
                            </a>

                            <button type="submit" class="profile-btn profile-btn-primary">
                                ✓ Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- INFORMASI AKUN --}}
        <aside>
            <div class="profile-side-card">
                <h3 class="profile-side-heading">Ringkasan Akun</h3>

                <div class="profile-info-row">
                    <div class="profile-info-icon">♙</div>
                    <div class="profile-info-text">
                        <div class="profile-info-label">Nama Pengguna</div>
                        <div class="profile-info-value">
                            {{ $user->name ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-icon">✉</div>
                    <div class="profile-info-text">
                        <div class="profile-info-label">Email</div>
                        <div class="profile-info-value" style="text-transform:none">
                            {{ $user->email ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-icon">♧</div>
                    <div class="profile-info-text">
                        <div class="profile-info-label">Jenis Akun</div>
                        <div class="profile-info-value">
                            {{ $user->role ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-icon">✓</div>
                    <div class="profile-info-text">
                        <div class="profile-info-label">Status</div>
                        <div class="profile-info-value">Aktif</div>
                    </div>
                </div>
            </div>

            <div class="profile-side-card">
                <h3 class="profile-side-heading">Keamanan Akun</h3>

                <div class="profile-note">
                    <strong>🔒 Jaga keamanan akunmu.</strong>
                    <br>
                    Gunakan kata sandi yang kuat dan jangan membagikannya kepada orang lain.
                </div>

                <a
                    href="{{ route('profile.password') }}"
                    class="profile-btn profile-btn-primary"
                    style="width:100%; margin-top:15px;"
                >
                    ⚿ Ubah Kata Sandi
                </a>
            </div>

            <div class="profile-note">
                <strong>♡ E-Library 5</strong>
                <br>
                SMK Negeri 5 Surakarta
                <br>
                Read more, learn more.
            </div>
        </aside>

    </div>
</div>
@endsection
