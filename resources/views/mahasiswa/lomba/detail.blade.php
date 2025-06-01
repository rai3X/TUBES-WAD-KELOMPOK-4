@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pendaftaran Lomba</h5>
                    <a href="{{ route('mahasiswa.lomba') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>{{ $pendaftaran->lomba->nama_lomba }}</h4>
                            <span class="badge bg-primary mb-3">{{ $pendaftaran->lomba->tingkat }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status Pendaftaran</div>
                        <div class="col-md-8">
                            <span class="badge bg-{{ $pendaftaran->status == 'diterima' ? 'success' : ($pendaftaran->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($pendaftaran->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal Daftar</div>
                        <div class="col-md-8">{{ $pendaftaran->created_at->format('d F Y H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Penyelenggara</div>
                        <div class="col-md-8">{{ $pendaftaran->lomba->penyelenggara }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Periode Lomba</div>
                        <div class="col-md-8">
                            {{ $pendaftaran->lomba->tanggal_mulai->format('d F Y') }} - 
                            {{ $pendaftaran->lomba->tanggal_selesai->format('d F Y') }}
                        </div>
                    </div>

                    @if($pendaftaran->catatan)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Catatan</div>
                        <div class="col-md-8">{{ $pendaftaran->catatan }}</div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Deskripsi Lomba</div>
                        <div class="col-md-8">{{ $pendaftaran->lomba->deskripsi ?: 'Tidak ada deskripsi' }}</div>
                    </div>

                    @if($pendaftaran->status === 'pending')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form action="{{ route('mahasiswa.lomba.daftar.cancel', $pendaftaran->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini?')">
                                    <i class="fas fa-times me-1"></i> Batalkan Pendaftaran
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    @if($pendaftaran->status === 'diterima')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form action="{{ route('mahasiswa.lomba.daftar.withdraw', $pendaftaran->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin mengundurkan diri dari lomba ini? Tindakan ini tidak dapat dibatalkan.')">
                                    <i class="fas fa-door-open me-1"></i> Mengundurkan Diri
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    @if(in_array($pendaftaran->status, ['ditolak', 'dibatalkan']))
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form action="{{ route('mahasiswa.lomba.daftar.destroy', $pendaftaran->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pendaftaran lomba ini? Tindakan ini tidak dapat dibatalkan.')">
                                    <i class="fas fa-trash me-1"></i> Hapus Pendaftaran
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 