@extends('...layout.message')

@section('title', '404 - Not Found')

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body table-responsive">
            <div class="container text-center mt-5">
                <h1 class="display-1 text-danger">404</h1>
                <h3 class="text-dark">Halaman Tidak Ditemukan</h3>
                <p class="text-muted">Halaman yang anda tuju tidak ada.</p>
                
                @if(Auth::check())
                    <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fas fa-home"></i> Kembali</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Kembali</a>
                @endif
            </div>
        </div>
    </div>
</div>
