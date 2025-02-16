@extends('...layout.layout_utama')
@section('title', 'Laporan - Penyesuaian Stok')
@section('content')
@section('pages', 'Laporan - Penyesuaian Stok')

<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0 text-white"><i class="fas fa-filter text-white"></i> Filter Data</h6>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-12">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal Transaksi</label>
                        <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Pilih rentang tanggal">
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-12 text-md-start text-center">
                        <button type="submit" class="btn btn-primary btn-sm px-4 py-2 mt-2 shadow">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                    </div>
                </div>                                      
            </form>
        </div>
    </div>    

    <div class="card mt-4 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table text-center table-striped table-bordered" id="tabel_laporan">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No. Transaksi</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tanggal Dibuat</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok Baik</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok Rusak</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok Tersedia</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Inisialisasi Date Range Picker
        $('#tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('#tanggal').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('#tanggal').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        // Load DataTable
        var table = $('#tabel_laporan').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            scrollY: "1000px", // Tinggi maksimal tabel dengan scroll
            scrollCollapse: true, // Agar scroll tetap muncul meskipun sedikit data
            dom: '<"row mb-3"<"col-md-12 text-end"B>>' + 
                 '<"row mb-3"<"col-md-6"l><"col-md-6 text-center"f>>' + 
                 'rt' + 
                 '<"row mt-3 d-flex align-items-center"<"col-md-6"i><"col-md-6 text-end"p>>',
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Opsi pilihan jumlah data
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i>',
                    className: 'btn btn-light btn-sm square-btn'
                },
                {
                    extend: 'csv',
                    text: '<i class="fas fa-file-csv"></i>',
                    className: 'btn btn-success btn-sm square-btn'
                },
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i>',
                    className: 'btn btn-success btn-sm square-btn'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i>',
                    className: 'btn btn-danger btn-sm square-btn'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    className: 'btn btn-primary btn-sm square-btn'
                }
            ],
            ajax: {
                url: "{{ route('laporan.penyesuaian_stok.data') }}",
                data: function(d) {
                    d.tanggal = $('#tanggal').val();
                    d.keterangan = $('#keterangan').val();
                }
            },
            columns: [
                { data: 'no_transaksi', name: 'no_transaksi' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'created_at', name: 'created_at' },
                { data: 'stok_total_baik', name: 'stok_total_baik' },
                { data: 'stok_total_rusak', name: 'stok_total_rusak' },
                { data: 'stok_tersedia', name: 'stok_tersedia' },
                { data: 'keterangan', name: 'keterangan' }
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

        // Event ketika filter di-submit
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            table.ajax.reload();
        });
    });
</script>

@endsection
