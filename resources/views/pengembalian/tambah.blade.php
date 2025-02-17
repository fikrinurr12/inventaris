@extends('layout.layout_utama')
@section('title', 'Pengembalian')

@section('content')
@section('pages', 'Pengembalian')

<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('pengembalian') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body px-4 pt-0 pb-2 mt-3">
                    <!-- Form Peminjaman -->
                    <form action="{{ route('pengembalian.store') }}" method="POST" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                    
                        <!-- Input Nama Peminjam -->
                        <div class="form-group">
                            @role('user')
                                <input type="hidden" name="id_peminjam" value="{{ $id_peminjam }}" required readonly>
                                <input type="hidden" id="nama_peminjam" name="nama_peminjam" class="form-control" value="{{ $nama_peminjam }}" readonly>
                            @endrole
                    
                            @hasanyrole('superadmin|admin')
                            <div class="form-group">
                                <label for="id_peminjam" class="form-label">Nama Peminjam</label>
                                <select id="id_peminjam" name="id_peminjam" class="form-control select-form" required>
                                    <option value="" disabled selected>-- Pilih Nama Peminjam --</option>
                                    @foreach($dataPeminjaman as $peminjam)
                                        <option value="{{ $peminjam->user->id }}">{{ $peminjam->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('id_peminjam')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            @endhasanyrole
                        </div>

                        <input type="hidden" name="no_transaksi" id="no_transaksi">
                    
                        <!-- Input Barang -->
                        <div class="form-group">
                            <label for="id_barang" class="form-label">Barang Pinjaman</label>
                            <select id="id_barang" name="id_barang" class="form-control select-form" required>
                                <option value="" disabled selected>-- Pilih Barang --</option>
                            </select>
                            @error('id_barang')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Kondisi Baik -->
                        <div class="form-group">
                            <label for="kondisi_baik" class="form-label">Kondisi Baik</label>
                            <input type="number" id="kondisi_baik" name="kondisi_baik" class="form-control" required value="0">
                            <span class="text-sm">*Beri angka 0 Jika Tidak Ada</span>
                            @error('kondisi_baik')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Kondisi Rusak -->
                        <div class="form-group">
                            <label for="kondisi_rusak" class="form-label">Kondisi Rusak</label>
                            <input type="number" id="kondisi_rusak" name="kondisi_rusak" class="form-control" required value="0">
                            <span class="text-sm">*Beri angka 0 Jika Tidak Ada</span>
                            @error('kondisi_rusak')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Tanggal Pengembalian -->
                        <div class="form-group">
                            <label for="tgl_pengembalian" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" id="tgl_pengembalian" name="tgl_pengembalian" class="form-control" required>
                            @error('tgl_pengembalian')
                                <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Input Keterangan (hanya superadmin) -->
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
                        @endhasrole
                    
                        <!-- Tombol Simpan -->
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
        $('.select-form').select2({ theme: 'bootstrap-5' });

        let barangSelect = $('#id_barang'); 
        let userSelect = $('#id_peminjam');
        let noTransaksiInput = $('#no_transaksi');

        barangSelect.prop('disabled', true);

        function fetchBarang(userId) {
            if (!userId) return;

            barangSelect.prop('disabled', true).html('<option value="" disabled selected>Loading...</option>');

            let url = `{{ route('get.barang.peminjaman', ':id') }}`.replace(':id', userId);

            $.get(url, function(response) {
                barangSelect.empty().append('<option value="" disabled selected>-- Pilih Barang --</option>');

                if (response.status === 'success' && response.data.length > 0) {
                    $.each(response.data, function(index, item) {
                        barangSelect.append(
                            `<option value="${item.id_barang}" data-transaksi="${item.no_transaksi}">
                                ${item.no_transaksi} | ${item.nama_barang} | (Sisa Pinjam: ${item.sisa_pinjam}) | Tanggal: ${item.tgl_peminjaman}
                            </option>`
                        );
                    });
                    barangSelect.prop('disabled', false);
                } else {
                    barangSelect.append('<option value="" disabled>Tidak ada barang tersedia</option>').prop('disabled', true);
                }
            }).fail(function() {
                alert('Gagal mengambil data barang. Silakan coba lagi.');
                barangSelect.html('<option value="" disabled>Tidak dapat mengambil data</option>').prop('disabled', true);
            });
        }

        @role('user')
        fetchBarang($('input[name="id_peminjam"]').val());
        @endrole

        barangSelect.on('change', function() {
            let selectedOption = $(this).find(':selected');
            noTransaksiInput.val(selectedOption.data('transaksi'));
        });

        userSelect.on('change', function() {
            fetchBarang($(this).val());
        });
    });
</script>
@endpush

@endsection