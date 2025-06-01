@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Manajemen Dokumen Lomba</h5>
                </div>
                <div class="card-body">
                    <!-- Upload Form -->
                    <div class="mb-4">
                        <h6 class="card-subtitle mb-3">Upload Dokumen Baru</h6>
                        <form action="{{ route('mahasiswa.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <select name="jenis_dokumen" class="form-select @error('jenis_dokumen') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis Dokumen</option>
                                        <option value="proposal">Proposal</option>
                                        <option value="surat_tugas">Surat Tugas</option>
                                        <option value="sertifikat">Sertifikat</option>
                                    </select>
                                    @error('jenis_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('file_dokumen') is-invalid @enderror" 
                                               name="file_dokumen" accept=".pdf,.doc,.docx" required>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-upload me-1"></i> Upload
                                        </button>
                                    </div>
                                    @error('file_dokumen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format yang diperbolehkan: PDF, DOC, DOCX. Maksimal ukuran: 5MB
                                </small>
                            </div>
                        </form>
                    </div>

                    <!-- Document List -->
                    <div>
                        <h6 class="card-subtitle mb-3">Daftar Dokumen</h6>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Jenis Dokumen</th>
                                        <th>Nama File</th>
                                        <th>Status</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dokumen as $doc)
                                        <tr>
                                            <td>{{ ucfirst($doc->jenisdokumen) }}</td>
                                            <td>{{ $doc->namaFile }}</td>
                                            <td>
                                                @if($doc->statusVerifikasi === 'terverifikasi')
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                @elseif($doc->statusVerifikasi === 'ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($doc->statusVerifikasi === 'revisi')
                                                    <span class="badge bg-info">Perlu Revisi</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                                @endif
                                            </td>
                                            <td>{{ $doc->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#detailModal{{ $doc->dokumenid }}"
                                                            title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="{{ route('mahasiswa.dokumen.download', $doc->dokumenid) }}" 
                                                       class="btn btn-sm btn-primary"
                                                       title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="confirmDelete({{ $doc->dokumenid }})"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <form id="delete-form-{{ $doc->dokumenid }}" 
                                                      action="{{ route('mahasiswa.dokumen.destroy', $doc->dokumenid) }}" 
                                                      method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <!-- Detail Modal -->
                                                <div class="modal fade" id="detailModal{{ $doc->dokumenid }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Detail Dokumen</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="fw-bold">Jenis Dokumen</label>
                                                                    <p>{{ ucfirst($doc->jenisdokumen) }}</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="fw-bold">Nama File</label>
                                                                    <p>{{ $doc->namaFile }}</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="fw-bold">Status</label>
                                                                    <p>
                                                                        @if($doc->statusVerifikasi === 'terverifikasi')
                                                                            <span class="badge bg-success">Terverifikasi</span>
                                                                        @elseif($doc->statusVerifikasi === 'ditolak')
                                                                            <span class="badge bg-danger">Ditolak</span>
                                                                        @elseif($doc->statusVerifikasi === 'revisi')
                                                                            <span class="badge bg-info">Perlu Revisi</span>
                                                                        @else
                                                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="fw-bold">Tanggal Upload</label>
                                                                    <p>{{ $doc->created_at->format('d M Y H:i') }}</p>
                                                                </div>
                                                                @if($doc->catatan)
                                                                <div class="mb-3">
                                                                    <label class="fw-bold">Catatan dari Admin</label>
                                                                    <div class="alert alert-{{ $doc->statusVerifikasi === 'revisi' ? 'info' : ($doc->statusVerifikasi === 'rejected' ? 'danger' : 'success') }} mt-2">
                                                                        {{ $doc->catatan }}
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                @if($doc->statusVerifikasi === 'revisi')
                                                                <a href="{{ route('mahasiswa.dokumen.download', $doc->dokumenid) }}" 
                                                                   class="btn btn-primary">
                                                                    <i class="fas fa-download me-1"></i> Download untuk Revisi
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada dokumen yang diupload</td>
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

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

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
.badge {
    padding: 0.5em 0.75em;
}
.btn-group .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endpush
@endsection 