@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 bg-dark text-white min-vh-100">
            <div class="d-flex flex-column p-3">
                <h5 class="mb-4 py-2 border-bottom">Dashboard Admin</h5>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white active">
                            <i class="fas fa-home me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.lomba.index') }}" class="nav-link text-white">
                            <i class="fas fa-trophy me-2"></i>
                            Manajemen Lomba
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dokumen.index') }}" class="nav-link text-white">
                            <i class="fas fa-file-alt me-2"></i>
                            Verifikasi Dokumen
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
                <h4 class="mb-4">Dashboard Admin</h4>

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <!-- Competition Stats -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Total Lomba</h6>
                                <h2 class="card-title mb-0">{{ $totalLomba }}</h2>
                                <div class="mt-2">
                                    <small class="text-success">
                                        <i class="fas fa-circle me-1"></i>
                                        {{ $activeLomba }} Aktif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Total Pendaftar</h6>
                                <h2 class="card-title mb-0">{{ $totalPendaftar }}</h2>
                                <div class="mt-2">
                                    <small class="text-primary">
                                        <i class="fas fa-users me-1"></i>
                                        Peserta Terdaftar
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Stats -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Total Dokumen</h6>
                                <h2 class="card-title mb-0">{{ $totalDokumen }}</h2>
                                <div class="mt-2">
                                    <small class="text-warning">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $dokumenMenunggu }} Menunggu
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Dokumen Terverifikasi</h6>
                                <h2 class="card-title mb-0">{{ $dokumenTerverifikasi }}</h2>
                                <div class="mt-2">
                                    <small class="text-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Sudah Diverifikasi
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Data -->
                <div class="row">
                    <!-- Recent Competitions -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Lomba Terbaru</h5>
                                    <a href="{{ route('admin.lomba.index') }}" class="btn btn-sm btn-primary">
                                        Kelola Lomba
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama Lomba</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentLomba as $lomba)
                                                <tr>
                                                    <td>{{ $lomba->nama_lomba }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $lomba->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                            {{ $lomba->status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $lomba->created_at->format('d M Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada data lomba</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Needing Verification -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Dokumen Menunggu Verifikasi</h5>
                                    <a href="{{ route('admin.dokumen.index') }}" class="btn btn-sm btn-primary">
                                        Verifikasi Dokumen
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Mahasiswa</th>
                                                <th>Jenis Dokumen</th>
                                                <th>Tanggal Upload</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentDokumen as $dokumen)
                                                <tr>
                                                    <td>{{ $dokumen->user->name }}</td>
                                                    <td>{{ $dokumen->jenis }}</td>
                                                    <td>{{ $dokumen->created_at->format('d M Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada dokumen yang menunggu verifikasi</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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

.table th {
    font-weight: 600;
    color: #444;
}

.table td {
    vertical-align: middle;
}

.badge {
    padding: 0.5em 0.75em;
}
</style>
@endpush
@endsection 