@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('header', 'Edit Pengguna')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="welcome">

        <div>
            <h1 class="welcome-title">
                Edit Pengguna
            </h1>

            <p class="welcome-description">
                Perbarui informasi akun pengguna pada sistem
                E-Library SMK Negeri 5 Surakarta.
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
                    Ubah data akun pengguna sesuai kebutuhan.
                </div>
            </div>

            <span class="badge badge-approved">
                Edit Data
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
                action="{{ route('users.update', $user->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')


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
                            value="{{ old('name', $user->name) }}"
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
                            value="{{ old('username', $user->username) }}"
                            placeholder="Username"
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
                            value="{{ old('email', $user->email) }}"
                            placeholder="contoh@email.com"
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
                                {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                            >
                                Admin
                            </option>

                            <option
                                value="petugas"
                                {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}
                            >
                                Petugas Perpustakaan
                            </option>

                            <option
                                value="siswa"
                                {{ old('role', $user->role) === 'siswa' ? 'selected' : '' }}
                            >
                                Siswa
                            </option>

                        </select>

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
                            value="{{ old('nis', $user->nis) }}"
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
                            value="{{ old('kelas', $user->kelas) }}"
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
                            value="{{ old('no_telepon', $user->no_telepon) }}"
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
                            value="{{ old('alamat', $user->alamat) }}"
                            placeholder="Alamat pengguna"
                        >

                    </div>


                    {{-- PASSWORD BARU --}}

                    <div class="form-group">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password Baru
                        </label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak diubah"
                        >

                        <div
                            style="
                                margin-top:6px;
                                color:#94a3b8;
                                font-size:9.5px;
                            "
                        >
                            Isi hanya jika password ingin diganti.
                        </div>

                    </div>


                    {{-- KONFIRMASI PASSWORD --}}

                    <div class="form-group">

                        <label
                            for="password_confirmation"
                            class="form-label"
                        >
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password baru"
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
                        <span>Simpan Perubahan</span>
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


    {{-- ACCOUNT INFO --}}

    <div
        class="card"
        style="margin-top:20px;"
    >

        <div class="card-body">

            <div
                style="
                    display:flex;
                    align-items:flex-start;
                    gap:12px;
                "
            >

                <div
                    style="
                        width:36px;
                        height:36px;
                        min-width:36px;
                        border-radius:10px;
                        background:#eff6ff;
                        color:#2563eb;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-weight:800;
                    "
                >
                    i
                </div>

                <div>

                    <strong
                        style="
                            display:block;
                            color:#334155;
                            font-size:11px;
                            margin-bottom:5px;
                        "
                    >
                        Informasi Akun
                    </strong>

                    <p
                        style="
                            color:#94a3b8;
                            font-size:10px;
                            line-height:1.7;
                            margin:0;
                        "
                    >
                        Password tidak perlu diisi apabila hanya
                        ingin mengubah data pengguna lainnya.
                        Password lama akan tetap digunakan jika
                        kolom password dikosongkan.
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('styles')

<style>

    select.form-control {
        appearance: auto;
        cursor: pointer;
    }

    .student-field {
        transition: all .2s ease;
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

    }

</style>

@endpush


@push('scripts')

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const role = document.getElementById('role');

        const nisField = document.getElementById('nisField');

        const kelasField = document.getElementById('kelasField');


        function updateStudentFields() {

            if (role.value === 'siswa') {

                nisField.style.display = 'block';

                kelasField.style.display = 'block';

            } else {

                nisField.style.display = 'none';

                kelasField.style.display = 'none';

            }

        }


        role.addEventListener('change', updateStudentFields);

        updateStudentFields();

    });

</script>

@endpush