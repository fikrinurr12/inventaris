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
  <!-- sweetalert -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <!--- sweet alert --->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    /* Animasi transisi background lebih halus */
    .fade-background {
        transition: background-image 2s ease-in-out;
    }
    .hide-mobile-invert{
      display: none !important;
    }

    @media (max-width: 900.98px) {
        .hide-mobile-invert {
            display: block !important;
            margin-top: -5em !important;
        }
    }
  </style>
</head>

<body class="">

  @yield('content')

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

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    // Daftar gambar
    const images = [
        "https://lh5.googleusercontent.com/p/AF1QipOLsmHYTcVMEPW9VcjsLOE4R_oBX75apTyPOh1k=w408-h306-k-no",
        "https://i0.wp.com/betanews.id/wp-content/uploads/2022/10/20221022_Betanews_Rokok-Klobot-2.jpg?fit=600%2C350&ssl=1",
        "https://images.murianews.com/data/2023/11/image-20231128013422.jpeg",
        "https://asset-2.tstatic.net/jateng/foto/bank/images/bantuan-perusahaan-rokok-sukun.jpg",
        "https://asset.kompas.com/crops/knV6aaEB5IjnlN77Ej2rvAYx23k=/0x15:1361x922/750x500/data/photo/2020/11/09/5fa96fed226cd.jpeg"
    ];

    let currentImageIndex = 0;

    function changeBackground() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        document.getElementById("imageContainer").style.backgroundImage = `url('${images[currentImageIndex]}')`;
    }

    // Ganti gambar setiap 10 detik
    setInterval(changeBackground, 10000);
  </script>
  <!-- Github buttons -->
  <script async src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  @php
  $dashboardjs = request()->isSecure() ? secure_asset('assets/js/argon-dashboard.min.js?v=2.1.0') : asset('assets/js/argon-dashboard.min.js?v=2.1.0');
  @endphp
  <script src="{{ $dashboardjs }}"></script>
</body>

</html>