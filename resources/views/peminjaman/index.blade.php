@extends('layout.layout_utama')
@section('title','Peminjaman')

@section('content')
@section('pages','Peminjaman')

<div class="container-fluid py-4">
  <div class="mb-3">
      <a href="{{ route('tambah_peminjaman') }}" class="btn btn-primary btn-md">
          <i class="fas fa-plus-circle"></i> Tambah
      </a>
      <button class="btn btn-secondary" id="btnMenunggu">
        <span id="pending-peminjaman-tabel"></span>
        <span id="pending-peminjaman-tabel-user"></span>
        Menunggu
      </button>
  </div>
  <div class="card shadow-sm">
      <div class="card-body table-responsive">
        <table class="table text-center align-items-center mb-0 table-striped table-bordered" id="tabel_peminjaman">
          <thead>
              <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No Transaksi</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tanggal</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Peminjam</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sisa Pinjam</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keterangan</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
              </tr>
          </thead>
        </table>
      </div>
  </div>
</div>

@push('scripts_js')
    @role('superadmin')
    <script>
        $(document).ready(function () {
            $.get("{{ route('peminjaman.pending_count') }}", function(data) {
                $('#pending-peminjaman-tabel').text(data.pending_peminjaman);
            });
        });
    </script>
    @endrole
    @hasanyrole('admin|user')
    <script>
        $(document).ready(function () {
            $.get("{{ route('peminjaman.pending_count') }}", function(data) {
                $('#pending-peminjaman-tabel-user').text(data.pending_peminjaman_user);
            });
        });
    </script>
    @endhasanyrole
    <script>
      $(document).ready(function () {

        var table = $('#tabel_peminjaman').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        stateSave: true,
            scrollY: "1000px", // Tinggi maksimal tabel dengan scroll
            scrollCollapse: true, // Agar scroll tetap muncul meskipun sedikit data
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-center"f>>' + 
                 'rt' + 
                 '<"row mt-3 d-flex align-items-center"<"col-md-6"i><"col-md-6 text-end"p>>',
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Opsi pilihan jumlah data
        ajax: "{{ route('peminjaman') }}",
        columns: [
            { data: 'no_transaksi', name: 'no_transaksi' },
            { data: 'tgl_peminjaman', name: 'tgl_peminjaman' },
            { data: 'nama_peminjam', name: 'user.name' },
            { data: 'nama_barang', name: 'barang.nama' },
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
                            badgeClass = 'badge bg-warning text-dark';
                        } else if (lowerCaseData.includes('dibatalkan')) {
                            badgeClass = 'badge bg-secondary';
                        }
                    }

                    return `<span class="${badgeClass}">${data}</span>`;
                }
            },
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
        var isFiltered = false;

        // Fungsi untuk mendapatkan index kolom berdasarkan teks header
        function getColumnIndexByName(columnName) {
            var index = -1;
            $('#tabel_peminjaman thead th').each(function(i) {
                if ($(this).text().trim() === columnName) {
                    index = i;
                    return false; // Stop loop
                }
            });
            return index;
        }

        $('#btnMenunggu').click(function () {
            // Cari index kolom "Keterangan"
            var columnIndex = getColumnIndexByName('Keterangan');

            if (columnIndex === -1) {
                alert('Kolom "Keterangan" tidak ditemukan!');
                return;
            }

            if (isFiltered) {
                // Reset filter
                table.column(columnIndex).search("").draw();
                $(this).removeClass("btn-success").addClass("btn-secondary");
            } else {
                // Terapkan filter "Menunggu"
                table.column(columnIndex).search("Menunggu").draw();
                $(this).removeClass("btn-secondary").addClass("btn-success");
            }
            isFiltered = !isFiltered;
        });

        // Konfirmasi swal sebelum submit form
        $(document).on("submit", "form", function (e) {
            var form = this; 
            e.preventDefault(); 

            let isCancel = $(form).attr("action").includes("cancel");
            let isApprove = $(form).attr("action").includes("approve");

            if (isCancel) {
                Swal.fire({
                    title: "Apakah Anda yakin membatalkan peminjaman?",
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
                    text: "Anda akan menyetujui peminjaman ini.",
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
                    text: "Anda akan menolak peminjaman ini.",
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
