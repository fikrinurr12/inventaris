@extends('...layout.message')

@section('title', '500 - Internal Server Error')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body table-responsive">
            <div class="container text-center mt-5">
                <h1 class="display-1 text-danger">419</h1>
                <h3 class="text-dark">Kesalahan Internal Server</h3>
                <p class="text-muted">Harap kembali ke halaman sebelumnya.</p>
                
                @if(Auth::check())
                    <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fas fa-home"></i> Kembali</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Kembali</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
