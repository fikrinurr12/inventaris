@extends('layout.layout_utama')
@section('title', 'Pengembalian')

@section('content')
@section('pages', 'Pengembalian')
  
<div class="container-fluid py-4">
    <div class="mb-3">
        <a href="{{ route('tambah_pengembalian') }}" class="btn btn-primary btn-md">
            <i class="fas fa-plus-circle"></i> Tambah
        </a>
        <button class="btn btn-secondary" id="btnMenunggu">
            <span id="pending-pengembalian-tabel"></span>
            Menunggu
        </button>
    </div>
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table text-center align-items-center mb-0 table-striped table-bordered" id="tabel_pengembalian">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No Transaksi</th>
                        @hasanyrole('superadmin|admin')
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Peminjam</th>
                        @endhasanyrole
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sisa Pinjam</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keterangan</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kondisi Baik</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kondisi Rusak</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tanggal</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                    </tr>
                </thead>
            </table>            
        </div>
    </div>
</div>  

@push('scripts_js')
    <script>
      $(document).ready(function () {
          
            $.get("{{ route('pengembalian.pending_count') }}", function(data) {
                $('#pending-pengembalian-tabel').text(data.pending_pengembalian);
            });

            var table = $('#tabel_pengembalian').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                scrollY: "1000px", // Tinggi maksimal tabel dengan scroll
                scrollCollapse: true, // Agar scroll tetap muncul meskipun sedikit data
                dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-center"f>>' + 
                    'rt' + 
                    '<"row mt-3 d-flex align-items-center"<"col-md-6"i><"col-md-6 text-end"p>>',
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Opsi pilihan jumlah data
                ajax: "{{ route('pengembalian') }}",
                columns: [
                    { data: 'no_transaksi', name: 'no_transaksi' },
                    @hasanyrole('superadmin|admin')
                    { data: 'user.name', name: 'user.name' },
                    @endhasanyrole
                    { data: 'barang.nama', name: 'barang.nama' },
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
                                    badgeClass = 'badge bg-warning text-dark';
                                } else if (lowerCaseData.includes('dibatalkan')) {
                                    badgeClass = 'badge bg-secondary';
                                }
                            }

                            return `<span class="${badgeClass}">${data}</span>`;
                        }
                    },
                    { data: 'kondisi_baik', name: 'kondisi_baik' },
                    { data: 'kondisi_rusak', name: 'kondisi_rusak' },
                    { data: 'jumlah', name: 'jumlah' },
                    { data: 'tgl_pengembalian', name: 'tgl_pengembalian' },
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

            $('#btnMenunggu').click(function () {
                var columnIndex = table.column('keterangan:name');

                if ($(this).hasClass('btn-success')) {
                    columnIndex.search('').draw();
                    $(this).removeClass('btn-success').addClass('btn-secondary');
                } else {
                    columnIndex.search('Menunggu').draw();
                    $(this).removeClass('btn-secondary').addClass('btn-success');
                }
            });

            var isFiltered = false;

            // Fungsi untuk mendapatkan index kolom berdasarkan teks header
            function getColumnIndexByName(columnName) {
                var index = -1;
                $('#tabel_pengembalian thead th').each(function(i) {
                    if ($(this).text().trim() === columnName) {
                        index = i;
                        return false; // Stop loop
                    }
                });
                return index;
            }

      });

      $(document).ready(function () {
            // Konfirmasi swal sebelum submit form
            $(document).on("submit", "form", function (e) {
                var form = this; 
                e.preventDefault(); 

                let isCancel = $(form).attr("action").includes("cancel");
                let isApprove = $(form).attr("action").includes("approve");

                if (isCancel) {
                    Swal.fire({
                        title: "Apakah Anda yakin membatalkan pengembalian?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, Batalkan!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else if(isApprove) {
                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Anda akan menyetujui pengembalian ini.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, Setujui!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Anda akan menolak pengembalian ini.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, Tolak!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endpush
@endsection
