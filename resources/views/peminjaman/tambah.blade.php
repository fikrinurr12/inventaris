@extends('layout.layout_utama')
@section('title', 'Peminjaman')

@section('content')
@section('pages', 'Peminjaman')

<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('peminjaman') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body px-4 pt-0 pb-2 mt-3">
                    <!-- Form Peminjaman -->
                    <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data"> 
                        @csrf

                        <!-- Input Nama Peminjam -->
                        <div class="form-group">
                            @role('user')
                                <input type="hidden" name="id_peminjam" value="{{ $id_peminjam }}" required readonly>
                                <input type="hidden" id="nama_peminjam" name="nama_peminjam" class="form-control" value="{{ $nama_peminjam }}" readonly>
                            @endrole
                            @hasanyrole('superadmin|admin') <!-- Jika tidak, beri pilihan untuk memilih nama peminjam -->
                            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                                <select id="nama_peminjam" name="id_peminjam" class="form-control select-form" required>
                                    <option value="" disabled selected>-- Pilih Nama Peminjam --</option>
                                    @foreach($dataUser as $user) <!-- Daftar semua pengguna yang dapat dipilih -->
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            @endhasanyrole
                            @error('id_peminjam')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Input Barang -->
                        <div class="form-group">
                            <label for="id_barang" class="form-label">Barang</label>
                            <select id="id_barang" name="id_barang" class="form-control select-form" required>
                                <option value="" disabled selected>-- Pilih Barang --</option>
                                @foreach($dataBarang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama }} | (Stok : {{ $barang->stok_tersedia }})</option>
                                @endforeach
                            </select>
                            @error('id_barang')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Jumlah -->
                        <div class="form-group">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" id="jumlah" name="jumlah" class="form-control" required min="1">
                            @error('jumlah')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Tanggal Peminjaman -->
                        <div class="form-group">
                            <label for="tgl_peminjaman" class="form-label">Tanggal Peminjaman</label>
                            <input type="date" id="tgl_peminjaman" name="tgl_peminjaman" class="form-control" required>
                            @error('tgl_peminjaman')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Keterangan -->
                        @hasrole('superadmin')
                        <div class="form-group">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <select id="keterangan" name="keterangan" class="form-control" required>
                                <option value="" disabled selected>-- Keterangan --</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                            </select>
                            @error('keterangan')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        @endrole

                        <div class="text-left">
                            <button type="submit" class="btn btn-success mt-3 btn-mobile">
                                <i class="bi bi-save"></i> Simpan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
