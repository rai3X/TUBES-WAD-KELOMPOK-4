@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Data Lomba</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Manajemen Lomba</li>
    </ol>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-trophy me-1"></i>
                Daftar Lomba
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLombaModal">
                <i class="fas fa-plus me-1"></i> Tambah Lomba
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="lombaTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lomba</th>
                            <th>Penyelenggara</th>
                            <th>Tingkat</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lomba as $index => $l)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $l->nama_lomba }}</td>
                            <td>{{ $l->penyelenggara }}</td>
                            <td>{{ $l->tingkat }}</td>
                            <td>{{ $l->tanggal_mulai->format('d/m/Y') }}</td>
                            <td>{{ $l->tanggal_selesai->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $l->status == 'Aktif' ? 'success' : 'secondary' }}">
                                    {{ $l->status }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" 
                                            class="btn btn-info btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewLombaModal{{ $l->id }}"
                                            title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editLombaModal{{ $l->id }}"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteLombaModal{{ $l->id }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewLombaModal{{ $l->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Lomba</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Nama Lomba</div>
                                                    <div class="col-md-8">{{ $l->nama_lomba }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Penyelenggara</div>
                                                    <div class="col-md-8">{{ $l->penyelenggara }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Tingkat</div>
                                                    <div class="col-md-8">{{ $l->tingkat }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Tanggal Mulai</div>
                                                    <div class="col-md-8">{{ $l->tanggal_mulai->format('d/m/Y') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Tanggal Selesai</div>
                                                    <div class="col-md-8">{{ $l->tanggal_selesai->format('d/m/Y') }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Deskripsi</div>
                                                    <div class="col-md-8">{{ $l->deskripsi }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Status</div>
                                                    <div class="col-md-8">
                                                        <span class="badge bg-{{ $l->status == 'Aktif' ? 'success' : 'secondary' }}">
                                                            {{ $l->status }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editLombaModal{{ $l->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Lomba</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.lomba.update', $l->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lomba <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="nama_lomba" value="{{ $l->nama_lomba }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Penyelenggara <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="penyelenggara" value="{{ $l->penyelenggara }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="tingkat" required>
                                                            <option value="Universitas" {{ $l->tingkat == 'Universitas' ? 'selected' : '' }}>Universitas</option>
                                                            <option value="Regional" {{ $l->tingkat == 'Regional' ? 'selected' : '' }}>Regional</option>
                                                            <option value="Nasional" {{ $l->tingkat == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                                            <option value="Internasional" {{ $l->tingkat == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="tanggal_mulai" value="{{ $l->tanggal_mulai->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="tanggal_selesai" value="{{ $l->tanggal_selesai->format('Y-m-d') }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Deskripsi</label>
                                                        <textarea class="form-control" name="deskripsi" rows="3">{{ $l->deskripsi }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="status" required>
                                                            <option value="Aktif" {{ $l->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="Tidak Aktif" {{ $l->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteLombaModal{{ $l->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Lomba</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.lomba.destroy', $l->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus lomba "{{ $l->nama_lomba }}"?</p>
                                                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Lomba Modal -->
<div class="modal fade" id="addLombaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Lomba Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.lomba.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lomba <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_lomba" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penyelenggara <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="penyelenggara" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                        <select class="form-select" name="tingkat" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="Universitas">Universitas</option>
                            <option value="Regional">Regional</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.badge {
    font-size: 0.875em;
    padding: 0.5em 0.75em;
}
.btn-group .btn {
    margin: 0 2px;
}
.table td {
    vertical-align: middle;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#lombaTable').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data yang ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});
</script>
@endpush

@endsection 