@extends('layout.layout_utama')
@section('title','Master Barang')

@section('content')
@section('pages','Master Barang')

<div class="container-fluid py-4">
  <div class="mb-3">
      <a href="{{ route('tambah_barang') }}" class="btn btn-primary btn-md btn-mobile">
          <i class="fas fa-plus-circle"></i> Tambah
      </a>
  </div>
  <div class="card shadow-sm">
      <div class="card-body table-responsive">
        <table class="table text-center align-items-center mb-0 table-striped table-bordered" id="tabel_master_barang">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kode</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Merk</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kategori</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keterangan</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                </tr>
            </thead>
        </table>
      </div>
  </div>
</div>

@push('scripts_js')
<script>
$(document).ready( function () {
    $('#tabel_master_barang').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
            scrollY: "1000px", // Tinggi maksimal tabel dengan scroll
            scrollCollapse: true, // Agar scroll tetap muncul meskipun sedikit data
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-center"f>>' + 
                 'rt' + 
                 '<"row mt-3 d-flex align-items-center"<"col-md-6"i><"col-md-6 text-end"p>>',
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Opsi pilihan jumlah data
        ajax: "{{ route('master_barang') }}",
        columns: [
            { data: 'kode', name: 'kode', className: 'text-sm' },
            { data: 'nama', name: 'nama', className: 'text-sm' },
            { data: 'merk', name: 'merk', className: 'text-sm' },
            { data: 'kategori', name: 'kategori', className: 'text-sm' },
            { data: 'keterangan', name: 'keterangan', className: 'text-sm' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-sm' }
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

    // SweetAlert untuk tombol hapus
    $(document).on("submit", ".form-hapus", function (e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // SweetAlert untuk tombol "Lihat"
    $(document).on("click", ".btn-lihat-keterangan", function () {
        var nama = $(this).data("nama");
        var harga = $(this).data("harga");
        var spesifikasi = $(this).data("spesifikasi");
        var stok_baik = $(this).data("stok_baik");
        var stok_rusak = $(this).data("stok_rusak");
        var stok_tersedia = $(this).data("stok_tersedia");
        var foto = $(this).data("foto");

        Swal.fire({
            html: `
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <div style="width: 100%; max-width: 150px; margin: 0 auto;">
                        <img src="${foto}" alt="Foto Barang" class="rounded w-100" style="object-fit: cover; aspect-ratio: 1;">
                    </div>
                    <div class="text-start flex-grow-1">
                        <h6 class="mb-2 fw-semibold text-sm">${nama}</h6>
                        <div class="mb-2">
                            <div class="text-muted small text-sm">Harga:</div>
                            <div class="fw-medium text-sm">Rp ${parseInt(harga).toLocaleString('id-ID')}</div>
                        </div>
                        <div class="mb-2">
                            <div class="text-muted small text-sm">Spesifikasi:</div>
                            <div class="fw-medium text-sm">${spesifikasi}</div>
                        </div>
                        <div>
                            <div class="text-muted small mb-1 text-sm">Stok Barang:</div>
                            <div class="d-flex flex-wrap gap-1">
                                <span class="badge bg-success badge-sm">Baik: ${stok_baik}</span>
                                <span class="badge bg-danger badge-sm">Rusak: ${stok_rusak}</span>
                                <span class="badge bg-primary badge-sm">Tersedia: ${stok_tersedia}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `,
            showConfirmButton: true,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#f5365c',
            background: '#fff',
            width: 'auto',
            maxWidth: '500px',
            padding: '1.5rem',
            customClass: {
                popup: 'rounded-3',
                container: 'p-0',
                confirmButton: 'btn btn-secondary'
            }
        });
    });
});
</script>
@endpush

@endsection