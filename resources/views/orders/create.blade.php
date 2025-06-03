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
                    </select>
                </div>

                <div class="col-auto">
                    <select name="sort_order" class="form-select" onchange="this.form.submit()">
                        @if (empty($sortOrder))
                            <option value="" selected hidden>Pilih Urutan</option>
                        @endif
                        <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Terendah ke Tertinggi</option>
                        <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Tertinggi ke Terendah</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="table-responsive rounded-3 overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>No. Handphone</th>
                        <th>Alamat</th>
                        <th>Berat (Kg)</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanan as $history => $item)
                        <tr class="animate__animated animate__fadeIn">
                            <td class="text-center">{{ $pesanan->firstItem() + $history }}</td>
                            <td>{{ $item->nama_pemesan }}</td>
                            <td class="text-center">{{ $item->no_hp }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td class="text-center">{{ $item->berat }}</td>
                            <td class="text-center">{{ $item->layanan->nama_layanan ?? '-'}}</td>
                            <td class="text-center">
                                @php
                                    $status = $item->status;
                                @endphp
                                @if ($status == 'Selesai')
                                    <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Proses')
                                    <span class="badge bg-warning text-dark rounded-pill">
                                        <i class="bi bi-gear-wide-connected me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Konfirmasi Admin')
                                    <span class="badge bg-secondary rounded-pill">
                                        <i class="bi bi-person-check me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Dalam Pengantaran')
                                    <span class="badge bg-primary rounded-pill">
                                        <i class="bi bi-box-seam me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Dalam Penjemputan')
                                    <span class="badge bg-info text-dark rounded-pill">
                                        <i class="bi bi-truck me-1"></i> {{ $status }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark rounded-pill">
                                        {{ $status }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal" data-bs-target="#modalDetailPesanan{{ $item['id'] }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEditPesanan{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('orders.destroy', $item->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ $item->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 mb-2"></i><br>
                                Belum ada data pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pesanan -->
<div class="modal fade" id="modalTambahPesanan" tabindex="-1" aria-labelledby="modalTambahPesananLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-gradient text-white" style="background: linear-gradient(to right, #007bff, #00c6ff);">
                    <h5 class="modal-title" id="modalTambahPesananLabel">Buat Pesanan Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                            <input type="text" class="form-control form-control-lg" id="nama_pemesan" name="nama_pemesan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label">Nomor Handphone</label>
                            <input type="text" class="form-control form-control-lg" id="no_hp" name="no_hp" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_layanan" class="form-label">Jenis Layanan</label>
                            <select name="id_layanan" id="id_layanan" class="form-control form-control-lg" required>
                                <option value="">Pilih Layanan</option>
                                @foreach ($layanans as $layanan)
                                    <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                            <input type="date" class="form-control form-control-lg" id="tanggal_pemesanan" name="tanggal_pemesanan" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="berat" class="form-label">Berat (Kg)</label>
                            <input type="number" class="form-control form-control-lg" id="berat" name="berat" min="0.1" step="0.1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="diskon" class="form-label">Diskon (%)</label>
                            <input type="number" class="form-control form-control-lg" id="diskon" name="diskon" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                <option value="">Pilih Metode</option>
                                <option value="Cash">Cash</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Debit">Debit</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buat Pesanan</button>
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
                <div class="modal-header bg-gradient text-white" style="background: linear-gradient(to right, #28a745, #66bb6a);">
                    <h5 class="modal-title" id="modalDetailPesananLabel{{ $item->id }}">Detail Pesanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6"><strong>Nomor Resi:</strong> {{ $item->nomor_resi }}</div>
                        <div class="col-md-6"><strong>Nama Pemesan:</strong> {{ $item->nama_pemesan }}</div>
                        <div class="col-md-6"><strong>No. Handphone:</strong> {{ $item->no_hp }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"><strong>Alamat:</strong> {{ $item->alamat }}</div>
                        <div class="col-md-6"><strong>Catatan:</strong> {{ $item->catatan }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"><strong>Jenis Layanan:</strong>
                            @if ($item->layanan)
                                {{ $item->layanan->nama_layanan }}
                            @else
                                - Tidak ditemukan -
                            @endif
                        </div>
                        <div class="col-md-6"><strong>Harga Per Kg:</strong>
                            @if ($item->layanan)
                               <b style="color: #28a745;">Rp {{ number_format($item->layanan->harga, 0, ',', '.') }}</b>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"><strong>Berat:</strong> {{ $item->berat }} Kg</div>
                        <div class="col-md-6"><strong>Diskon:</strong> {{ $item->diskon ?? '0' }}%</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6"><strong>Total Bayar:</strong>
                        <b style="color: #28a745;">
                            @php
                                if ($item->layanan) {
                                    $total = $item->berat * $item->layanan->harga;
                                    $total -= $total * ($item->diskon / 100);
                                    echo 'Rp ' . number_format($total, 0, ',', '.');
                                } else {
                                    echo '-';
                                }
                            @endphp
                        </b>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Metode Pembayaran:</strong>
                                @if ($item->pembayaran)
                                    {{ $item->pembayaran->metode_pembayaran }}
                                @else
                                    - Belum ada pembayaran -
                                @endif
                            </div>
                            <div class="col-md-6"><strong>Status Pemesanan:</strong>
                                @php
                                    $status = $item->status;
                                @endphp
                                @if ($status == 'Selesai')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Proses')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-gear-wide-connected me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Konfirmasi Admin')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-person-check me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Dalam Pengantaran')
                                    <span class="badge bg-primary">
                                        <i class="bi bi-box-seam me-1"></i> {{ $status }}
                                    </span>
                                @elseif ($status == 'Dalam Penjemputan')
                                    <span class="badge bg-info text-dark">
                                        <i class="bi bi-truck me-1"></i> {{ $status }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark">
                                        {{ $status }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6"><strong>Tanggal Pemesanan:</strong>
                            {{ \Carbon\Carbon::parse($item->tanggal_pemesanan)->format('d M Y') }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
                    <div class="modal-header bg-gradient text-white" style="background: linear-gradient(to right, #ffc107, #fba540);">
                        <h5 class="modal-title" id="modalEditPesananLabel{{ $item->id }}">Edit Pesanan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control" name="nama_pemesan" value="{{ $item->nama_pemesan }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="no_hp" class="form-label">Nomor Handphone</label>
                                <input type="text" class="form-control" name="no_hp" value="{{ $item->no_hp }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ $item->alamat }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="id_layanan" class="form-label">Jenis Layanan</label>
                            <select name="id_layanan" id="id_layanan" class="form-control form-control-lg" required>
                                <option value="">Pilih Layanan</option>
                                @foreach ($layanans as $layanan)
                                    <option value="{{ $layanan->id }}" {{ $item->id_layanan == $layanan->id ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="berat" class="form-label">Berat (Kg)</label>
                                <input type="number" class="form-control" name="berat" value="{{ $item->berat }}" min="0.1" step="0.1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="diskon" class="form-label">Diskon (%)</label>
                                <input type="number" class="form-control" name="diskon" value="{{ $item->diskon }}" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                                <option value="">Pilih Status</option>
                                <option value="Belum Bayar" {{ $item->pembayaran && $item->pembayaran->status_pembayaran == 'Belum Bayar' ? 'selected' : '' }}>
                                    Belum Bayar
                                </option>
                                <option value="Lunas" {{ $item->pembayaran && $item->pembayaran->status_pembayaran == 'Lunas' ? 'selected' : '' }}>
                                    Lunas
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="Konfirmasi Admin" {{ $item->status == 'Konfirmasi Admin' ? 'selected' : '' }}>Konfirmasi Admin</option>
                                <option value="Dalam Penjemputan" {{ $item->status == 'Dalam Penjemputan' ? 'selected' : '' }}>Dalam Penjemputan</option>
                                <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Dalam Pengantaran" {{ $item->status == 'Dalam Pengantaran' ? 'selected' : '' }}>Dalam Pengantaran</option>
                                <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
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