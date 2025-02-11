@extends('layout.layout_utama')
@section('title', 'Edit Kategori')

@section('content')
@section('pages', 'Edit Kategori')

<div class="container-fluid py-4">
    <a href="{{ route('kategori') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <form action="{{ route('edit_kategori.store', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kategori</label>
                    <input type="text" id="nama" name="nama" class="form-control" value="{{ $kategori->nama }}" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
