@extends('layout.layout_utama')
@section('title','Penyesuaian Stok')

@section('content')
@section('pages','Penyesuaian Stok')

<div class="container-fluid py-4">
    <div class="mb-3">
        <a href="{{ route('tambah_penyesuaian_stok') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="fas fa-plus-circle"></i> Tambah
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table text-center align-items-center mb-0 table-striped table-bordered" id="tabel_penyesuaian_stok">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No Transaksi</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kode Barang</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok Baik</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok Rusak</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok Tersedia</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keterangan</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('scripts_js')
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#tabel_penyesuaian_stok').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
            scrollY: "1000px", // Tinggi maksimal tabel dengan scroll
            scrollCollapse: true, // Agar scroll tetap muncul meskipun sedikit data
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-center"f>>' + 
                 'rt' + 
                 '<"row mt-3 d-flex align-items-center"<"col-md-6"i><"col-md-6 text-end"p>>',
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Opsi pilihan jumlah data
        ajax: "{{ route('penyesuaian_stok') }}",
        columns: [
            { data: 'no_transaksi', name: 'no_transaksi' },
            { data: 'kode_barang', name: 'kode_barang' },
            { data: 'nama_barang', name: 'nama_barang' },
            { data: 'stok_total_baik', name: 'stok_total_baik' },
            { data: 'stok_total_rusak', name: 'stok_total_rusak' },
            { data: 'stok_tersedia', name: 'stok_tersedia' },
            { data: 'keterangan', name: 'keterangan' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).find('td').addClass('text-sm').addClass('text-center');
        },
            initComplete: function() {
                // Tambahkan class form-control pada length dan search
                $('.dataTables_length select').addClass('form-select form-select-sm');
                $('.dataTables_filter input').addClass('form-control form-control-sm');
                /// Menghapus class dt-button agar tidak ada style bawaan
                $('.dt-button').removeClass('dt-button');
            },
            language: {
                lengthMenu: "_MENU_ data per halaman",
                search: "Cari:",
                zeroRecords: "Tidak ada data ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)"
            }
    });
});

</script>
@endpush
@endsection
