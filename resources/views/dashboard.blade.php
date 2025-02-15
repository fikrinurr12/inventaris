@extends('layout.layout_utama')
@section('title','Dashboard')

@push('scripts_css')
    <style>
      .custom-icon-dashboard{
        width: 55px; 
        height: 55px;
      }
    </style>
@endpush

@section('content')
@section('pages', 'Dashboard')
    <div class="container-fluid py-4">
      <div class="row">
        @hasanyrole('superadmin|admin')
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-2">
            <div class="card mb-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Barang</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalProduk }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end d-flex align-items-center justify-content-center">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle custom-icon-dashboard">
                                <i class="bi bi-box text-lg opacity-10" aria-hidden="true" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-2">
            <div class="card mb-3">
                <div class="card-body p-3 shadow-sm">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Pengguna</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalUser }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end d-flex align-items-center justify-content-center">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle custom-icon-dashboard">
                                <i class="bi bi-person-circle text-lg opacity-10" aria-hidden="true" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-2">
            <div class="card mb-3">
                <div class="card-body p-3 shadow-sm">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Barang Rusak</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalRusak }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end d-flex align-items-center justify-content-center">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle custom-icon-dashboard">
                                <i class="bi bi-x-circle text-lg opacity-10" aria-hidden="true" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-sm-6">
            <div class="card mb-3">
                <div class="card-body p-3 shadow-sm">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Pinjaman</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalPeminjaman }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end d-flex align-items-center justify-content-center">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle custom-icon-dashboard">
                                <i class="bi bi-cart text-lg opacity-10" aria-hidden="true" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endhasanyrole
        @role('user')

        <div class="col-xl-4 col-sm-6">
          <div class="card mb-3">
              <div class="card-body p-3 shadow-sm">
                  <div class="row">
                      <div class="col-8">
                          <div class="numbers">
                              <p class="text-sm mb-0 text-uppercase font-weight-bold">Pinjaman</p>
                              <h5 class="font-weight-bolder">
                                  {{ $totalPinjamanUser }}
                              </h5>
                          </div>
                      </div>
                      <div class="col-4 text-end d-flex align-items-center justify-content-center">
                          <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle custom-icon-dashboard">
                              <i class="bi bi-archive text-lg opacity-10" aria-hidden="true" style="font-size: 2rem;"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>

        <div class="col-xl-4 col-sm-6">
          <div class="card mb-3">
              <div class="card-body p-3 shadow-sm">
                  <div class="row">
                      <div class="col-8">
                          <div class="numbers">
                              <p class="text-sm mb-0 text-uppercase font-weight-bold">Sisa Pinjaman</p>
                              <h5 class="font-weight-bolder">
                                  {{ $totalSisaPinjamanUser }}
                              </h5>
                          </div>
                      </div>
                      <div class="col-4 text-end d-flex align-items-center justify-content-center">
                          <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle custom-icon-dashboard">
                              <i class="bi bi-inboxes text-lg opacity-10" aria-hidden="true" style="font-size: 2rem;"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>

      <div class="col-xl-4 col-sm-6">
        <div class="card mb-3">
            <div class="card-body p-3 shadow-sm">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Pengembalian</p>
                            <h5 class="font-weight-bolder">
                                {{ $totalPengembalianUser }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end d-flex align-items-center justify-content-center">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle custom-icon-dashboard">
                            <i class="bi bi-box-arrow-in-left text-lg opacity-10" aria-hidden="true" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

        @endrole
    </div>
    
    <div class="row mt-2">
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-2">Transaksi Bulanan</h6>
                </div>
                </div>
                <div class="card-body p-3">
                {!! $peminjamanChart->container() !!}
                {!! $peminjamanChart->script() !!}
                </div>
            </div>
            </div>
            <div class="col-lg-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-2">Stok Barang</h6>
                </div>
                </div>
                <div class="card-body p-3">
                {!! $stokChart->container() !!}  <!-- Menampilkan Chart -->
                {!! $stokChart->script() !!}  <!-- Menjalankan Script untuk Chart -->
                </div>
            </div>
        </div>
    </div>
    @hasanyrole('superadmin|admin')
    <div class="row mt-2">
        <div class="col-12 mb-4">
          <div class="card shadow-sm">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">Stok Barang < 5</h6>
              </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table text-center align-items-center mb-0 table-striped table-bordered" id="tabel_stok">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kode</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nama Barang</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Merk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Kategori</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Stok Barang</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
    @endhasanyrole
  </main>
  <script>
    $(document).ready(function () {

        $('#tabel_stok').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
            scrollY: "1000px", // Tinggi maksimal tabel dengan scroll
            scrollCollapse: true, // Agar scroll tetap muncul meskipun sedikit data
            dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-center"f>>' + 
                 'rt' + 
                 '<"row mt-3 d-flex align-items-center"<"col-md-6"i><"col-md-6 text-end"p>>',
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]], // Opsi pilihan jumlah data
        ajax: "{{ route('master_barang.stok_sedikit') }}",
        columns: [
            { data: 'kode', name: 'kode', className: 'text-sm' },
            { data: 'nama', name: 'nama', className: 'text-sm' },
            { data: 'merk', name: 'merk', className: 'text-sm' },
            { data: 'kategori', name: 'kategori', orderable: false, searchable: false, className: 'text-sm' },
            { data: 'stok_tersedia', name: 'stok_tersedia', orderable: false, searchable: false, className: 'text-sm' },
            { 
                data: 'stok_tersedia',
                name: 'status_stok',
                orderable: false,
                searchable: false,
                className: 'text-sm text-center',
                render: function(data) {
                    if (data < 5) {
                        return `<span class="badge bg-danger">Stok < 5</span>`;
                    } else {
                        return `<span class="badge bg-success">Aman</span>`;
                    }
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
  });
  </script>
@endsection