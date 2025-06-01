@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pendaftaran Lomba</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Competition Details -->
                    <div class="mb-4">
                        <h6 class="card-subtitle mb-3">Detail Lomba</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width: 200px">Nama Lomba</th>
                                    <td>{{ $lomba->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Penyelenggara</th>
                                    <td>{{ $lomba->penyelenggara }}</td>
                                </tr>
                                <tr>
                                    <th>Tingkat</th>
                                    <td>{{ $lomba->tingkat }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $lomba->tanggal_mulai->format('d M Y') }} - {{ $lomba->tanggal_selesai->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $lomba->deskripsi }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <form action="{{ route('mahasiswa.lomba.daftar.store', $lomba->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <h6 class="card-subtitle mb-3">Konfirmasi Pendaftaran</h6>
                            <div class="form-check">
                                <input type="checkbox" name="persetujuan" class="form-check-input @error('persetujuan') is-invalid @enderror" id="persetujuan" required>
                                <label class="form-check-label" for="persetujuan">
                                    Saya menyatakan bahwa data yang saya masukkan adalah benar dan saya bersedia mengikuti 
                                    seluruh ketentuan lomba yang berlaku.
                                </label>
                                @error('persetujuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('mahasiswa.lomba') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Ajukan Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    border: none;
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
.table th {
    font-weight: 600;
    color: #444;
}
</style>
@endpush
@endsection 