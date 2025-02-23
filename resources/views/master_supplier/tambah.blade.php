@extends('layout.layout_utama')
@section('title', 'Tambah Supplier')

@section('content')
@section('pages', 'Tambah Supplier')

<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('supplier') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Tambah Supplier -->
    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Supplier</label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" required>
                    @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_telepon" class="form-label">No. Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror">
                    @error('no_telepon')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror"></textarea>
                    @error('alamat')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success btn-mobile">
                    <i class="bi bi-save"></i> Simpan Supplier
                </button>
            </form>
        </div>
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
