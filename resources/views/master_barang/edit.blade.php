@extends('layout.layout_utama')
@section('title','Master Barang')

@section('content')
@section('pages','Edit Barang')
<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('master_barang') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body px-4 pt-0 pb-2 mt-3">
                    <form action="{{ route('edit_barang.store', $barang->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Metode PUT untuk update data -->
                    
                        <!-- Input Kode -->
                        {{-- <div class="form-group mb-3">
                            <label for="kode" class="form-label">Kode</label> --}}
                            <input type="hidden" id="kode" name="kode" class="form-control @error('kode') is-invalid @enderror" required value="{{ $barang->kode }}">
                            {{-- @error('kode')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    
                        <!-- Input Foto -->
                        <div class="form-group mb-3">
                            <label for="foto" class="form-label">Foto</label><br>
                            @if ($barang->foto)
                                <img src="{{ asset($barang->foto) }}" alt="Foto Barang" class="img-thumbnail mb-2" width="150">
                            @endif
                            <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror">
                            <small class="text-muted">*Kosongkan jika tidak ingin mengganti foto.</small>
                            @error('foto')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Nama Barang -->
                        <div class="form-group mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" required value="{{ $barang->nama }}">
                            @error('nama')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Merk -->
                        <div class="form-group mb-3">
                            <label for="merk" class="form-label">Merk</label>
                            <input type="text" id="merk" name="merk" class="form-control @error('merk') is-invalid @enderror" required value="{{ $barang->merk }}">
                            @error('merk')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga Terakhir -->
                        <div class="form-group mb-3">
                            <label for="none" class="form-label">Harga Terakhir</label>
                            <input type="text" class="form-control" disabled value="Rp {{ number_format($barang->harga_terakhir, 0, ',', '.') }}">
                        </div>
                    
                        <!-- Dropdown Kategori -->
                        <div class="form-group mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror select-form" required>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                            <button type="button" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                                Tambah Kategori
                            </button>
                        </div>
                    
                        <!-- Input Spesifikasi -->
                        <div class="form-group mb-3">
                            <label for="spesifikasi" class="form-label">Spesifikasi</label>
                            <textarea id="spesifikasi" name="spesifikasi" class="form-control @error('spesifikasi') is-invalid @enderror">{{ $barang->spesifikasi }}"</textarea>
                            @error('spesifikasi')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Keterangan -->
                        <div class="form-group mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ $barang->keterangan }}">
                            @error('keterangan')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Harga Terakhir -->
                                <input type="hidden" id="harga_terakhir" name="harga_terakhir" class="form-control @error('harga_terakhir') is-invalid @enderror" required value="{{ $barang->harga_terakhir }}">
                       
                    
                        {{-- <!-- Input Stok -->
                        <div class="form-group mb-3">
                            <label for="stok_total_baik" class="form-label">Stok (Baik)</label>
                            <input type="text" id="stok_total_baik" name="stok_total_baik" class="form-control @error('stok_total_baik') is-invalid @enderror" required value="{{ $barang->stok_total_baik }}">
                            @error('stok_total_baik')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="stok_total_rusak" class="form-label">Stok (Rusak)</label>
                            <input type="text" id="stok_total_rusak" name="stok_total_rusak" class="form-control @error('stok_total_rusak') is-invalid @enderror" required value="{{ $barang->stok_total_rusak }}">
                            @error('stok_total_rusak')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="stok_tersedia" class="form-label">Stok (Tersedia)</label>
                            <input type="text" id="stok_tersedia" name="stok_tersedia" class="form-control @error('stok_tersedia') is-invalid @enderror" required value="{{ $barang->stok_tersedia }}">
                            @error('stok_tersedia')
                                <div class="text-danger text-sm">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    
                        <!-- Tombol Simpan -->
                        <div class="text-left">
                            <button type="submit" class="btn btn-success mt-3 btn-mobile">
                                <i class="bi bi-save"></i> Update Barang
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="tambahKategoriModalLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-kategori" action="{{ route('proses_tambah_kategori') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="kategori_nama" class="form-label">Nama Kategori</label>
                            <input type="text" id="kategori_nama" name="nama" class="form-control" placeholder="Masukkan nama kategori" required>
                        </div>
                        <div class="text-left">
                            <button type="submit" class="btn btn-success mt-3 btn-mobile">
                                <i class="bi bi-save"></i> Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts_js')
<!-- Tambahkan script untuk autoNumeric dan format stok -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var hargaInput = document.getElementById("harga_terakhir");
        hargaInput.addEventListener("input", function (e) {
            // Hilangkan karakter non-angka
            let value = this.value.replace(/\D/g, "");
            // Format ke Rupiah
            this.value = formatRupiah(value);
        });
        function formatRupiah(angka) {
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
</script>
<script>
    $(document).ready(function () {
        // Inisialisasi Select2 untuk dropdown kategori
        $('.select-form').select2({ theme: 'bootstrap-5' });

        // Tangani submit form kategori via AJAX
        $('#form-tambah-kategori').on('submit', function (e) {
            e.preventDefault(); // Mencegah reload halaman

            let formData = $(this).serialize(); // Ambil data form

            $.ajax({
                url: "{{ route('proses_tambah_kategori') }}", // URL endpoint
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        // Tambahkan kategori baru ke dropdown
                        $('#kategori_id').append(new Option(response.nama, response.id, true, true)).trigger('change');

                        // Reset form tambah kategori
                        $('#form-tambah-kategori')[0].reset();

                        // Tutup modal
                        $('#tambahKategoriModal').modal('hide');

                        // Tampilkan SweetAlert sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Kategori Ditambahkan!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "Terjadi kesalahan.";
                    
                    // Tampilkan SweetAlert error
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage,
                    });
                }
            });
        });
    });
</script>
@endpush

@endsection