@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('header', 'Tambah Pengguna')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="welcome">

        <div>
            <h1 class="welcome-title">
                Tambah Pengguna
            </h1>

            <p class="welcome-description">
                Tambahkan akun baru untuk Admin, Petugas Perpustakaan,
                atau Siswa.
            </p>
        </div>

        <a
            href="{{ route('users.index') }}"
            class="btn btn-light"
        >
            <span>←</span>
            <span>Kembali</span>
        </a>

    </div>


    {{-- FORM CARD --}}
    <div class="card form-card">

        <div class="card-header">

            <div>
                <div class="card-title">
                    Informasi Pengguna
                </div>

                <div class="card-subtitle">
                    Lengkapi data akun pengguna dengan benar.
                </div>
            </div>

            <span class="badge badge-approved">
                Akun Baru
            </span>

        </div>


        <div class="card-body">

            {{-- VALIDATION ERROR --}}
            @if ($errors->any())

                <div
                    class="alert alert-error"
                    style="margin-bottom:20px;"
                >

                    <strong>
                        Data belum dapat disimpan.
                    </strong>

                    <ul
                        style="
                            margin:8px 0 0 18px;
                            padding:0;
                        "
                    >

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('users.store') }}"
                method="POST"
            >

                @csrf


                <div class="form-grid">


                    {{-- NAMA --}}

                    <div class="form-group full">

                        <label
                            for="name"
                            class="form-label"
                        >
                            Nama Lengkap
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            autofocus
                        >

                    </div>


                    {{-- USERNAME --}}

                    <div class="form-group">

                        <label
                            for="username"
                            class="form-label"
                        >
                            Username
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="form-control"
                            value="{{ old('username') }}"
                            placeholder="Contoh: siswa001"
                            required
                        >

                    </div>


                    {{-- EMAIL --}}

                    <div class="form-group">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            placeholder="contoh@email.com"
                        >

                    </div>


                    {{-- PASSWORD --}}

                    <div class="form-group">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            required
                        >

                    </div>


                    {{-- CONFIRM PASSWORD --}}

                    <div class="form-group">

                        <label
                            for="password_confirmation"
                            class="form-label"
                        >
                            Konfirmasi Password
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password"
                            required
                        >

                    </div>


                    {{-- ROLE --}}

                    <div class="form-group full">

                        <label
                            for="role"
                            class="form-label"
                        >
                            Role Pengguna
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <select
                            name="role"
                            id="role"
                            class="form-control"
                            required
                        >

                            <option value="">
                                Pilih role pengguna
                            </option>

                            <option
                                value="admin"
                                {{ old('role') === 'admin' ? 'selected' : '' }}
                            >
                                Admin
                            </option>

                            <option
                                value="petugas"
                                {{ old('role') === 'petugas' ? 'selected' : '' }}
                            >
                                Petugas Perpustakaan
                            </option>

                            <option
                                value="siswa"
                                {{ old('role') === 'siswa' ? 'selected' : '' }}
                            >
                                Siswa
                            </option>

                        </select>

                        <div
                            style="
                                margin-top:6px;
                                color:#94a3b8;
                                font-size:9.5px;
                                line-height:1.6;
                            "
                        >
                            Role menentukan hak akses pengguna
                            terhadap sistem.
                        </div>

                    </div>


                    {{-- NIS --}}

                    <div
                        class="form-group student-field"
                        id="nisField"
                    >

                        <label
                            for="nis"
                            class="form-label"
                        >
                            NIS
                        </label>

                        <input
                            type="text"
                            name="nis"
                            id="nis"
                            class="form-control"
                            value="{{ old('nis') }}"
                            placeholder="Nomor Induk Siswa"
                        >

                    </div>


                    {{-- KELAS --}}

                    <div
                        class="form-group student-field"
                        id="kelasField"
                    >

                        <label
                            for="kelas"
                            class="form-label"
                        >
                            Kelas
                        </label>

                        <input
                            type="text"
                            name="kelas"
                            id="kelas"
                            class="form-control"
                            value="{{ old('kelas') }}"
                            placeholder="Contoh: XII RPL C"
                        >

                    </div>


                    {{-- NO TELEPON --}}

                    <div class="form-group">

                        <label
                            for="no_telepon"
                            class="form-label"
                        >
                            No. Telepon
                        </label>

                        <input
                            type="text"
                            name="no_telepon"
                            id="no_telepon"
                            class="form-control"
                            value="{{ old('no_telepon') }}"
                            placeholder="Contoh: 08xxxxxxxxxx"
                        >

                    </div>


                    {{-- ALAMAT --}}

                    <div class="form-group">

                        <label
                            for="alamat"
                            class="form-label"
                        >
                            Alamat
                        </label>

                        <input
                            type="text"
                            name="alamat"
                            id="alamat"
                            class="form-control"
                            value="{{ old('alamat') }}"
                            placeholder="Alamat pengguna"
                        >

                    </div>

                </div>


                {{-- FORM ACTION --}}

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <span>✓</span>
                        <span>Simpan Pengguna</span>
                    </button>

                    <a
                        href="{{ route('users.index') }}"
                        class="btn btn-light"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- INFO ROLE --}}

    <div
        class="card"
        style="margin-top:20px;"
    >

        <div class="card-body">

            <div
                style="
                    display:grid;
                    grid-template-columns:
                        repeat(3, minmax(0, 1fr));
                    gap:15px;
                "
            >

                {{-- ADMIN --}}

                <div
                    style="
                        padding:16px;
                        border:1px solid #e2e8f0;
                        border-radius:12px;
                        background:#fff;
                    "
                >

                    <div
                        style="
                            font-size:20px;
                            margin-bottom:8px;
                        "
                    >
                        🛡
                    </div>

                    <strong
                        style="
                            display:block;
                            color:#334155;
                            font-size:11px;
                            margin-bottom:5px;
                        "
                    >
                        Admin
                    </strong>

                    <p
                        style="
                            color:#94a3b8;
                            font-size:9.5px;
                            line-height:1.6;
                            margin:0;
                        "
                    >
                        Memiliki akses penuh untuk mengelola
                        sistem dan data pengguna.
                    </p>

                </div>


                {{-- PETUGAS --}}

                <div
                    style="
                        padding:16px;
                        border:1px solid #e2e8f0;
                        border-radius:12px;
                        background:#fff;
                    "
                >

                    <div
                        style="
                            font-size:20px;
                            margin-bottom:8px;
                        "
                    >
                        📚
                    </div>

                    <strong
                        style="
                            display:block;
                            color:#334155;
                            font-size:11px;
                            margin-bottom:5px;
                        "
                    >
                        Petugas
                    </strong>

                    <p
                        style="
                            color:#94a3b8;
                            font-size:9.5px;
                            line-height:1.6;
                            margin:0;
                        "
                    >
                        Mengelola buku, peminjaman, pengembalian,
                        dan operasional perpustakaan.
                    </p>

                </div>


                {{-- SISWA --}}

                <div
                    style="
                        padding:16px;
                        border:1px solid #e2e8f0;
                        border-radius:12px;
                        background:#fff;
                    "
                >

                    <div
                        style="
                            font-size:20px;
                            margin-bottom:8px;
                        "
                    >
                        👨‍🎓
                    </div>

                    <strong
                        style="
                            display:block;
                            color:#334155;
                            font-size:11px;
                            margin-bottom:5px;
                        "
                    >
                        Siswa
                    </strong>

                    <p
                        style="
                            color:#94a3b8;
                            font-size:9.5px;
                            line-height:1.6;
                            margin:0;
                        "
                    >
                        Melihat katalog, mengajukan peminjaman,
                        dan melihat riwayat peminjaman.
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('styles')

<style>

    select.form-control {
        appearance:auto;
        cursor:pointer;
    }

    .student-field {
        transition:all .2s ease;
    }

    @media (max-width:700px) {

        .welcome {
            flex-direction:column;
            align-items:flex-start;
            gap:15px;
        }

        .welcome .btn {
            width:100%;
            justify-content:center;
        }

        .card-body > div[style*="grid-template-columns"] {
            grid-template-columns:1fr !important;
        }

    }

</style>

@endpush


@push('scripts')

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const role = document.getElementById('role');

        const nisField = document.getElementById('nisField');

        const kelasField = document.getElementById('kelasField');

        const nis = document.getElementById('nis');

        const kelas = document.getElementById('kelas');


        function updateStudentFields() {

            if (role.value === 'siswa') {

                nisField.style.display = 'block';

                kelasField.style.display = 'block';

            } else {

                nisField.style.display = 'none';

                kelasField.style.display = 'none';

                nis.value = '';

                kelas.value = '';

            }

        }


        role.addEventListener('change', updateStudentFields);

        updateStudentFields();

    });

</script>

@endpush