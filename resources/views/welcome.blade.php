@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Selamat Datang di Sistem Manajemen Lomba</h1>
            <p class="lead mb-5">Platform untuk mengelola dan mengikuti berbagai kompetisi akademik</p>
            
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 gap-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                @else
                    @if(auth()->user()->role === 'mahasiswa')
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Mahasiswa
                        </a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.25rem;
    border-radius: 0.5rem;
}
</style>
@endpush
@endsection 