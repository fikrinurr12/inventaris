@extends('layout.layout_utama')
@section('title', 'Master User')

@section('content')
@section('pages', 'Tambah User')

@push('scripts_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

<div class="container-fluid py-4">
    <!-- Tombol Kembali -->
    <div>
        <a href="{{ route('data_pengguna') }}" class="btn btn-primary btn-md btn-mobile">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Tambah Barang -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tambah_user.store') }}" method="POST">
                @csrf
            
                <!-- Input Nama -->
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama User</label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama user" required>
                    @error('nama')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Input Email -->
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email User</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email user" required>
                    @error('email')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Input Password -->
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                    @error('password')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Input Konfirmasi Password -->
                <div class="form-group mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Masukkan ulang password" required>
                    @error('password_confirmation')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Dropdown Role -->
                <div class="form-group mb-3">
                    <label for="role_id" class="form-label">Role</label>
                    <select id="role_id" name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">Pilih Role</option>
                        @foreach ($dataRole as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Tombol Simpan -->
                <div class="text-left">
                    <button type="submit" class="btn btn-success mt-3 btn-mobile">
                        <i class="bi bi-save"></i> Simpan User
                    </button>
                </div>
            </form>                    
        </div>
    </div>
</div>

@push('scripts_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function() {

            // Validasi password sebelum submit
            $("form").on("submit", function (e) {
                let password = $("#password").val();
                let confirmPassword = $("#password_confirmation").val();

                if (password !== confirmPassword) {
                    e.preventDefault(); // Mencegah submit jika tidak cocok
                    Swal.fire({
                        icon: "warning",
                        title: "Password tidak sama!",
                        text: "Silakan masukkan password Anda kembali.",
                        confirmButtonText: "OK"
                    });
                    return;
                        }
            });
        });
    </script>
@endpush

@endsection
