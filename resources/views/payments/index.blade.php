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
        <!-- Form Filter -->
        <form method="GET" action="{{ route('payments.index') }}" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="per_page" class="col-form-label fw-semibold">Tampilkan:</label>
                </div>
                <div class="col-auto">
                    <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>

                <div class="col-auto">
                    <label for="sort_by" class="col-form-label fw-semibold">Urutkan berdasarkan:</label>
                </div>
                <div class="col-auto">
                    <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                        <option value="pembayaran.tanggal_pembayaran" {{ $sortBy == 'pembayaran.tanggal_pembayaran' ? 'selected' : '' }}>Tanggal Pembayaran</option>
                        <option value="pesanan.nama_pemesan" {{ $sortBy == 'pesanan.nama_pemesan' ? 'selected' : '' }}>Nama Pemesan</option>
                        <option value="pembayaran.jumlah_pembayaran" {{ $sortBy == 'pembayaran.jumlah_pembayaran' ? 'selected' : '' }}>Jumlah Bayar</option>
                    </select>
                </div>

                <div class="col-auto">
                    <select name="sort_order" class="form-select" onchange="this.form.submit()">
                        <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>A-Z / Terendah ke Tertinggi</option>
                        <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Z-A / Tertinggi ke Terendah</option>
                    </select>
                </div>

                <div class="col-auto ms-auto">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari ..."
                        value="{{ request('search') }}" oninput="this.form.submit()">
                </div>
            </div>
        </form>
        <!-- Table Section -->
        <div class="table-responsive rounded-3 overflow-hidden">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nomor Resi</th>
                        <th>Tanggal Bayar</th>
                        <th>Nama Pemesan</th>
                        <th>Metode</th>
                        <th>Jumlah Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($payments as $index => $item)
                        @if ($item->pembayaran) {{-- Pastikan pesanan memiliki pembayaran --}}
                            <tr class="border-bottom">
                                <td class="text-center">{{ $payments->firstItem() + $index }}</td>
                                <td class="text-center">{{ $item->nomor_resi }}</td>
                                <td class="text-center">
                                    @if ($item->pembayaran && 
                                        $item->pembayaran->status_pembayaran == 'Lunas' && 
                                        $item->pembayaran->tanggal_pembayaran)
                                        {{ \Carbon\Carbon::parse($item->pembayaran->tanggal_pembayaran)->format('d M Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->nama_pemesan }}</td>
                                <td class="text-center">{{ $item->pembayaran->metode_pembayaran }}</td>
                                <td class="text-end">Rp {{ number_format($item->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if ($item->pembayaran->status_pembayaran == 'Lunas')
                                        <span class="badge bg-success rounded-pill d-inline-flex align-items-center px-3 py-1">
                                            <i class="bi bi-check-circle me-1"></i> Lunas
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill d-inline-flex align-items-center px-3 py-1">
                                            <i class="bi bi-hourglass-split me-1"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPembayaran{{ $item->id }}" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 mb-2"></i><br>
                                Belum ada riwayat pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>    
            <!-- Pagination Section -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $payments->firstItem() }} sampai {{ $payments->lastItem() }} 
                    dari {{ $payments->total() }} hasil
                </div>
                
                <!-- Custom Pagination -->
                @if ($payments->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($payments->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="bi bi-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $payments->appends(request()->query())->previousPageUrl() }}">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $start = max($payments->currentPage() - 2, 1);
                                $end = min($start + 4, $payments->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if ($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $payments->appends(request()->query())->url(1) }}">1</a>
                                </li>
                                @if ($start > 2)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $payments->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link bg-primary border-primary">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $payments->appends(request()->query())->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            @if ($end < $payments->lastPage())
                                @if ($end < $payments->lastPage() - 1)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $payments->appends(request()->query())->url($payments->lastPage()) }}">
                                        {{ $payments->lastPage() }}
                                    </a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($payments->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $payments->appends(request()->query())->nextPageUrl() }}">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="bi bi-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>

    <!-- CSS untuk styling pagination -->
    <style>
    .pagination {
        --bs-pagination-padding-x: 0.75rem;
        --bs-pagination-padding-y: 0.5rem;
        --bs-pagination-font-size: 0.875rem;
        --bs-pagination-color: #6c757d;
        --bs-pagination-bg: #fff;
        --bs-pagination-border-width: 1px;
        --bs-pagination-border-color: #dee2e6;
        --bs-pagination-border-radius: 0.375rem;
        --bs-pagination-hover-color: #0056b3;
        --bs-pagination-hover-bg: #e9ecef;
        --bs-pagination-hover-border-color: #dee2e6;
        --bs-pagination-focus-color: #0056b3;
        --bs-pagination-focus-bg: #e9ecef;
        --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        --bs-pagination-active-color: #fff;
        --bs-pagination-active-bg: #0d6efd;
        --bs-pagination-active-border-color: #0d6efd;
        --bs-pagination-disabled-color: #6c757d;
        --bs-pagination-disabled-bg: #fff;
        --bs-pagination-disabled-border-color: #dee2e6;
    }

    .pagination .page-link {
        position: relative;
        display: block;
        color: var(--bs-pagination-color);
        text-decoration: none;
        background-color: var(--bs-pagination-bg);
        border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .pagination .page-link:hover {
        z-index: 2;
        color: var(--bs-pagination-hover-color);
        background-color: var(--bs-pagination-hover-bg);
        border-color: var(--bs-pagination-hover-border-color);
    }

    .pagination .page-link:focus {
        z-index: 3;
        color: var(--bs-pagination-focus-color);
        background-color: var(--bs-pagination-focus-bg);
        outline: 0;
        box-shadow: var(--bs-pagination-focus-box-shadow);
    }

    .pagination .page-item:not(:first-child) .page-link {
        margin-left: -1px;
    }

    .pagination .page-item:first-child .page-link {
        border-top-left-radius: var(--bs-pagination-border-radius);
        border-bottom-left-radius: var(--bs-pagination-border-radius);
    }

    .pagination .page-item:last-child .page-link {
        border-top-right-radius: var(--bs-pagination-border-radius);
        border-bottom-right-radius: var(--bs-pagination-border-radius);
    }

    .pagination .page-item.active .page-link {
        z-index: 3;
        color: var(--bs-pagination-active-color);
        background-color: var(--bs-pagination-active-bg);
        border-color: var(--bs-pagination-active-border-color);
    }

    .pagination .page-item.disabled .page-link {
        color: var(--bs-pagination-disabled-color);
        pointer-events: none;
        background-color: var(--bs-pagination-disabled-bg);
        border-color: var(--bs-pagination-disabled-border-color);
    }

    .pagination-sm {
        --bs-pagination-padding-x: 0.5rem;
        --bs-pagination-padding-y: 0.25rem;
        --bs-pagination-font-size: 0.875rem;
        --bs-pagination-border-radius: 0.25rem;
    }

    /* Responsive untuk mobile */
    @media (max-width: 576px) {
        .pagination {
            justify-content: center;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
    }</style>
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

@foreach ($payments as $item)
    @if ($item->pembayaran) {{-- Pastikan pesanan memiliki pembayaran --}}
        <div class="modal fade" id="modalDetailPembayaran{{ $item->id }}" tabindex="-1"
        aria-labelledby="modalDetailPembayaranLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <!-- Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalDetailPembayaranLabel{{ $item->id }}">
                            <i class="bi bi-credit-card me-2 text-white"> Detail Pembayaran</i>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body p-4">
                        <!-- Informasi Pembayaran -->
                        <div class="card mb-4 border-0 bg-light">
                            <div class="card-header bg-transparent border-0">
                                <h6 class="mb-0 text-muted">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Pembayaran
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <strong>Nama Pemesan:</strong><br>
                                        {{ $item->nama_pemesan }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Tanggal Pembayaran:</strong><br>
                                        {{ \Carbon\Carbon::parse($item->pembayaran->tanggal_pembayaran)->format('d M Y') }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Metode Pembayaran:</strong><br>
                                        {{ $item->pembayaran->metode_pembayaran }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Jumlah Bayar:</strong><br>
                                        <span class="text-success fw-bold">
                                            Rp {{ number_format($item->pembayaran->jumlah_pembayaran, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Status Pembayaran:</strong><br>
                                        @if ($item->pembayaran->status_pembayaran == 'Lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <strong>ID Transaksi:</strong><br>
                                        {{ $item->id }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Nomor Resi:</strong><br>
                                        {{ $item->nomor_resi }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Tutup
                        </button>
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