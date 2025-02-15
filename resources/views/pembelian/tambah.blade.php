@extends('layout.layout_utama')
@section('title', 'Pembelian')

@section('content')
@section('pages', 'Pembelian')

<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('pembelian') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body px-4 pt-0 pb-2 mt-3">
                    <!-- Form Pembelian -->
                    <form id="form-pembelian" action="{{ route('pembelian.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input No Invoice -->
                        <div class="form-group">
                            <label for="no_invoice" class="form-label">No Invoice</label>
                            <input type="text" id="no_invoice" name="no_invoice" class="form-control" required min="1">
                            @error('no_invoice')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Barang -->
                        <div class="form-group">
                            <label for="id_barang" class="form-label">Barang</label>
                            <select id="id_barang" name="id_barang" class="form-control select-form" required>
                                <option value="" disabled selected>-- Pilih Barang --</option>
                                @foreach($dataBarang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama }} (Stok : {{ $barang->stok_tersedia }})</option>
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
                    
                        <!-- Input Harga -->
                        <div class="form-group">
                            <label for="harga" class="form-label">Harga</label>
                            <div class="col-12 input-group">
                                <input type="text" id="harga" name="harga" class="form-control" required>
                            </div>
                            @error('harga')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Tanggal -->
                        <div class="form-group">
                            <label for="tanggal" class="form-label">Tanggal Pembelian</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                            @error('tanggal')
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
                            <button type="submit" class="btn btn-success mt-3  btn-mobile">
                                <i class="bi bi-save"></i> Tambah Pembelian
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
                theme: 'bootstrap-5',
            });

            console.log("AutoNumeric initialized");

            // Terapkan AutoNumeric ke input harga
            new AutoNumeric('#harga', {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                currencySymbol: 'Rp ',
                currencySymbolPlacement: 'p', // Ubah 'prefix' menjadi 'p'
                minimumValue: '0'
            });
        });
    </script>
@endpush

@endsection
