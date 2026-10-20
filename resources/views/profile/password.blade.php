@extends('layouts.app')

@section('title', 'Ubah Password')

@section('page_title', 'Ubah Password')

@section('content')

<div class="page-header">
    <div>
        <div class="page-eyebrow">SECURITY</div>
        <h1 class="page-title">Ubah Password</h1>
        <p class="page-subtitle">
            Perbarui password akun untuk menjaga keamanan akun kamu.
        </p>
    </div>

    <div class="page-header-actions">
        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>
</div>


@if(session('success'))
    <div class="alert alert-success">
        <div class="alert-icon">✓</div>
        <div>
            <strong>Berhasil!</strong>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif


@if(session('error'))
    <div class="alert alert-danger">
        <div class="alert-icon">!</div>
        <div>
            <strong>Gagal!</strong>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif


@if($errors->any())
    <div class="alert alert-danger">
        <div class="alert-icon">!</div>

        <div>
            <strong>Periksa kembali data.</strong>

            <ul style="margin: 6px 0 0 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


<div class="security-page">

    {{-- INFO --}}
    <div class="security-intro card">

        <div class="security-big-icon">
            🔐
        </div>

        <h2>Keamanan Akun</h2>

        <p>
            Password yang kuat membantu menjaga akun E-Library
            tetap aman dan mencegah orang lain mengakses akun kamu.
        </p>

        <div class="security-tips">

            <div class="tip">
                <span>✓</span>
                <div>
                    <strong>Minimal 8 karakter</strong>
                    <small>Gunakan password dengan panjang yang cukup.</small>
                </div>
            </div>

            <div class="tip">
                <span>✓</span>
                <div>
                    <strong>Jangan gunakan password yang mudah ditebak</strong>
                    <small>Hindari nama atau informasi pribadi.</small>
                </div>
            </div>

            <div class="tip">
                <span>✓</span>
                <div>
                    <strong>Jangan bagikan password</strong>
                    <small>Simpan password hanya untuk diri sendiri.</small>
                </div>
            </div>

        </div>

    </div>


    {{-- FORM --}}
    <div class="card password-card">

        <div class="card-header">
            <div>
                <h2>Ganti Password</h2>
                <p>Masukkan password lama dan password baru.</p>
            </div>
        </div>


        <form
            action="{{ route('profile.password.update') }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            <div class="password-form">

                {{-- PASSWORD LAMA --}}
                <div class="form-group">

                    <label for="current_password">
                        Password Saat Ini
                        <span class="required">*</span>
                    </label>

                    <div class="password-input">

                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            placeholder="Masukkan password saat ini"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword('current_password', this)"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                    @error('current_password')
                        <small class="error-text">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- PASSWORD BARU --}}
                <div class="form-group">

                    <label for="password">
                        Password Baru
                        <span class="required">*</span>
                    </label>

                    <div class="password-input">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password baru"
                            minlength="8"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword('password', this)"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                    <small class="input-hint">
                        Password minimal 8 karakter.
                    </small>

                    @error('password')
                        <small class="error-text">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- KONFIRMASI --}}
                <div class="form-group">

                    <label for="password_confirmation">
                        Konfirmasi Password Baru
                        <span class="required">*</span>
                    </label>

                    <div class="password-input">

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password baru"
                            minlength="8"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword('password_confirmation', this)"
                            aria-label="Tampilkan password"
                        >
                            👁
                        </button>

                    </div>

                    <small
                        id="password-match"
                        class="input-hint"
                    ></small>

                </div>

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('profile.edit') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    🔒 Simpan Password
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('styles')

