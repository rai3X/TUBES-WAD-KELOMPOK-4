@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Manajemen Jadwal Coaching</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>Lomba</th>
                                    <th>Jenis</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->user->name }}</td>
                                        <td>{{ $jadwal->lomba->nama_lomba }}</td>
                                        <td>{{ ucfirst($jadwal->jenis) }}</td>
                                        <td>{{ $jadwal->tanggal_waktu->format('d M Y H:i') }}</td>
                                        <td>
                                            @if($jadwal->status === 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($jadwal->status === 'disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($jadwal->status === 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                @if($jadwal->status === 'pending')
                                                    <button type="button" 
                                                            class="btn btn-sm btn-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#approveModal{{ $jadwal->id }}"
                                                            title="Setujui">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $jadwal->id }}"
                                                            title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete({{ $jadwal->id }})"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Approve Modal -->
                                            <div class="modal fade" id="approveModal{{ $jadwal->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Setujui Jadwal</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('admin.jadwal.approve', $jadwal->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Catatan (Opsional)</label>
                                                                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">Setujui</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $jadwal->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tolak Jadwal</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('admin.jadwal.reject', $jadwal->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                                    <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" 
                                                                              rows="3" required></textarea>
                                                                    @error('catatan')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <form id="delete-form-{{ $jadwal->id }}" 
                                                  action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" 
                                                  method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada jadwal coaching</td>
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

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
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