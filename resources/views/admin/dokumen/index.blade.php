@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Verifikasi Dokumen</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Verifikasi Dokumen</li>
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
                <i class="fas fa-file-alt me-1"></i>
                Daftar Dokumen Mahasiswa
            </div>
            <div>
                <select id="statusFilter" class="form-select form-select-sm" style="width: 200px;">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu Verifikasi</option>
                    <option value="terverifikasi">Terverifikasi</option>
                    <option value="revisi">Perlu Revisi</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dokumenTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Nama File</th>
                            <th>Jenis Dokumen</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dokumen as $index => $doc)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $doc->user->name }}</td>
                            <td>{{ $doc->namaFile }}</td>
                            <td>{{ $doc->jenisdokumen }}</td>
                            <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($doc->statusVerifikasi == 'terverifikasi')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif($doc->statusVerifikasi == 'revisi')
                                    <span class="badge bg-warning">Perlu Revisi</span>
                                @elseif($doc->statusVerifikasi == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <!-- Preview Button -->
                                    <a href="{{ route('admin.dokumen.show', $doc->dokumenid) }}" 
                                       class="btn btn-info btn-sm" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Verify Button -->
                                    @if($doc->statusVerifikasi != 'terverifikasi')
                                    <button type="button" 
                                            class="btn btn-success btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#verifyModal{{ $doc->dokumenid }}"
                                            title="Verifikasi">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    @endif

                                    <!-- Revision Button -->
                                    @if($doc->statusVerifikasi != 'revisi')
                                    <button type="button" 
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#revisionModal{{ $doc->dokumenid }}"
                                            title="Minta Revisi">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                    @endif

                                    <!-- Reject Button -->
                                    @if($doc->statusVerifikasi != 'ditolak')
                                    <button type="button" 
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $doc->dokumenid }}"
                                            title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif

                                    <!-- Delete Button -->
                                    <button type="button" 
                                            class="btn btn-dark btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $doc->dokumenid }}"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Verify Modal -->
                                <div class="modal fade" id="verifyModal{{ $doc->dokumenid }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Verifikasi Dokumen</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.dokumen.verify', $doc->dokumenid) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin memverifikasi dokumen ini?</p>
                                                    <div class="mb-3">
                                                        <label for="catatan" class="form-label">Catatan Verifikasi (Opsional)</label>
                                                        <textarea class="form-control" name="catatan" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Verifikasi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Revision Modal -->
                                <div class="modal fade" id="revisionModal{{ $doc->dokumenid }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Minta Revisi Dokumen</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.dokumen.revision', $doc->dokumenid) }}" method="POST">
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

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $doc->dokumenid }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tolak Dokumen</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.dokumen.reject', $doc->dokumenid) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="catatan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="catatan" rows="3" required></textarea>
                                                        <small class="text-muted">Berikan alasan mengapa dokumen ditolak</small>
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

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $doc->dokumenid }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Dokumen</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.dokumen.destroy', $doc->dokumenid) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus dokumen ini?</p>
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
            <div class="d-flex justify-content-end mt-3">
                {{ $dokumen->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

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
    // Initialize DataTable
    var table = $('#dokumenTable').DataTable({
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

    // Status Filter
    $('#statusFilter').on('change', function() {
        var status = $(this).val();
        table.column(5).search(status).draw();
    });
});
</script>
@endpush 