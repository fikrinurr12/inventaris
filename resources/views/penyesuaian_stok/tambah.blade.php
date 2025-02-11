@extends('layout.layout_utama')
@section('title', 'Penyesuaian Stok')

@section('content')
@section('pages', 'Penyesuaian Stok')

<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('penyesuaian_stok') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body px-4 pt-0 pb-2 mt-3">
                    <!-- Form Pembelian -->
                    <form id="form-pembelian" action="{{ route('penyesuaian_stok.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    
                        <!-- Input Barang -->
                        <div class="form-group">
                            <label for="id_barang" class="form-label">Barang</label>
                            <select id="id_barang" name="id_barang" class="form-control select-form" required>
                                <option value="" disabled selected>-- Pilih Barang --</option>
                                @foreach($dataBarang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama }} | (Stok Baik : {{ $barang->stok_total_baik }}) | (Stok Rusak : {{ $barang->stok_total_rusak }})</option>
                                @endforeach
                            </select>
                            @error('id_barang')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilih Penyesuaian -->
                        <div class="form-group">
                            <label for="penyesuaian" class="form-label">Penyesuaian</label>
                            <select id="penyesuaian" name="penyesuaian" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Penyesuaian --</option>
                                    <option value="penambahan_stok_baik">Penambahan Stok Baik</option>
                                    <option value="pengurangan_stok_baik">Pengurangan Stok Baik</option>
                                    <option value="penambahan_stok_rusak">Penambahan Stok Rusak</option>
                                    <option value="pengurangan_stok_rusak">Pengurangan Stok Rusak</option>
                            </select>
                            @error('penyesuaian')
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
                    
                        <!-- Input Keterangan -->
                        <div class="form-group">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control">
                            @error('keterangan')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="text-left">
                            <button type="submit" class="btn btn-success mt-3 btn-mobile">
                                <i class="bi bi-save"></i> Tambah Penyesuaian
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Pencarian Barang -->
@push('scripts_js')
    <script>
        $(document).ready(function() {
            $('.select-form').select2({
                theme: 'bootstrap-5', // Tema Bootstrap 5
            });
        });
        

        // document.addEventListener("DOMContentLoaded", function () {
        //     var hargaInput = document.getElementById("harga");

        //     hargaInput.addEventListener("input", function (e) {
        //         // Hilangkan karakter non-angka
        //         let value = this.value.replace(/\D/g, "");

        //         // Format ke Rupiah
        //         this.value = formatRupiah(value);
        //     });

        //     function formatRupiah(angka) {
        //         return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        //     }

        // });

        const kodeBarangInput = document.getElementById('kode_barang');

        kodeBarangInput.addEventListener('change', function() {
            const kodeBarang = kodeBarangInput.value;

            // Jika tidak ada barang yang dipilih, beri notifikasi
            if (kodeBarang === "") {
                alert("Silahkan Tambah barang terlebih dahulu!");
            }
        });
    </script>
@endpush
@endsection
