@extends('layout.layout_sign')
@section('title','Lupa Password')

@section('content')
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Lupa Password</h4>
                  <p class="mb-0">Silahkan Masukkan Email Anda</p>
                </div>
                <div class="card-body">
                  <input type="email" id="email" class="form-control" placeholder="Masukkan Email Anda" required>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="text-sm">
                    <a href="#" id="whatsapp-link" class="font-weight-bold btn btn-primary text-white" onclick="sendToWhatsApp()">
                      Silahkan Hubungi Admin
                    </a>
                  </p>
                  <p class="mb-4 text-sm">
                    <a href="{{ route('login') }}" class="text-primary font-weight-bold">Kembali</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('{{ asset('assets/img/curved-images/curved-6.jpg') }}');
          background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new currency"</h4>
                <p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script>
    function sendToWhatsApp() {
        var email = document.getElementById("email").value;
        if (email.trim() === "") {
          Swal.fire({
                icon: "warning",
                title: "Email wajib diisi!",
                text: "Silakan masukkan email Anda terlebih dahulu.",
                confirmButtonText: "OK"
            });
            return;
        }
        var phoneNumber = "6281229799835"; // Ganti dengan nomor admin
        var message = "Halo Admin, saya lupa password akun saya. Email saya: " + email;
        var url = "https://wa.me/" + phoneNumber + "?text=" + encodeURIComponent(message);
        window.open(url, "_blank");
    }
  </script>
@endsection
