@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Dokumen</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.dokumen.index') }}">Dokumen</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-file-alt me-1"></i>
                    Informasi Dokumen
                </div>
                <div>
                    @if($dokumen->statusVerifikasi != 'terverifikasi')
                    <form action="{{ route('admin.dokumen.verify', $dokumen->dokumenid) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i> Verifikasi
                        </button>
                    </form>
                    @endif
                    @if($dokumen->statusVerifikasi != 'revisi')
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#revisionModal">
                        <i class="fas fa-redo me-1"></i> Minta Revisi
                    </button>
                    @endif
                    @if($dokumen->statusVerifikasi != 'ditolak')
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-1"></i> Tolak
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="200">Nama File</th>
                            <td>{{ $dokumen->namaFile }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Dokumen</th>
                            <td>{{ $dokumen->jenisdokumen }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($dokumen->statusVerifikasi == 'terverifikasi')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif($dokumen->statusVerifikasi == 'revisi')
                                    <span class="badge bg-warning">Perlu Revisi</span>
                                @elseif($dokumen->statusVerifikasi == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Mahasiswa</th>
                            <td>{{ $dokumen->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Lomba</th>
                            <td>{{ $dokumen->lomba->nama_lomba ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $dokumen->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Preview Dokumen</div>
                        <div class="card-body">
                            @if($dokumen->filepath)
                                @if(in_array(pathinfo($dokumen->filepath, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ Storage::url($dokumen->filepath) }}" class="img-fluid" alt="Document Preview">
                                @else
                                    <div class="text-center">
                                        <a href="{{ Storage::url($dokumen->filepath) }}" class="btn btn-primary" target="_blank">
                                            <i class="fas fa-download me-1"></i> Download Dokumen
                                        </a>
                                    </div>
                                @endif
                            @else
                                <p class="text-center text-muted">Tidak ada file yang tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.dokumen.reject', $dokumen->dokumenid) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" name="catatan" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Revision Modal -->
<div class="modal fade" id="revisionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Minta Revisi Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.dokumen.revision', $dokumen->dokumenid) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Revisi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="catatan" rows="3" required></textarea>
                        <small class="text-muted">Jelaskan apa yang perlu direvisi oleh mahasiswa</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Minta Revisi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 