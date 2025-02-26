@extends('...layout.layout_utama')
@section('title', 'Laporan - Pembelian')
@section('content')
@section('pages', 'Laporan - Pembelian')

<div class="container-fluid py-4">
    <div>
        <button class="btn btn-primary btn-md btn-mobile" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter"></i> Filter
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table text-center table-striped table-bordered" id="tabel_laporan">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No. Transaksi</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Supplier</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tanggal Transaksi</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No Invoice</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Harga</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title text-white" id="filterModalLabel"><i class="fas fa-filter"></i> Filter Data</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body col-12">
                <form id="filterForm">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal Transaksi</label>
                        <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Pilih rentang tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                        <select name="keterangan" id="keterangan" class="form-select w-100">
                            <option value="">-- Semua --</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="id_supplier" class="form-label fw-semibold">Supplier</label></br>
                        <select name="id_supplier" id="id_supplier" class="form-select select-form" style="width: 100%">
                            <option value="">-- Semua --</option>
                            @foreach($supplierList as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary btn-sm btn-mobile"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select-form').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#filterModal'), // Agar select2 muncul dengan benar dalam modal
        });

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
                url: "{{ route('laporan.pembelian.data') }}",
                data: function(d) {
                    d.tanggal = $('#tanggal').val();
                    d.keterangan = $('#keterangan').val();
                    d.id_supplier = $('#id_supplier').val();
                }
            },
            columns: [
                { data: 'no_transaksi', name: 'no_transaksi' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'nama_supplier', name: 'nama_supplier' },
                { data: 'tgl_transaksi', name: 'tgl_transaksi' },
                { data: 'no_invoice', name: 'no_invoice' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'harga', name: 'harga' },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    render: function(data, type, row) {
                        let badgeClass = 'badge bg-light text-dark'; // Default warna abu-abu
                        
                        if (data) {
                            let lowerCaseData = data.toLowerCase(); // Konversi ke lowercase
                            if (lowerCaseData.includes('dibatalkan')) {
                                badgeClass = 'badge bg-secondary';
                            } else{
                                badgeClass = 'badge bg-success';
                            }
                        }

                        return `<span class="${badgeClass}">${data}</span>`;
                    }
                }
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
            $('#filterModal').modal('hide'); // Tutup modal setelah filter diterapkan
        });
    });
</script>

@endsection
