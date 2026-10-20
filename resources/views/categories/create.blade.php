@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('header', 'Tambah Kategori')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="welcome">

        <div>
            <h1 class="welcome-title">
                Tambah Kategori
            </h1>

            <p class="welcome-description">
                Tambahkan kategori baru untuk mengelompokkan koleksi
                buku di E-Library SMK Negeri 5 Surakarta.
            </p>
        </div>

        <a
            href="{{ route('categories.index') }}"
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
                    Informasi Kategori
                </div>

                <div class="card-subtitle">
                    Isi informasi kategori dengan lengkap.
                </div>
            </div>

            <span class="badge badge-approved">
                Kategori
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
                action="{{ route('categories.store') }}"
                method="POST"
            >

                @csrf


                <div class="form-grid">


                    {{-- NAMA KATEGORI --}}

                    <div class="form-group full">

                        <label
                            for="name"
                            class="form-label"
                        >
                            Nama Kategori
                            <span style="color:#dc2626;">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Pemrograman"
                            required
                            autofocus
                        >

                        <div
                            style="
                                margin-top:6px;
                                color:#94a3b8;
                                font-size:9.5px;
                            "
                        >
                            Gunakan nama kategori yang singkat dan
                            mudah dipahami.
                        </div>

                    </div>


                    {{-- DESKRIPSI --}}

                    <div class="form-group full">

                        <label
                            for="description"
                            class="form-label"
                        >
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            placeholder="Masukkan deskripsi singkat mengenai kategori..."
                        >{{ old('description') }}</textarea>

                    </div>

                </div>


                {{-- FORM ACTION --}}

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <span>✓</span>
                        <span>Simpan Kategori</span>
                    </button>

                    <a
                        href="{{ route('categories.index') }}"
                        class="btn btn-light"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- INFO CARD --}}
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
                            margin-bottom:4px;
                        "
                    >
                        Contoh Kategori
                    </strong>

                    <p
                        style="
                            color:#94a3b8;
                            font-size:10px;
                            line-height:1.7;
                        "
                    >
                        Contoh kategori yang dapat digunakan:
                        Pemrograman, Teknologi, Fiksi, Pendidikan,
                        Sejarah, Agama, Bahasa, dan kategori lainnya
                        sesuai koleksi perpustakaan.
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('styles')

<style>

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