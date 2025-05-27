@extends('layouts.dashboard')
@section('title', 'Dashboard | Koka Laundry')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded shadow-sm p-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold">Riwayat Pembayaran</h3>
            <!-- <div>
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalTambahPembayaran">
                    <i class="bi bi-plus-circle"></i> Tambah Pembayaran
                </button>
                <button type="button" class="btn btn-success me-2">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
                <button type="button" class="btn btn-danger" id="btnHapusSemua">
                    <i class="bi bi-trash"></i> Hapus Semua
                </button>
            </div> -->
        </div>
        <!-- Table Section -->
        <div class="table-responsive rounded-3 overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Nama Pemesan</th>
                        <th>Metode Pembayaran</th>
                        <th>Jumlah Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanan as $index => $item)
                        @if ($item->pembayaran)
                            <tr class="animate__animated animate__fadeIn">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->pembayaran->tanggal_pembayaran)->format('d M Y') }}</td>
                                <td>{{ $item->nama_pemesan }}</td>
                                <td class="text-center">{{ $item->pembayaran->metode_pembayaran }}</td>
                                <td class="text-end">Rp {{ number_format($item->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if ($item->pembayaran->status_pembayaran == 'Lunas')
                                        <span class="badge bg-success rounded-pill">Lunas</span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#modalDetailPembayaran{{ $item->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <!-- <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete('')"> //
                                        <i class="bi bi-trash"></i>
                                    </button> -->
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 mb-2"></i><br>
                                Belum ada riwayat pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pembayaran -->
<div class="modal fade" id="modalTambahPembayaran" tabindex="-1" aria-labelledby="modalTambahPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="#" method="POST">
                @csrf
                <div class="modal-header bg-gradient text-white" style="background: linear-gradient(to right, #28a745, #6cdd8c);">
                    <h5 class="modal-title" id="modalTambahPembayaranLabel">Buat Pembayaran Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_pesanan" class="form-label">Nama Pemesan</label>
                            <select name="id_pesanan" class="form-select" required>
                                <option value="" disabled selected>Pilih Pesanan</option>
                                <option value="1">Rizky Ardiansyah</option>
                                <option value="2">Sari Dewi</option>
                                <option value="3">Andi Saputra</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" name="tanggal_pembayaran" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select" required>
                                <option value="">Pilih Metode</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="Cash">Cash</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                            <input type="number" class="form-control" name="jumlah_bayar" min="0" step="1000" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pembayaran</label>
                        <select name="status" class="form-select" required>
                            <option value="Lunas">Lunas</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($pesanan as $item)
    @if ($item->pembayaran) {{-- Pastikan pesanan memiliki pembayaran --}}
        <div class="modal fade" id="modalDetailPembayaran{{ $item->id }}" tabindex="-1" ...>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Nama Pemesan:</strong> {{ $item->nama_pemesan }}</div>
                            <div class="col-md-6"><strong>Tanggal:</strong> 
                                {{ \Carbon\Carbon::parse($item->pembayaran->tanggal_pembayaran)->format('d M Y') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Metode:</strong> {{ $item->pembayaran->metode_pembayaran }}</div>
                            <div class="col-md-6"><strong>Jumlah Bayar:</strong> Rp {{ number_format($item->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Status:</strong>
                                @if ($item->pembayaran->status_pembayaran == 'Lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </div>
                            <div class="col-md-6"><strong>ID Transaksi:</strong> {{ $item->id }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2 @11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus pembayaran ini?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aksi dummy, misal redirect atau reload
            location.reload();
        }
    });
}

document.getElementById('btnHapusSemua').addEventListener('click', function () {
    Swal.fire({
        title: 'Yakin ingin menghapus semua pembayaran?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus semua!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.bg-gradient {
    background: linear-gradient(to right, #28a745, #6cdd8c);
}
.table thead th {
    vertical-align: middle;
}
.animate__fadeIn {
    animation: fadeIn 0.3s ease-in-out;
}
</style>
@endpush