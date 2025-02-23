<!--
=========================================================
* Argon Dashboard 3 - v2.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @php
    $favicon = request()->isSecure() ? secure_asset('assets/img/logos/Sukun_Mc_Wartono.jpeg') : asset('assets/img/logos/Sukun_Mc_Wartono.jpeg');
  @endphp
  <link rel="icon" type="image/png" href="{{ $favicon }}">
  <title>
    @yield('title')
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- CSS Files -->
  @php
    $argon = request()->isSecure() ? secure_asset('assets/css/argon-dashboard.css?v=2.1.0') : asset('assets/css/argon-dashboard.css?v=2.1.0');
  @endphp
  <link id="pagestyle" href="{{ $argon }}" rel="stylesheet" />
  {{-- <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.css?v=2.1.0')}}" rel="stylesheet" /> --}}
  <!-- sweetalert -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <!--- sweet alert --->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  {{-- select 2 --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- Select2 Bootstrap 5 Theme -->
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.min.css">
  {{-- select 2 css --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  {{-- datatable css --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
  {{-- daterangepicker css --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" />
  {{-- larapex --}}
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <style>
    .square-btn {
        width: 35px;
        height: 35px;
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: auto;
        border-radius: 5px;
        display: inline-grid;
        margin-left: 0.2em;
    }
    
    .sidenav {
      z-index: 1040 !important;
      transition: transform 0.3s ease-in-out;
    }
    
    .navbar-vertical.navbar-expand-xs {
      max-width: 250px;
    }
    
    /* Add backdrop when sidebar is open on mobile */
    .sidebar-backdrop {
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: none;
    }
    
    .sidebar-backdrop.show {
      display: block;
    }

    .navbar-back{
      opacity: 0;
      transition: 0.5s ease;
    }

    /* Default navbar styling */
    .navbar-main {
      transition: all 0.3s ease;
      z-index: 1030 !important;
    }

    /* Smooth scrolling for iOS */
    .smooth-scroll {
      -webkit-overflow-scrolling: touch;
    }

    .hide-mobile-invert{
      display: none;
    }

    /* Sembunyikan logout-output secara default */
    li.logout-output {
        display: none;
    }

    /* Saat .active ditambahkan ke logout-input, logout-output muncul */
    li.logout-input.active + li.logout-output {
        display: block;
        margin-left: 1em;
    }
    .dropdown-menu {
      margin-top: -5px !important;
      transform: translateY(-10px);
    }

    :not(.main-content) .navbar .dropdown .dropdown-menu {
        top: .0rem !important;
    }

    /* Mobile fixed navbar styles */
    @media (max-width: 900.98px) {
      .hide-mobile{
        display: none;
      }

      .hide-mobile-invert{
        display: block;
      }

      .btn-mobile{
        width: 100% !important;
      }

      .hide-mobile-button { 
        display: block !important;
      }
      
      /* Adjust container padding */
      .navbar .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
      }
      
      /* Ensure dropdown menus appear above navbar */
      .dropdown-menu {
        z-index: 1031;
      }

      .sidenav {
        transform: translateX(-100%);
      }
      
      .sidenav.show {
        transform: translateX(0);
      }
    }

  </style>
  
  @stack('scripts_css')
  
</head>

<body class="g-sidenav-show bg-gray-100">

  @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success', // Menampilkan icon sukses
            title: 'Berhasil',
            text: '{{ session("success") }}',
            showConfirmButton: false, // Menyembunyikan tombol OK
            showCloseButton: true, // Menambahkan tombol "X" di pojok
        });
    </script>
  @elseif(session('failed'))
      <script>
          Swal.fire({
              icon: 'error', // Menampilkan icon error
              title: 'Gagal',
              text: '{{ session("failed") }}',
              showConfirmButton: false,
              showCloseButton: true,
          });
      </script>
  @elseif(session('info'))
      <script>
          Swal.fire({
              icon: 'info', // Menampilkan icon info
              title: 'Informasi',
              text: '{{ session("info") }}',
              showConfirmButton: false,
              showCloseButton: true,
          });
      </script>
  @elseif(session('warning'))
      <script>
          Swal.fire({
              icon: 'warning', // Menampilkan icon peringatan
              title: 'Peringatan',
              text: '{{ session("warning") }}',
              showConfirmButton: false,
              showCloseButton: true,
          });
      </script>
  @elseif(session('question'))
      <script>
          Swal.fire({
              icon: 'question', // Menampilkan icon pertanyaan
              title: 'Pertanyaan',
              text: '{{ session("question") }}',
              showConfirmButton: false,
              showCloseButton: true,
          });
      </script>
  @endif

  <div class="min-height-300 bg-dark position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 shadow-sm" id="sidenav-main">
    <div class="sidenav-header d-flex align-items-center justify-content-between">
      <a class="navbar-brand d-flex align-items-center m-0" href="{{ route('dashboard') }}">
        @php
          $logo = request()->isSecure() ? secure_asset('assets/img/logos/Sukun_Mc_Wartono.jpeg') : asset('assets/img/logos/Sukun_Mc_Wartono.jpeg');
        @endphp
          <img src="{{ $logo }}" width="60" height="40">
          {{-- <img src="{{ asset('assets/img/logos/Sukun_Mc_Wartono.jpeg') }}" width="60" height="40"> --}}
          <span class="ms-3 font-weight-bold text-dark">Inventaris</span>
      </a>
      <i class="fas fa-times text-white opacity-75 cursor-pointer d-xl-none" id="iconSidenav"></i>
    </div>  
    <hr class="horizontal dark mt-0">
    <div class="w-auto ps" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item mt-3 hide-mobile-invert">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Profil Pengguna</h6>
        </li>
        <!-- Nama Pengguna (Diklik untuk Tampilkan Logout) -->
        <li class="nav-item hide-mobile-invert">
          <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#menuUser" role="button" aria-expanded="false" aria-controls="menuUser">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-person text-dark text-sm opacity-10"></i> <!-- Ikon Pengguna -->
            </div>
            <span class="nav-link-text ms-1">{{ Auth::user()->name }}</span>
          </a>
        </li>

        <!-- Submenu Logout -->
      <div class="collapse hide-mobile-invert" id="menuUser">
        <ul class="nav flex-column ms-4">
          <li class="nav-item">
            <a class="nav-link ps-3 py-2 d-flex align-items-center" href="#" id="logoutButton">
              <i class="bi bi-box-arrow-left me-2"></i> Logout
            </a>
            <!-- Form Logout -->
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </div>

        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu Utama</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-speedometer2 text-dark text-sm opacity-10"></i> <!-- Ikon Dashboard -->
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        @hasanyrole('superadmin|admin')
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Barang</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('master_barang*') ? 'active' : '' }}" href="{{ route('master_barang') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-box-seam text-dark text-sm opacity-10"></i> <!-- Ikon Master Barang -->
            </div>
            <span class="nav-link-text ms-1">Master Barang</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('kategori*') ? 'active' : '' }}" href="{{ route('kategori') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-tags text-dark text-sm opacity-10"></i> <!-- Ikon Master Barang -->
            </div>
            <span class="nav-link-text ms-1">Kategori</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('penyesuaian_stok*') ? 'active' : '' }}" href="{{ route('penyesuaian_stok') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-ui-checks-grid text-dark text-sm opacity-10"></i> <!-- Ikon Master Barang -->
            </div>
            <span class="nav-link-text ms-1">Penyesuaian Stok</span>
          </a>
        </li>
        @endhasanyrole
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Transaksi</h6>
        </li>
        @role('superadmin|admin')
        <li class="nav-item">
          <a class="nav-link {{ Request::is('supplier*') ? 'active' : '' }}" href="{{ route('supplier') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-truck text-dark text-sm opacity-10"></i> <!-- Ikon Master supllier -->
            </div>
            <span class="nav-link-text ms-1">Master Supplier</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('pembelian*') ? 'active' : '' }}" href="{{ route('pembelian') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-cart4 text-dark text-sm opacity-10"></i> <!-- Ikon Pembelian -->
            </div>
            <span class="nav-link-text ms-1">Pembelian</span>
          </a>
        </li>
        @endrole
        <li class="nav-item">
          <a class="nav-link {{ Request::is('peminjaman*') ? 'active' : '' }}" href="{{ route('peminjaman') }}" style="position: relative;">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="bi bi-arrow-up-right-square text-dark text-sm opacity-10"></i> <!-- Ikon Peminjaman -->
              </div>
              <span class="nav-link-text ms-1">Peminjaman</span>
              @role('superadmin')
              <span class="badge bg-danger position-absolute top-25 end-5 translate-right" id="pending-peminjaman"></span> <!-- Notifikasi Peminjaman -->
              @endrole
              @role('admin|user')
              <span class="badge bg-danger position-absolute top-25 end-5 translate-right" id="pending-peminjaman-user"></span> <!-- Notifikasi Peminjaman -->
              @endrole
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('pengembalian*') ? 'active' : '' }}" href="{{ route('pengembalian') }}" style="position: relative;">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-arrow-down-left-square text-dark text-sm opacity-10"></i> <!-- Ikon Pengembalian -->
                </div>
                <span class="nav-link-text ms-1">Pengembalian</span>
                @role('superadmin')
                <span class="badge bg-danger position-absolute top-25 end-5 translate-right" id="pending-pengembalian"></span> <!-- Notifikasi Pengembalian -->
                @endrole
                @role('admin|user')
                <span class="badge bg-danger position-absolute top-25 end-5 translate-right" id="pending-pengembalian-user"></span> <!-- Notifikasi Pengembalian -->
                @endrole
            </a>
        </li>      
        @hasanyrole('superadmin|admin')
        @php
            $laporanRoutes = [
                'laporan.master_barang',
                'laporan.pembelian',
                'laporan.penyesuaian_stok',
                'laporan.peminjaman',
                'laporan.pengembalian'
            ];
            $isLaporanActive = in_array(Route::currentRouteName(), $laporanRoutes);
        @endphp
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Report</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#menuLaporan"
             role="button" aria-expanded="{{ $isLaporanActive ? 'true' : 'false' }}" aria-controls="menuLaporan">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="bi bi-bar-chart-line text-dark text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Laporan</span>
          </a>
      </li>
      
      <!-- Submenu Laporan -->
      <div class="collapse {{ $isLaporanActive ? 'show' : '' }}" id="menuLaporan">
          <ul class="nav flex-column ms-4">
              <li class="nav-item">
                  <a class="nav-link ps-3 py-2 d-flex align-items-center {{ Request::routeIs('laporan.master_barang') ? 'active' : '' }}" href="{{ route('laporan.master_barang') }}">
                      <i class="bi bi-box me-2"></i>Data Barang
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link ps-3 py-2 d-flex align-items-center {{ Request::routeIs('laporan.pembelian') ? 'active' : '' }}" href="{{ route('laporan.pembelian') }}">
                      <i class="bi bi-cart me-2"></i>Pembelian
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link ps-3 py-2 d-flex align-items-center {{ Request::routeIs('laporan.penyesuaian_stok') ? 'active' : '' }}" href="{{ route('laporan.penyesuaian_stok') }}">
                      <i class="bi bi-arrow-left-right me-2"></i>Penyesuaian Stok
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link ps-3 py-2 d-flex align-items-center {{ Request::routeIs('laporan.peminjaman') ? 'active' : '' }}" href="{{ route('laporan.peminjaman') }}">
                      <i class="bi bi-box-arrow-in-down me-2"></i>Peminjaman
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link ps-3 py-2 d-flex align-items-center {{ Request::routeIs('laporan.pengembalian') ? 'active' : '' }}" href="{{ route('laporan.pengembalian') }}">
                      <i class="bi bi-box-arrow-in-up me-2"></i>Pengembalian
                  </a>
              </li>
          </ul>
      </div>
        
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Manajemen Pengguna</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('data_pengguna*') ? 'active' : '' }}" href="{{ route('data_pengguna') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-people text-dark text-sm opacity-10"></i> <!-- Ikon Data Pengguna -->
            </div>
            <span class="nav-link-text ms-1">Data Pengguna</span>
          </a>
        </li>
        @endhasanyrole
      </ul>      
    </div>
  </aside>

  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg top-0 px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <div class="d-flex justify-content-between align-items-center w-100">
          <!-- Left side with breadcrumb -->
          <div class="d-flex align-items-center" id="navbarBack">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
                <li class="breadcrumb-item">
                  <a class="opacity-5 text-white text-sm" href="javascript:;">Pages</a>
                </li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                  @yield('pages')
                </li>
              </ol>
              <h6 class="font-weight-bolder text-white mb-0">@yield('pages')</h6>
            </nav>
          </div>

          <!-- Right side with toggle button and profile -->
          <div class="d-flex align-items-center gap-3">
            <!-- Profile Dropdown -->
            <div class="dropdown hide-mobile">
              <a href="#" 
                class="nav-link dropdown-toggle d-flex align-items-center text-white" 
                role="button" 
                id="profileDropdown" 
                data-bs-toggle="dropdown" 
                aria-expanded="false"
                data-bs-offset="0,10"> <!-- Menggeser dropdown lebih dekat ke navbar -->
                  <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li>
                    <a class="dropdown-item text-danger" href="#" id="logoutButton">
                      <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>
                    <!-- Form Logout -->
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                </li>
              </ul>
            </div>
            <!-- Sidebar Toggle Button -->
            <button class="btn btn-icon d-xl-none mt-3 text-white" id="iconSidenavToggle" type="button">
              <i class="fas fa-bars"></i>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autoNumeric/1.9.46/autoNumeric.min.js"></script>

    @stack('scripts_js')
    <!-- End Navbar -->

    @yield('content')
  
  <!--   Core JS Files   -->
  @php
    $popper = request()->isSecure() ? secure_asset('assets/js/core/popper.min.js') : asset('assets/js/core/popper.min.js');
    $bootstrap = request()->isSecure() ? secure_asset('assets/js/core/bootstrap.min.js') : asset('assets/js/core/bootstrap.min.js');
    $perfect = request()->isSecure() ? secure_asset('assets/js/plugins/perfect-scrollbar.min.js') : asset('assets/js/plugins/perfect-scrollbar.min.js');
    $smooth = request()->isSecure() ? secure_asset('assets/js/plugins/smooth-scrollbar.min.js') : asset('assets/js/plugins/smooth-scrollbar.min.js');
    $chart = request()->isSecure() ? secure_asset('assets/js/plugins/chartjs.min.js') : asset('assets/js/plugins/chartjs.min.js');
  @endphp
  <script src="{{ $popper }}"></script>
  <script src="{{ $bootstrap }}"></script>
  <script src="{{ $perfect }}"></script>
  <script src="{{ $smooth }}"></script>
  <script src="{{ $chart }}"></script>

  {{-- datatables js --}}
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.1/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.1/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.1/js/buttons.print.min.js"></script>
  
  {{-- select2 --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  {{-- date range picker --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>

  {{-- larapex chart --}}
  <script src="https://cdn.jsdelivr.net/npm/larapex-chart@1.0.4/dist/larapexchart.min.js"></script>

  {{-- rupiah format --}}
  <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.4"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    document.getElementById('iconSidenavToggle').addEventListener('click', function() {
        const sidenav = document.getElementById('sidenav-main');
        const navbarUp = document.getElementById('navbarBack');
        const buttonSidenav = document.getElementById('iconSidenavToggle');

        buttonSidenav.classList.toggle('btn-primary');

        navbarUp.classList.toggle('navbar-back');

        // Menambahkan kelas 'sidenav-open' untuk membuka sidebar
        sidenav.classList.toggle('sidenav-open');
        
        // Menambahkan atau menghapus kelas 'g-sidenav-show' untuk mengelola visibilitas
        sidenav.classList.toggle('g-sidenav-show');
    });


    //fixed navbar
    document.body.classList.add('smooth-scroll');

    $(document).ready(function () {
        $(".logout-input").click(function (e) {
            e.preventDefault(); // Hindari reload halaman
            
            $(this).toggleClass("active"); // Tambah/hapus class active
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
      document.body.addEventListener("click", function (event) {
        if (event.target.id === "logoutButton" || event.target.closest("#logoutButton")) {
            event.preventDefault(); // Mencegah logout langsung
            
            Swal.fire({
                title: "Konfirmasi Logout",
                text: "Apakah Anda yakin ingin logout?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Logout!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("logoutForm").submit(); // Kirim form logout
                }
            });
        }
      });
    });
  </script>

  {{-- //notifikasi pending --}}
  @role('superadmin')
    <script>
      $(document).ready(function () {
        // Update pending peminjaman count
        $.get("{{ route('peminjaman.pending_count') }}", function(data) {
            $('#pending-peminjaman').text(data.pending_peminjaman);
        });

        // Update pending pengembalian count
        $.get("{{ route('pengembalian.pending_count') }}", function(data) {
            $('#pending-pengembalian').text(data.pending_pengembalian);
        });
    });
    </script>
  @endrole
  @hasanyrole('user|admin')
  <script>
    $(document).ready(function () {
      // Update pending peminjaman count
      $.get("{{ route('peminjaman.pending_count_user') }}", function(data) {
          $('#pending-peminjaman-user').text(data.pending_peminjaman_user);
      });

        // Update pending pengembalian count user
      $.get("{{ route('pengembalian.pending_count_user') }}", function(data) {
          $('#pending-pengembalian-user').text(data.pending_pengembalian_user);
      });
    });
  </script>
  @endhasanyrole
  {{-- notifikasi pending --}}

  <!-- Github buttons -->
  <script src="https://buttons.github.io/buttons.js"></script>

  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  @php
  $dashboardjs = request()->isSecure() ? secure_asset('assets/js/argon-dashboard.min.js?v=2.1.0') : asset('assets/js/argon-dashboard.min.js?v=2.1.0');
  @endphp
  <script src="{{ $dashboardjs }}"></script>

  {{-- custom js --}}
  @php
  $customjs = request()->isSecure() ? secure_asset('assets/js/custom-script.js') : asset('assets/js/custom-script.js');
  @endphp
  <script src="{{ $customjs }}"></script>
  
</body>

</html>