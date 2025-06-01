@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Manajemen Jadwal Coaching/Wawancara</h5>
                </div>
                <div class="card-body">
                    <!-- Form Pengajuan Jadwal -->
                    <div class="mb-4">
                        <h6 class="card-subtitle mb-3">Ajukan Jadwal Baru</h6>
                        <form action="{{ route('mahasiswa.jadwal.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <select name="lombaid" class="form-select @error('lombaid') is-invalid @enderror" required>
                                        <option value="">Pilih Lomba</option>
                                        @foreach($lombas as $lomba)
                                            <option value="{{ $lomba->id }}">{{ $lomba->nama_lomba }}</option>
                                        @endforeach
                                    </select>
                                    @error('lombaid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="coaching">Coaching</option>
                                        <option value="wawancara">Wawancara</option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                           required min="{{ date('Y-m-d') }}">
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <input type="time" name="waktu" class="form-control @error('waktu') is-invalid @enderror" required>
                                    @error('waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-plus-circle me-1"></i> Ajukan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Daftar Jadwal -->
                    <div>
                        <h6 class="card-subtitle mb-3">Daftar Jadwal</h6>
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
                                                @if($jadwal->status === 'pending')
                                                    <button type="button" class="btn btn-sm btn-info" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editModal{{ $jadwal->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                                @if($jadwal->status !== 'dibatalkan')
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="confirmDelete({{ $jadwal->id }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $jadwal->id }}" 
                                                          action="{{ route('mahasiswa.jadwal.destroy', $jadwal->id) }}" 
                                                          method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                                @if($jadwal->status === 'dibatalkan')
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="confirmPermanentDelete({{ $jadwal->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="permanent-delete-form-{{ $jadwal->id }}" 
                                                          action="{{ route('mahasiswa.jadwal.delete', $jadwal->id) }}" 
                                                          method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        @if($jadwal->status === 'pending')
                                            <div class="modal fade" id="editModal{{ $jadwal->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Jadwal</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('mahasiswa.jadwal.update', $jadwal->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal</label>
                                                                    <input type="date" name="tanggal" class="form-control" 
                                                                           required min="{{ date('Y-m-d') }}"
                                                                           value="{{ $jadwal->tanggal_waktu->format('Y-m-d') }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Waktu</label>
                                                                    <input type="time" name="waktu" class="form-control" 
                                                                           required value="{{ $jadwal->tanggal_waktu->format('H:i') }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada jadwal yang diajukan</td>
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
    if (confirm('Apakah Anda yakin ingin membatalkan jadwal ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

function confirmPermanentDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus jadwal ini secara permanen? Tindakan ini tidak dapat dibatalkan.')) {
        document.getElementById('permanent-delete-form-' + id).submit();
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