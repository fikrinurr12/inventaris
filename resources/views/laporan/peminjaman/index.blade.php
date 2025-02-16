@extends('...layout.layout_utama')
@section('title', 'Laporan - Peminjaman')
@section('content')
@section('pages', 'Laporan - Peminjaman')

<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0 text-white"><i class="fas fa-filter text-white"></i> Filter Data</h6>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select select-form">
                            <option value="">-- Semua --</option>
                            @foreach($kategoriList as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                        <select name="keterangan" id="keterangan" class="form-select">
                            <option value="">-- Semua --</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal Peminjaman</label>
                        <input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="Pilih rentang tanggal">
                    </div>
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
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Peminjam</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kategori</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tanggal Peminjaman</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sisa Pinjam</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('.select-form').select2({
            theme: 'bootstrap-5',
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
                url: "{{ route('laporan.peminjaman.data') }}",
                data: function(d) {
                    d.tanggal = $('#tanggal').val();
                    d.keterangan = $('#keterangan').val();
                    d.kategori = $('#kategori').val();
                }
            },
            columns: [
                { data: 'no_transaksi', name: 'no_transaksi' },
                { data: 'nama_peminjam', name: 'nama_peminjam' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'kategori', name: 'kategori' },
                { data: 'tgl_peminjaman', name: 'tgl_peminjaman' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'sisa_pinjam', name: 'sisa_pinjam' },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    render: function(data, type, row) {
                        let badgeClass = 'badge bg-light text-dark'; // Default warna abu-abu
                        
                        if (data) {
                            let lowerCaseData = data.toLowerCase(); // Konversi ke lowercase
                            if (lowerCaseData.includes('disetujui')) {
                                badgeClass = 'badge bg-success';
                            } else if (lowerCaseData.includes('ditolak')) {
                                badgeClass = 'badge bg-danger';
                            } else if (lowerCaseData.includes('menunggu')) {
                                badgeClass = 'badge bg-warning text-white';
                            } else if (lowerCaseData.includes('dibatalkan')) {
                                badgeClass = 'badge bg-secondary';
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
        });
    });
</script>

@endsection
