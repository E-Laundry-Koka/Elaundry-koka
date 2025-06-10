@extends('layouts.dashboard')
@section('title', 'Dashboard | Koka Laundry')
@section('content')
<style>
    /* Override Bootstrap Colors */
    :root {
        --bs-primary: rgb(0, 126, 205);
        --bs-primary-rgb: 0, 126, 205;
    }

    .bg-primary {
        background-color: var(--bs-primary) !important;
    }

    .text-primary {
        color: var(--bs-primary) !important;
    }

    .border-primary {
        border-color: var(--bs-primary) !important;
    }

    .btn-primary,
    .btn-outline-primary {
        background-color: var(--bs-primary) !important;
        color: #fff !important;
        border-color: var(--bs-primary) !important;
    }

    .btn-outline-primary:hover {
        background-color: #fff !important;
        color: var(--bs-primary) !important;
    }

    /* Custom Banner & Widgets */
    .bg-primary.rounded.p-4.text-white {
        background-color: var(--bs-primary) !important;
        color: white !important;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(var(--bs-primary-rgb), 0.3) !important;
    }

    /* Table Hover */
    .table-hover tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.05);
    }

    /* Modal Header Gradient */
    .modal-header.bg-gradient {
        background: linear-gradient(to right, var(--bs-primary), rgb(0, 90, 170)) !important;
    }

    /* Calendar Day Badge */
    .badge.bg-primary {
        background-color: var(--bs-primary) !important;
    }
