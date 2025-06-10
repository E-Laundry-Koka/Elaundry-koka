@extends('layouts.dashboard')
@section('title', 'Dashboard | Koka Laundry')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded shadow-sm p-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold">Daftar Pesanan</h3>
            <div>
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalTambahPesanan">
                    <i class="bi bi-plus-circle"></i> Tambah Pesanan
                </button>
                <a href="{{ route('orders.export') }}" class="btn btn-success" download>
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
            </div>
        </div>

        <!-- Table Section -->
        <form method="GET" action="{{ route('orders.create') }}" class="mb-3">
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
                        @if (empty($sortOrder))
                            <option value="" selected hidden>Pilih Urutan</option>
                        @endif
                        <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>Tanggal</option>
                        <option value="nama_pemesan" {{ $sortBy == 'nama_pemesan' ? 'selected' : '' }}>Nama Pemesan</option>
                        <option value="id_layanan" {{ $sortBy == 'id_layanan' ? 'selected' : '' }}>Layanan</option>
                        <option value="status" {{ $sortBy == 'status' ? 'selected' : '' }}>Status Pesanan</option>
                    </select>
                </div>

                <div class="col-auto">
                    <select name="sort_order" class="form-select" onchange="this.form.submit()">
                        @if (empty($sortOrder))
                            <option value="" selected hidden>Pilih Urutan</option>
                        @endif
                        <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>A-Z/Terendah ke Tertinggi</option>
                        <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Z-A/Tertinggi ke Terendah</option>
                    </select>
                </div>

                <div class="col-auto ms-auto">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari ..." value="{{ request('search') }}" oninput="this.form.submit()">
                </div>
            </div>
        </form>

        <div class="table-responsive rounded-3 overflow-hidden">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 15%">No. Resi</th>
                        <th style="width: 15%">Nama Pemesan</th>
                        <th style="width: 12%">No. Handphone</th>
                        <th style="width: 10%">Alamat</th>
                        <th style="width: 8%">Berat (Kg)</th>
                        <th style="width: 12%">Layanan</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 13%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($pesanan as $history => $item)
                        <tr class="border-bottom">
                            <td class="text-center">{{ $pesanan->firstItem() + $history }}</td>
                            <td>{{ $item->nomor_resi }}</td>
                            <td>{{ $item->nama_pemesan }}</td>
                            <td class="text-center">{{ $item->no_hp }}</td>
                            <td class="text-truncate" style="max-width: 150px;">{{ $item->alamat }}</td>
                            <td class="text-center">{{ $item->berat }}</td>
                            <td class="text-center">{{ $item->layanan->nama_layanan ?? '-' }}</td>
                            <td class="text-center">
                                @php
                                    $status = $item->status;
                                @endphp
                                @if ($status == 'Selesai')
                                    <span class="badge bg-success rounded-pill d-inline-flex align-items-center px-3 py-1">
                                        <i class="bi bi-check-circle me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Proses')
                                    <span class="badge bg-warning text-dark rounded-pill d-inline-flex align-items-center px-3 py-1">
                                        <i class="bi bi-gear-wide-connected me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Konfirmasi Admin')
                                    <span class="badge bg-secondary rounded-pill d-inline-flex align-items-center px-3 py-1">
                                        <i class="bi bi-person-check me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Dalam Pengantaran')
                                    <span class="badge bg-primary rounded-pill d-inline-flex align-items-center px-3 py-1">
                                        <i class="bi bi-box-seam me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Dalam Penjemputan')
                                    <span class="badge bg-info text-dark rounded-pill d-inline-flex align-items-center px-3 py-1">
                                        <i class="bi bi-truck me-1"></i> {{ $status }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark border rounded-pill d-inline-flex align-items-center px-3 py-1">
                                        {{ $status }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal"
                                    data-bs-target="#modalDetailPesanan{{ $item->id }}" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal"
                                    data-bs-target="#modalEditPesanan{{ $item->id }}" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('orders.destroy', $item->id) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus"
                                    onclick="confirmDelete('{{ $item->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 mb-2"></i><br>
                                Belum ada data pesanan.
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
                    Menampilkan {{ $pesanan->firstItem() }} sampai {{ $pesanan->lastItem() }} 
                    dari {{ $pesanan->total() }} hasil
                </div>
                
                <!-- Custom Pagination -->
                @if ($pesanan->hasPages())
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($pesanan->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="bi bi-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pesanan->appends(request()->query())->previousPageUrl() }}">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $start = max($pesanan->currentPage() - 2, 1);
                                $end = min($start + 4, $pesanan->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if ($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pesanan->appends(request()->query())->url(1) }}">1</a>
                                </li>
                                @if ($start > 2)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $pesanan->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link bg-primary border-primary">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pesanan->appends(request()->query())->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            @if ($end < $pesanan->lastPage())
                                @if ($end < $pesanan->lastPage() - 1)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pesanan->appends(request()->query())->url($pesanan->lastPage()) }}">
                                        {{ $pesanan->lastPage() }}
                                    </a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($pesanan->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $pesanan->appends(request()->query())->nextPageUrl() }}">
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