<style>

    .security-page {
        display: grid;
        grid-template-columns: 340px minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }


    /* INTRO */

    .security-intro {
        padding: 30px;
    }

    .security-big-icon {
        width: 65px;
        height: 65px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background: #eff6ff;

        font-size: 29px;

        margin-bottom: 20px;
    }

    .security-intro h2 {
        margin: 0 0 8px;

        color: #111827;

        font-size: 20px;
        font-weight: 800;
    }

    .security-intro > p {
        margin: 0;

        color: #64748b;

        font-size: 13px;
        line-height: 1.7;
    }


    /* TIPS */

    .security-tips {
        margin-top: 25px;
        padding-top: 20px;

        border-top: 1px solid #eef2f7;
    }

    .tip {
        display: flex;
        gap: 11px;

        padding: 12px 0;
    }

    .tip > span {
        width: 22px;
        height: 22px;
        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #dcfce7;
        color: #16a34a;

        font-size: 11px;
        font-weight: 800;
    }

    .tip strong {
        display: block;

        margin-bottom: 3px;

        color: #334155;

        font-size: 12px;
    }

    .tip small {
        display: block;

        color: #94a3b8;

        font-size: 11px;
        line-height: 1.5;
    }


    /* PASSWORD CARD */

    .password-card {
        overflow: hidden;
        padding: 0;
    }

    .card-header {
        padding: 24px 26px;

        border-bottom: 1px solid #eef2f7;
    }

    .card-header h2 {
        margin: 0 0 5px;

        color: #111827;

        font-size: 18px;
    }

    .card-header p {
        margin: 0;

        color: #64748b;

        font-size: 13px;
    }

    .password-form {
        padding: 26px;
    }


    /* FORM */

    .form-group {
        margin-bottom: 21px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;

        margin-bottom: 7px;

        color: #334155;

        font-size: 13px;
        font-weight: 700;
    }

    .required {
        color: #ef4444;
    }


    /* PASSWORD INPUT */

    .password-input {
        position: relative;
    }

    .password-input input {
        width: 100%;
        height: 45px;

        box-sizing: border-box;

        padding: 0 48px 0 13px;

        border: 1px solid #dbe3ed;
        border-radius: 9px;

        background: #fff;

        color: #1e293b;

        font-family: inherit;
        font-size: 13px;

        outline: none;

        transition:
            border-color .2s,
            box-shadow .2s;
    }

    .password-input input:focus {
        border-color: #3b82f6;

        box-shadow:
            0 0 0 3px rgba(37,99,235,.10);
    }

    .password-input input::placeholder {
        color: #b0bac7;
    }

    .toggle-password {
        position: absolute;

        top: 50%;
        right: 10px;

        transform: translateY(-50%);

        width: 32px;
        height: 32px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: none;
        border-radius: 7px;

        background: transparent;

        color: #64748b;

        cursor: pointer;

        font-size: 14px;
    }

    .toggle-password:hover {
        background: #f1f5f9;
    }


    /* HINT */

    .input-hint {
        display: block;

        margin-top: 6px;

        color: #94a3b8;

        font-size: 11px;
    }

    .error-text {
        display: block;

        margin-top: 6px;

        color: #dc2626;

        font-size: 11px;
    }


    /* ACTION */

    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 10px;

        padding: 20px 26px;

        border-top: 1px solid #eef2f7;

        background: #fafbfc;
    }


    /* RESPONSIVE */

    @media (max-width: 900px) {

        .security-page {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 600px) {

        .security-intro {
            padding: 22px;
        }

        .password-form {
            padding: 22px;
        }

        .card-header {
            padding: 20px 22px;
        }

        .form-actions {
            padding: 17px 22px;

            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
        }

    }

</style>

@endpush


@push('scripts')

<script>

    function togglePassword(id, button) {

        const input = document.getElementById(id);

        if (!input) {
            return;
        }

        if (input.type === 'password') {

            input.type = 'text';

            button.textContent = '🙈';

        } else {

            input.type = 'password';

            button.textContent = '👁';

        }
    }


    const passwordInput =
        document.getElementById('password');

    const confirmationInput =
        document.getElementById('password_confirmation');

    const passwordMatch =
        document.getElementById('password-match');


    function checkPasswordMatch() {

        if (
            !passwordInput ||
            !confirmationInput ||
            !passwordMatch
        ) {
            return;
        }

        if (confirmationInput.value === '') {

            passwordMatch.textContent = '';

            return;
        }

        if (
            passwordInput.value ===
            confirmationInput.value
        ) {

            passwordMatch.textContent =
                '✓ Password cocok.';

            passwordMatch.style.color =
                '#16a34a';

        } else {

            passwordMatch.textContent =
                '✕ Password belum cocok.';

            passwordMatch.style.color =
                '#dc2626';
        }
    }


    if (passwordInput) {
        passwordInput.addEventListener(
            'input',
            checkPasswordMatch
        );
    }

    if (confirmationInput) {
        confirmationInput.addEventListener(
            'input',
            checkPasswordMatch
        );
    }

</script>

@endpush