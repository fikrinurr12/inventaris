@extends('layout.layout_utama')
@section('title','Pembelian')

@section('content')
@section('pages','Pembelian')

<div class="container-fluid py-4">
  <div class="mb-3">
      <a href="{{ route('tambah_pembelian') }}" class="btn btn-primary btn-md btn-mobile">
          <i class="fas fa-plus-circle"></i> Tambah
      </a>
  </div>
  <div class="card shadow-sm">
      <div class="card-body table-responsive">
        <table class="table text-center align-items-center mb-0 table-striped table-bordered" id="tabel_master_barang">
          <thead>
              <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No Transaksi</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Tanggal</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No Invoice</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kode Barang</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Harga</th>
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
    $(document).ready(function() {
        $('#tabel_master_barang').DataTable({
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
            ajax: "{{ route('pembelian') }}",
            columns: [
                { data: 'no_transaksi', name: 'no_transaksi' },
                { data: 'tgl_transaksi', name: 'tgl_transaksi' },
                { data: 'no_invoice', name: 'no_invoice' },
                { data: 'kode_barang', name: 'kode_barang' },
                { data: 'nama_barang', name: 'nama_barang' },
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
    });

      $(document).on("submit", "form", function (e) {
            var form = this; 
            e.preventDefault(); 

            let isCancel = $(form).attr("action").includes("cancel");

            if (isCancel) {
                Swal.fire({
                    title: "Apakah Anda yakin membatalkan pembelian?",
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
            } 
        });
    </script>
@endpush
@endsection