<!-- Modal Tambah Pesanan -->
<div class="modal fade" id="modalTambahPesanan" tabindex="-1"
    aria-labelledby="modalTambahPesananLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahPesananLabel">
                        <i class="bi bi-receipt me-2 text-white"> Buat Pesanan Baru</i>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4">

                    <!-- Alert Error -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Informasi Pelanggan -->
                    <div class="card mb-4 border-0 bg-light">
                        <div class="card-header bg-transparent border-0">
                            <h6 class="mb-0 text-muted">
                                <i class="bi bi-person me-2"></i>Informasi Pelanggan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                                    <input type="text" class="form-control form-control-lg" id="nama_pemesan"
                                        name="nama_pemesan" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label">Nomor Handphone</label>
                                    <input type="text" class="form-control form-control-lg" id="no_hp" name="no_hp"
                                        placeholder="e.g. 081234567890" minlength="12" maxlength="13"
                                        pattern="^08\d{10,11}$" title="Masukkan nomor telepon dengan benar" required>
                                </div>
                                <div class="col-12">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Layanan -->
                    <div class="card mb-4 border-0 bg-light">
                        <div class="card-header bg-transparent border-0">
                            <h6 class="mb-0 text-muted">
                                <i class="bi bi-gear me-2"></i>Detail Layanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="id_layanan" class="form-label">Jenis Layanan</label>
                                    <select name="id_layanan" id="id_layanan"
                                        class="form-select form-select-lg" required>
                                        <option value="">Pilih Layanan</option>
                                        @foreach ($layanans as $layanan)
                                            <option value="{{ $layanan->id }}">
                                                {{ $layanan->nama_layanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                                    <input type="date" class="form-control form-control-lg" id="tanggal_pemesanan"
                                        name="tanggal_pemesanan" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="berat" class="form-label">Berat (Kg)</label>
                                    <input type="number" class="form-control form-control-lg" id="berat" name="berat"
                                        min="0.1" step="0.1" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="diskon" class="form-label">Diskon (%)</label>
                                    <input type="number" class="form-control form-control-lg" id="diskon" name="diskon"
                                        min="0" value="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pembayaran & Lokasi -->
                    <div class="card mb-4 border-0 bg-light">
                        <div class="card-header bg-transparent border-0">
                            <h6 class="mb-0 text-muted">
                                <i class="bi bi-info-circle me-2"></i>Lainnya
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran"
                                        class="form-select form-select-lg" required>
                                        <option value="">Pilih Metode</option>
                                        <option value="Tunai">Cash</option>
                                        <option value="Transfer">Transfer</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="id_lokasi" class="form-label">Lokasi Cabang</label>
                                    <select name="id_lokasi" id="id_lokasi" class="form-select form-select-lg" required>
                                        <option value="">Pilih Lokasi</option>
                                        @foreach ($lokasiList as $location)
                                            <option value="{{ $location->id }}">{{ $location->nama_lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                                    <textarea name="catatan" id="catatan" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-danger px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-cart-plus me-2"></i>Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($pesanan as $item)
    <!-- Modal Detail Pesanan -->
    <div class="modal fade" id="modalDetailPesanan{{ $item->id }}" tabindex="-1"
     aria-labelledby="modalDetailPesananLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalDetailPesananLabel{{ $item->id }}">
                        <i class="bi bi-receipt me-2 text-white"> Detail Pesanan</i>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4">
                    <!-- Informasi Pesanan -->
                    <div class="card mb-4 border-0 bg-light">
                        <div class="card-header bg-transparent border-0">
                            <h6 class="mb-0 text-muted">
                                <i class="bi bi-info-circle me-2"></i>Informasi Pesanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Nomor Resi:</strong><br>
                                    <span class="text-primary">{{ $item->nomor_resi }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Tanggal Pemesanan:</strong><br>
                                    {{ \Carbon\Carbon::parse($item->tanggal_pemesanan)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pelanggan -->
                    <div class="card mb-4 border-0 bg-light">
                        <div class="card-header bg-transparent border-0">
                            <h6 class="mb-0 text-muted">
                                <i class="bi bi-person me-2"></i>Informasi Pelanggan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Nama Pemesan:</strong><br>
                                    {{ $item->nama_pemesan }}
                                </div>
                                <div class="col-md-6">
                                    <strong>No. Handphone:</strong><br>
                                    {{ $item->no_hp }}
                                </div>
                                <div class="col-12">
                                    <strong>Alamat:</strong><br>
                                    {{ $item->alamat }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Cabang:</strong><br>
                                    @if ($item->lokasi)
                                        {{ $item->lokasi->nama_lokasi }}
                                    @else
                                        <span class="text-muted">- Tidak ditemukan -</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Catatan:</strong><br>
                                    {{ $item->catatan ?: '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Layanan -->
                    <div class="card mb-4 border-0 bg-light">
                        <div class="card-header bg-transparent border-0">
                            <h6 class="mb-0 text-muted">
                                <i class="bi bi-gear me-2"></i>Detail Layanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Jenis Layanan:</strong><br>
                                    @if ($item->layanan)
                                        {{ $item->layanan->nama_layanan }}
                                    @else
                                        <span class="text-muted">- Tidak ditemukan -</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Harga Per Kg:</strong><br>
                                    @if ($item->layanan)
                                        <span class="text-success fw-bold">
                                            Rp {{ number_format($item->layanan->harga, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Berat:</strong><br>
                                    {{ $item->berat }} Kg
                                </div>
                                <div class="col-md-6">
                                    <strong>Diskon:</strong><br>
                                    {{ $item->diskon ?? '0' }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pembayaran -->
                    <div class="card mb-4 border-0 bg-light">
                        <div class="card-header bg-transparent border-0">
                            <h6 class="mb-0 text-muted">
                                <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Metode Pembayaran:</strong><br>
                                    @if ($item->pembayaran)
                                        {{ $item->pembayaran->metode_pembayaran }}
                                    @else
                                        <span class="text-muted">- Belum ada pembayaran -</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Total Bayar:</strong><br>
                                    <span class="text-success fw-bold fs-5">
                                        @php
                                            if ($item->layanan) {
                                                $total = $item->berat * $item->layanan->harga;
                                                $total -= $total * ($item->diskon / 100);
                                                echo 'Rp ' . number_format($total, 0, ',', '.');
                                            } else {
                                                echo '-';
                                            }
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pesanan -->
                    <div class="card border-0 bg-light">
                        <div class="card-header bg-transparent border-0">
                            <h6 class="mb-0 text-muted">
                                <i class="bi bi-flag me-2"></i>Status Pesanan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                @php
                                    $status = $item->status;
                                @endphp
                                @if ($status == 'Selesai')
                                    <span class="badge bg-success fs-6 px-3 py-2">
                                        <i class="bi bi-check-circle me-2"></i>{{ $status }}
                                    </span>
                                @elseif ($status == 'Proses')
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                        <i class="bi bi-gear-wide-connected me-2"></i>{{ $status }}
                                    </span>
                                @elseif ($status == 'Konfirmasi Admin')
                                    <span class="badge bg-secondary fs-6 px-3 py-2">
                                        <i class="bi bi-person-check me-2"></i>{{ $status }}
                                    </span>
                                @elseif ($status == 'Dalam Pengantaran')
                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                        <i class="bi bi-box-seam me-2"></i>{{ $status }}
                                    </span>
                                @elseif ($status == 'Dalam Penjemputan')
                                    <span class="badge bg-info text-dark fs-6 px-3 py-2">
                                        <i class="bi bi-truck me-2"></i>{{ $status }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                                        {{ $status }}
                                    </span>
                                @endif
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
@endforeach

@foreach ($pesanan as $item)
    <!-- Modal Edit Per Pesanan -->
    <div class="modal fade" id="modalEditPesanan{{ $item->id }}" tabindex="-1"
    aria-labelledby="modalEditPesananLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form action="{{ route('orders.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalEditPesananLabel{{ $item->id }}">
                            <i class="bi bi-pencil-square me-2 text-white"> Edit Pesanan</i>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body p-4">

                        <!-- Informasi Pelanggan -->
                        <div class="card mb-4 border-0 bg-light">
                            <div class="card-header bg-transparent border-0">
                                <h6 class="mb-0 text-muted">
                                    <i class="bi bi-person me-2"></i>Informasi Pelanggan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                                        <input type="text" class="form-control form-control-lg" name="nama_pemesan"
                                            value="{{ $item->nama_pemesan }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_hp" class="form-label">Nomor Handphone</label>
                                        <input type="text" class="form-control form-control-lg" name="no_hp"
                                            value="{{ $item->no_hp }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="3" required>{{ $item->alamat }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Layanan -->
                        <div class="card mb-4 border-0 bg-light">
                            <div class="card-header bg-transparent border-0">
                                <h6 class="mb-0 text-muted">
                                    <i class="bi bi-gear me-2"></i>Detail Layanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="id_lokasi" class="form-label">Lokasi Cabang</label>
                                        <select class="form-select form-select-lg" id="id_lokasi" name="id_lokasi" required>
                                            <option value="">Pilih Lokasi</option>
                                            @foreach ($lokasiList as $location)
                                                <option value="{{ $location->id }}"
                                                    {{ $item->id_lokasi == $location->id ? 'selected' : '' }}>
                                                    {{ $location->nama_lokasi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="id_layanan" class="form-label">Jenis Layanan</label>
                                        <select name="id_layanan" id="id_layanan" class="form-select form-select-lg" required>
                                            <option value="">Pilih Layanan</option>
                                            @foreach ($layanans as $layanan)
                                                <option value="{{ $layanan->id }}"
                                                    {{ $item->id_layanan == $layanan->id ? 'selected' : '' }}>
                                                    {{ $layanan->nama_layanan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="berat" class="form-label">Berat (Kg)</label>
                                        <input type="number" class="form-control form-control-lg" name="berat"
                                            value="{{ $item->berat }}" min="0.1" step="0.1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="diskon" class="form-label">Diskon (%)</label>
                                        <input type="number" class="form-control form-control-lg" name="diskon"
                                            value="{{ $item->diskon }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Pembayaran -->
                        <div class="card mb-4 border-0 bg-light">
                            <div class="card-header bg-transparent border-0">
                                <h6 class="mb-0 text-muted">
                                    <i class="bi bi-flag me-2"></i>Status & Pembayaran
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                        <select name="status_pembayaran" id="status_pembayaran"
                                            class="form-select form-select-lg" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Belum Bayar"
                                                {{ $item->pembayaran && $item->pembayaran->status_pembayaran == 'Belum Bayar' ? 'selected' : '' }}>
                                                Belum Bayar
                                            </option>
                                            <option value="Lunas"
                                                {{ $item->pembayaran && $item->pembayaran->status_pembayaran == 'Lunas' ? 'selected' : '' }}>
                                                Lunas
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select form-select-lg" name="status" required>
                                            <option value="Konfirmasi Admin"
                                                {{ $item->status == 'Konfirmasi Admin' ? 'selected' : '' }}>Konfirmasi Admin
                                            </option>
                                            <option value="Dalam Penjemputan"
                                                {{ $item->status == 'Dalam Penjemputan' ? 'selected' : '' }}>Dalam Penjemputan
                                            </option>
                                            <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Proses
                                            </option>
                                            <option value="Dalam Pengantaran"
                                                {{ $item->status == 'Dalam Pengantaran' ? 'selected' : '' }}>Dalam Pengantaran
                                            </option>
                                            <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-outline-danger px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection

@push('styles')
<style>
.bg-gradient {
    background: linear-gradient(to right, #007bff, #00c6ff);
}
.table thead th {
    vertical-align: middle;
}
.animate__fadeIn {
    animation: fadeIn 0.3s ease-in-out;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush