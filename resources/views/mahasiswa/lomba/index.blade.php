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
                        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link text-white">
                            <i class="fas fa-home me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('mahasiswa.lomba') }}" class="nav-link text-white active">
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
                <h4 class="mb-4">Lomba Saya</h4>

                <!-- Registered Competitions -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Lomba Terdaftar</h5>
                    </div>
                    <div class="card-body">
                        @if($registeredCompetitions->isEmpty())
                            <p class="text-muted">Belum ada lomba yang terdaftar.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama Lomba</th>
                                            <th>Tingkat</th>
                                            <th>Status</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registeredCompetitions as $registration)
                                            <tr>
                                                <td>{{ $registration->lomba->nama_lomba }}</td>
                                                <td>{{ $registration->lomba->tingkat }}</td>
                                                <td>
                                                    <span class="badge bg-{{ 
                                                        $registration->status == 'diterima' ? 'success' : 
                                                        ($registration->status == 'pending' ? 'warning' : 
                                                        ($registration->status == 'mengundurkan_diri' ? 'info' : 'danger')) 
                                                    }}">
                                                        {{ ucfirst($registration->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $registration->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <a href="{{ route('mahasiswa.lomba.daftar.detail', $registration->id) }}" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye me-1"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Available Competitions -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Lomba Tersedia</h5>
                    </div>
                    <div class="card-body">
                        @if($availableCompetitions->isEmpty())
                            <p class="text-muted">Tidak ada lomba yang tersedia saat ini.</p>
                        @else
                            <div class="row g-4">
                                @foreach($availableCompetitions as $lomba)
                                    <div class="col-md-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $lomba->nama_lomba }}</h5>
                                                <p class="card-text">{{ Str::limit($lomba->deskripsi, 100) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-primary">{{ $lomba->tingkat }}</span>
                                                    <a href="{{ route('mahasiswa.lomba.daftar', $lomba->id) }}" class="btn btn-outline-primary btn-sm">Daftar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
</style>
@endpush
@endsection 