@extends('layout.layout_utama')
@section('title','Master User')

@section('content')
@section('pages','Master User')

@push('scripts_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
@endpush

<div class="container-fluid py-4">
  <div class="mb-3">
    <a href="{{ route('tambah_user') }}" class="btn btn-primary btn-md btn-mobile">
        <i class="fas fa-plus-circle"></i> Tambah
    </a>
</div>
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 shadow-sm">
        <div class="card-body px-3 pt-3 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 text-center align-middle text-center table-striped table-bordered" id="tabel_master_user">
              <thead>
                  <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Role</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                  </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts_js')
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
            $('#tabel_master_user').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            scrollY: "1000px", // Tinggi maksimal tabel dengan scroll
            scrollCollapse: true, // Agar scroll tetap muncul meskipun sedikit data
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-center"f>>' + 
                 'rt' + 
                 '<"row mt-3 d-flex align-items-center"<"col-md-6"i><"col-md-6 text-end"p>>',
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Opsi pilihan jumlah data
            ajax: "{{ route('data_pengguna') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
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
      } );
    </script>
@endpush

<script>
  // SweetAlert untuk konfirmasi hapus
  $(document).on("submit", "form", function (e) {
        var form = this; // Simpan referensi form
        e.preventDefault(); // Mencegah submit form langsung

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
                form.submit(); // Submit form jika user menekan "Ya, hapus!"
            }
        });
    });

    // SweetAlert untuk tombol "Lihat"
    $(document).on("click", ".btn-lihat-keterangan", function () {
        var keterangan = $(this).data("keterangan");
        var harga = $(this).data("harga");
        var stok = $(this).data("stok");
        var foto = $(this).data("foto");

        Swal.fire({
            title: "Informasi Barang",
            html: `
                <img src="${foto}" alt="Foto Barang" style="width: 100%; max-width: 100px;"><br>
                <b>Keterangan:</b> ${keterangan}<br>
                <b>Harga:</b> ${harga}<br>
                <b>Stok:</b> ${stok}<br>
            `,
            confirmButtonText: "Tutup",
        });
    });
</script>

</main>

@endsection