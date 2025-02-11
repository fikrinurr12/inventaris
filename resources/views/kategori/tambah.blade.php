@extends('layout.layout_utama')
@section('title', 'Tambah Kategori')

@section('content')
@section('pages', 'Tambah Kategori')

<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('kategori') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Tambah Barang -->
    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" required>
                    @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success btn-mobile">
                    <i class="bi bi-save"></i> Simpan Kategori
                </button>
            </form>
        </div>
    </div>

@push('scripts_js')
    <script>
        $(document).ready(function() {
            
            $('.select-form').select2({
                theme: 'bootstrap-5', // Tema Bootstrap 5
            });

    });
    </script>
@endpush

@endsection
