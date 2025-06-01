@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 bg-dark text-white min-vh-100">
            <div class="d-flex flex-column p-3">
                <h5 class="mb-4 py-2 border-bottom">Dashboard Mahasiswa</h5>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-2">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link text-white active">
                            <i class="fas fa-home me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('mahasiswa.lomba') }}" class="nav-link text-white">
                            <i class="fas fa-trophy me-2"></i>
                            Lomba Saya
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('mahasiswa.dokumen.index') }}" class="nav-link text-white">
                            <i class="fas fa-file-alt me-2"></i>
                            Dokumen
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('mahasiswa.jadwal.index') }}" class="nav-link text-white">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Jadwal Coaching
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="nav-link text-white">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 bg-light">
            <div class="p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Selamat datang, {{ Auth::user()->name }}</h4>
                    <a href="{{ route('mahasiswa.profile') }}" class="text-decoration-none text-primary">
                        Edit Profil
                        <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>

                <!-- Cards -->
                <div class="row g-4">
                    <!-- Kompetisi Terdaftar -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Kompetisi Terdaftar</h5>
                                <p class="card-text text-muted">
                                    Melihat daftar lomba yang sudah Anda daftarkan dan statusnya.
                                </p>
                                <a href="{{ route('mahasiswa.lomba') }}" class="btn btn-success">
                                    Lihat Lomba
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Saya -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Dokumen Saya</h5>
                                <p class="card-text text-muted">
                                    Unggah dan kelola dokumen lomba seperti proposal dan sertifikat.
                                </p>
                                <a href="{{ route('mahasiswa.dokumen.index') }}" class="btn btn-success">
                                    Kelola Dokumen
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Coaching -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Jadwal Coaching</h5>
                                <p class="card-text text-muted">
                                    Akses dan lihat status jadwal coaching dan waktunya.
                                </p>
                                <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn btn-success">
                                    Lihat Jadwal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-5 text-muted">
                    <small>&copy; 2024 Sistem Manajemen Data Lomba</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

@push('styles')
<style>
.nav-link {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    margin-bottom: 0.25rem;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.nav-link.active {
    background-color: rgba(255, 255, 255, 0.2);
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.btn-success {
    background-color: #28a745;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 6px;
}

.btn-success:hover {
    background-color: #218838;
}
</style>
@endpush
@endsection 