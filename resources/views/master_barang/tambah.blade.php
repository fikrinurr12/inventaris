@extends('layout.layout_utama')
@section('title', 'Master Barang')

@section('content')
@section('pages', 'Tambah Barang')

<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('master_barang') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Tambah Barang -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tambah_barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            
                {{-- <!-- Input Kode -->
                <div class="form-group mb-3">
                    <label for="kode" class="form-label">Kode Barang</label>
                    <input type="text" id="kode" name="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Masukkan kode barang" required>
                    @error('kode')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div> --}}
            
                <!-- Input Foto -->
                <div class="form-group mb-3">
                    <label for="foto" class="form-label">Foto Barang</label>
                    <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror" required>
                    @error('foto')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Input Nama Barang -->
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Barang</label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama barang" required>
                    @error('nama')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Input Merk -->
                <div class="form-group mb-3">
                    <label for="merk" class="form-label">Merk Barang</label>
                    <input type="text" id="merk" name="merk" class="form-control @error('merk') is-invalid @enderror" placeholder="Masukkan merk barang" required>
                    @error('merk')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Dropdown Kategori -->
                <div class="form-group mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <div>
                        <select id="kategori_id" name="kategori_id" class="select-form form-control @error('kategori_id') is-invalid @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="text-danger text-sm">{{ $message }}</div>
                        @enderror
                        <button type="button" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                            Tambah Kategori
                        </button>
                    </div>
                </div>
            
                <!-- Input Spesifikasi -->
                <div class="form-group mb-3">
                    <label for="spesifikasi" class="form-label">Spesifikasi Barang</label>
                    <textarea id="spesifikasi" name="spesifikasi" class="form-control @error('spesifikasi') is-invalid @enderror" rows="3" placeholder="Masukkan spesifikasi barang" required></textarea>
                    @error('spesifikasi')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Input Keterangan -->
                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" required>
                    @error('keterangan')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" id="harga_terakhir" name="harga_terakhir" value="0">
                <input type="hidden" id="stok_total_baik" name="stok_total_baik" value="0">
                <input type="hidden" id="stok_total_rusak" name="stok_total_rusak" value="0">
                <input type="hidden" id="stok_tersedia" name="stok_tersedia" value="0">
            
                <!-- Tombol Simpan -->
                <div class="text-left">
                    <button type="submit" class="btn btn-success mt-3 btn-mobile">
                        <i class="bi bi-save"></i> Simpan Barang
                    </button>
                </div>
            </form>            
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="tambahKategoriModalLabel">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-kategori" action="{{ route('proses_tambah_kategori') }}" method="POST" enctype="multipart/form-data">
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
