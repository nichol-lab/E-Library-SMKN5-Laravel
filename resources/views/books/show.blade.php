@extends('layouts.app')

@section('title', 'Detail Buku')
@section('header', 'Detail Buku')

@section('content')

<div class="page-heading">
    <h1>Detail Buku</h1>
    <p>Informasi lengkap buku.</p>
</div>

<div class="card">

    <div class="card-header">
        <h3>{{ $book->title }}</h3>

        <a href="{{ route('books.index') }}"
           class="btn btn-light">
            Kembali
        </a>
    </div>

    <div class="card-body">

        <ul class="info-list">

            <li>
                <span>Judul</span>
                <strong>{{ $book->title }}</strong>
            </li>

            <li>
                <span>ISBN</span>
                <strong>{{ $book->isbn ?: '-' }}</strong>
            </li>

            <li>
                <span>Kategori</span>
                <strong>{{ $book->category->name ?? '-' }}</strong>
            </li>

            <li>
                <span>Penulis</span>
                <strong>{{ $book->author }}</strong>
            </li>

            <li>
                <span>Penerbit</span>
                <strong>{{ $book->publisher ?: '-' }}</strong>
            </li>

            <li>
                <span>Tahun</span>
                <strong>{{ $book->year ?: '-' }}</strong>
            </li>

            <li>
                <span>Total Stok</span>
                <strong>{{ $book->stock }}</strong>
            </li>

            <li>
                <span>Stok Tersedia</span>
                <strong>{{ $book->available_stock }}</strong>
            </li>

            <li>
                <span>Lokasi Rak</span>
                <strong>{{ $book->shelf_location ?: '-' }}</strong>
            </li>

        </ul>

    </div>

</div>

@endsection