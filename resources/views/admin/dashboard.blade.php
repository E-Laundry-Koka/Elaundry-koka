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
            <!-- Messages Widget -->
            <!-- <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4 border-top border-primary border-3"> -->
                    <!-- <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0"><i class="fa fa-envelope text-primary me-2"></i>Pesan Terbaru</h6>
                        <a href="#" class="text-primary small">Lihat Semua</a>
                    </div> -->
                    <!-- Message Item -->
                    <!-- <div class="d-flex align-items-center border-bottom py-3">
                        <div class="position-relative">
                            <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" style="font-size: 0.5rem;">
                                <span class="visually-hidden">online</span>
                            </span>
                        </div>
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0">Jhon Doe</h6>
                                <small class="text-muted">15 menit lalu</small>
                            </div>
                            <span class="text-muted small">Kapan pesanan saya selesai?</span>
                        </div>
                    </div> -->
                    <!-- Message Item -->
                    <!-- <div class="d-flex align-items-center border-bottom py-3">
                        <div class="position-relative">
                            <img class="rounded-circle flex-shrink-0" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary" style="font-size: 0.5rem;">
                                <span class="visually-hidden">offline</span>
                            </span>
                        </div>
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0">Jane Smith</h6>
                                <small class="text-muted">1 jam lalu</small>
                            </div>
                            <span class="text-muted small">Terima kasih atas layanannya!</span>
                        </div>
                    </div> -->
                    <!-- <div class="text-center mt-3">
                        <button class="btn btn-sm btn-outline-primary">Balas Pesan</button>
                    </div> -->
                <!-- </div>
            </div> -->

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
                        <div class="row g-1 text-center small fw-bold text-muted">
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
                            $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year); // timestamp hari pertama bulan ini
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            $dayOfWeek = date('w', $firstDayOfMonth); // 0=minggu, 1=senin, dst...
                            $dayOfWeek = ($dayOfWeek == 0) ? 6 : $dayOfWeek - 1; // sesuaikan agar Senin = 0
                        @endphp

                        <div class="row g-1 text-center small mt-2">
                            <!-- Kosongkan awal sesuai dengan hari pertama -->
                            @for($i = 0; $i < $dayOfWeek; $i++)
                                <div class="col p-1"></div>
                            @endfor

                            <!-- Loop semua tanggal -->
                            @for($date = 1; $date <= $daysInMonth; $date++)
                                <div class="col p-1">
                                    @if($date == date('d'))
                                        <span class="badge bg-primary rounded-circle">{{ $date }}</span>
                                    @else
                                        {{ $date }}
                                    @endif
                                </div>
                                @php
                                    $currentDay = ($dayOfWeek + $date) % 7;
                                @endphp
                                <!-- Mulai baris baru jika mencapai Minggu -->
                                @if($currentDay == 0 && $date != $daysInMonth)
                                    </div><div class="row g-1 text-center small">
                                @endif
                            @endfor
                        </div>
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
                    <div class="modal-header bg-gradient text-white" style="background: linear-gradient(to right, #28a745, #66bb6a);">
                        <h5 class="modal-title" id="modalDetailPesananLabel{{ $item->id }}" style="color: white" >Detail Pesanan</h5>
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
                                <div class="col-md-6"><strong>Status Pembayaran:</strong>
                                    @if ($item->pembayaran && $item->pembayaran->status_pembayaran == 'Belum Bayar')
                                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                                    @elseif ($item->pembayaran && $item->pembayaran->status_pembayaran == 'Lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Diketahui</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6"><strong>Tanggal Pemesanan:</strong>
                                {{ \Carbon\Carbon::parse($item->tanggal_pemesanan)->format('d M Y') }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6"><strong>Status:</strong>
                                @if ($item->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif ($item->status == 'Proses')
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection