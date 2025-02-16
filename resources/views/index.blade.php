@extends('layout.layout_sign')
@section('title','Log In')

@section('content')
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  @php
                  $logo = request()->isSecure() ? secure_asset('assets/img/logos/Sukun_Mc_Wartono.jpeg') : asset('assets/img/logos/Sukun_Mc_Wartono.jpeg');
                  @endphp
                  <img src="{{ $logo }}" class="d-block mx-auto img-fluid w-30 mb-6 hide-mobile-invert">
                  <!-- Menampilkan Flash Message -->
                  @if(session('success'))
                    <div class="alert alert-success text-white">
                      {{ session('success') }}
                    </div>
                  @endif
                  @if(session('failed'))
                    <div class="alert alert-danger text-white">
                      {{ session('failed') }}
                    </div>
                  @endif
                  <h4 class="font-weight-bolder">Log In</h4>
                  <p class="mb-0">Masukkan Email dan Password Anda</p>
                </div>
                <div class="card-body">
                  <form role="form" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" aria-label="Email" required>
                    </div>
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" aria-label="Password" required>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Log In</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    <a href="{{ route('lupa_password') }}" class="text-primary text-gradient font-weight-bold">Lupa Password?</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div id="imageContainer" class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" 
                  style="background-image: url('https://lh5.googleusercontent.com/p/AF1QipOLsmHYTcVMEPW9VcjsLOE4R_oBX75apTyPOh1k=w408-h306-k-no'); 
                  background-size: cover; transition: background-image 1s ease-in-out;">
                  <span class="mask bg-gradient-primary opacity-3"></span>
                  <h4 class="mt-5 text-white font-weight-bolder position-relative">"Urip Iku Urup"</h4>
                  <p class="text-white position-relative">kita dilahirkan di dunia ini bukan untuk berdiri sendiri, berkuasa dan semua hanya untuk diri sendiri, akan tetapi kita lahir untuk saling memberi, saling menolong dan saling membantu sesama tanpa ada rasa pamrih..</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script>
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

    // Ganti gambar setiap 5 detik
    setInterval(changeBackground, 5000);
  </script>
@endsection