</style>
    <!-- Welcome Banner Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="col-12">
                <div class="bg-primary rounded p-4 text-white position-relative overflow-hidden">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="text-white mb-2">Selamat Datang di Dashboard Koka Laundry! 👋</h4>
                            <p class="mb-0 text-light">Kelola bisnis laundry Anda dengan mudah dan efisien</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-inline-block">
                                <i class="fa fa-tshirt fa-3x text-white opacity-25"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative Elements -->
                    <!-- <div class="position-absolute top-0 end-0 m-3">
                        <div class="bg-white bg-opacity-10 rounded-circle" style="width: 60px; height: 60px;"></div>
                    </div>
                    <div class="position-absolute bottom-0 start-0 m-3">
                        <div class="bg-white bg-opacity-10 rounded-circle" style="width: 40px; height: 40px;"></div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Welcome Banner End -->

    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-primary border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Total Pesanan Hari Ini</p>
                            <h4 class="mb-0 fw-bold text-primary" data-toggle="counter-up">{{ $totalPesanan ?? '0' }}</h4>
                            <small class="text-primary"><i class="fa fa-calendar me-1"></i>{{ date('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-info border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-coins fa-2x text-info"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Pendapatan Hari Ini</p>
                            <h5 class="mb-0 fw-bold text-info" data-toggle="counter-up">
                                Rp {{ number_format($totalpendapatanhariini ?? 0, 0, ',', '.') }}
                            </h5>
                            <small class="text-info"><i class="fa fa-calendar me-1"></i>{{ date('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-success border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-chart-line fa-2x text-success"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Est. Pendapatan/hari</p>
                            <h5 class="mb-0 fw-bold text-success" data-toggle="counter-up">Rp {{ number_format($estimasitotalPendapatanPerHari ?? 0, 0, ',', '.') }}</h5>
                            <small class="text-success"><i class="fa fa-calendar me-1"></i>{{ date('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-warning border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-wallet fa-2x text-warning"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Total Seluruh Pendapatan</p>
                            <h5 class="mb-0 fw-bold text-warning" data-toggle="counter-up">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-secondary border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-hourglass-start fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Konfirmasi Admin</p>
                            <h4 class="mb-0 fw-bold text-secondary">{{ $totalKonfirmasi ?? '0' }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-primary border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-truck-pickup fa-2x text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Pesanan Dalam Penjemputan</p>
                            <h4 class="mb-0 fw-bold text-primary">{{ $totalPenjemputan ?? '0' }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-dark border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-cog fa-2x text-dark"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Pesanan Dalam Proses</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $totalProses ?? '0' }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-info border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-shipping-fast fa-2x text-info"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Pesanan Dalam Pengantaran</p>
                            <h4 class="mb-0 fw-bold text-info">{{ $totalPengantaran ?? '0' }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 border-start border-success border-4 hover-shadow transition-all">
                    <div class="d-flex align-items-center">
                        <div class="p-3 me-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-muted small">Pesanan Selesai</p>
                            <h4 class="mb-0 fw-bold text-success">{{ $totalSelesai ?? '0' }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sale & Revenue End -->

    <!-- Quick Actions Start -->
    <!-- <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <h6 class="mb-4"><i class="fa fa-bolt text-primary me-2"></i>Aksi Cepat</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-primary w-100 p-3 text-start">
                                <i class="fa fa-plus-circle fa-2x mb-2 d-block"></i>
                                <div>
                                    <strong>Pesanan Baru</strong>
                                    <small class="d-block text-muted">Tambah pesanan laundry</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-success w-100 p-3 text-start">
                                <i class="fa fa-users fa-2x mb-2 d-block"></i>
                                <div>
                                    <strong>Data Pelanggan</strong>
                                    <small class="d-block text-muted">Kelola data pelanggan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-info w-100 p-3 text-start">
                                <i class="fa fa-cog fa-2x mb-2 d-block"></i>
                                <div>
                                    <strong>Layanan</strong>
                                    <small class="d-block text-muted">Atur jenis layanan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-warning w-100 p-3 text-start">
                                <i class="fa fa-chart-bar fa-2x mb-2 d-block"></i>
                                <div>
                                    <strong>Laporan</strong>
                                    <small class="d-block text-muted">Lihat laporan lengkap</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Quick Actions End -->

    <!-- Recent Orders Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0"><i class="fa fa-clock text-primary me-2"></i>Pesanan Terbaru</h6>
                <a href="{{ route('orders.create') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID Pesanan</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Layanan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Total</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanan as $item)
                            <tr>
                                <!-- ID Pesanan -->
                                <td><span class="badge bg-primary">{{ $item->nomor_resi }}</span></td>

                                <!-- Pelanggan -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <strong>{{ $item->nama_pemesan }}</strong>
                                    </div>
                                </td>

                                <!-- Layanan -->
                                <td>{{ $item->layanan->nama_layanan ?? '-' }}</td>

                                <!-- Status -->
                                <td>
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

                                <!-- Total -->
                                <td>
                                    <b>
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
                                </td>

                                <!-- Tanggal -->
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pemesanan)->format('d M Y') }}</td>

                                <!-- Aksi -->
                                <td>
                                    <button class="btn btn-sm btn-outline-info me-1" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailPesanan{{ $item->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
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
    <!-- Recent Orders End -->

    <!-- Widgets Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">

            <!-- Calendar Widget -->
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4 border-top border-success border-3">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0"><i class="fa fa-calendar text-success me-2"></i>Kalender</h6>
                        <a href="#" class="text-success small">Jadwal Lengkap</a>
                    </div>

                    <div id="calendar" class="text-center">
                        <!-- Bulan dan Tahun -->
                        <div class="row g-1 mb-3">
                            <div class="col text-center">
                                <strong class="text-primary">{{ date('F Y') }}</strong>
                            </div>
                        </div>

                        <!-- Header Hari -->
                        <div class="row g-1 text-center small fw-bold text-muted mb-2">
                            <div class="col">Sen</div>
                            <div class="col">Sel</div>
                            <div class="col">Rab</div>
                            <div class="col">Kam</div>
                            <div class="col">Jum</div>
                            <div class="col">Sab</div>
                            <div class="col">Min</div>
                        </div>

                        <!-- Tanggal -->
                        @php
                            $month = date('m');
                            $year = date('Y');
                            $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            $dayOfWeek = date('w', $firstDayOfMonth); // 0=minggu, 1=senin, dst...
                            $dayOfWeek = ($dayOfWeek == 0) ? 6 : $dayOfWeek - 1; // sesuaikan agar Senin = 0
                            $totalCells = $dayOfWeek + $daysInMonth;
                            $totalRows = ceil($totalCells / 7);
                        @endphp

                        <!-- Loop untuk setiap baris minggu -->
                        @for($week = 0; $week < $totalRows; $week++)
                            <div class="row g-1 text-center small mb-1">
                                @for($day = 0; $day < 7; $day++)
                                    @php
                                        $cellIndex = ($week * 7) + $day;
                                        $date = $cellIndex - $dayOfWeek + 1;
                                    @endphp
                                    
                                    <div class="col p-1">
                                        @if($cellIndex < $dayOfWeek || $date > $daysInMonth)
                                            <!-- Sel kosong untuk hari di luar bulan -->
                                            &nbsp;
                                        @else
                                            @if($date == date('d'))
                                                <span class="badge bg-primary rounded-circle">{{ $date }}</span>
                                            @else
                                                {{ $date }}
                                            @endif
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Widgets End -->
    @foreach ($pesanan as $item)
        <!-- Modal Detail Pesanan -->
        <div class="modal fade" id="modalDetailPesanan{{ $item->id }}" tabindex="-1"
        aria-labelledby="modalDetailPesananLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <!-- Header -->
                    <div class="modal-header bg-gradient text-white" style="background: linear-gradient(to right, #28a745, #66bb6a);">
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
                                        <strong>Nama Pemesan:</strong><br>
                                        {{ $item->nama_pemesan }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>No. Handphone:</strong><br>
                                        {{ $item->no_hp }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat & Catatan -->
                        <div class="card mb-4 border-0 bg-light">
                            <div class="card-header bg-transparent border-0">
                                <h6 class="mb-0 text-muted">
                                    <i class="bi bi-house me-2"></i>Alamat & Catatan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <strong>Alamat:</strong><br>
                                        {{ $item->alamat }}
                                    </div>
                                    <div class="col-12">
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
                                        <strong>Status Pembayaran:</strong><br>
                                        @if ($item->pembayaran && $item->pembayaran->status_pembayaran == 'Belum Bayar')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i>Belum Bayar
                                            </span>
                                        @elseif ($item->pembayaran && $item->pembayaran->status_pembayaran == 'Lunas')
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i>Lunas
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                Tidak Diketahui
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Tanggal Pemesanan:</strong><br>
                                        {{ \Carbon\Carbon::parse($item->tanggal_pemesanan)->format('d M Y') }}
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
                        <button type="button" class="btn btn-outline-danger px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection