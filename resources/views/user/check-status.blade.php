<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cek Status Pesanan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bagian style -->
<!-- Bagian style -->
<style>
    body {
        background-color: #194376;
        font-family: 'Segoe UI', sans-serif;
    }

    .form-card {
        background: #fff;
        border-radius: 15px;
        padding: 40px 30px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
        max-width: 450px;
        margin: 80px auto;
        transition: transform 0.3s ease;
    }

    .form-card:hover {
        transform: translateY(-5px);
    }

    h3 {
        color: #194376;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .btn-primary {
        background-color: #194376;
        border-color: #194376;
    }

    .btn-primary:hover {
        background-color: #163a68;
        border-color: #163a68;
    }

    .profile-card {
        background: #fff;
        border-radius: 15px;
        padding: 30px 25px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-3px);
    }

    .profile-card h3 {
        color: #194376;
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .profile-card p {
        color: #6c757d;
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #194376;
        box-shadow: 0 0 0 0.2rem rgba(25, 67, 118, 0.25);
        outline: none;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .back-button:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .container-custom {
        max-width: 800px;
        margin: 100px auto 50px;
        padding: 0 20px;
    }

    .page-title {
        color: white;
        text-align: center;
        margin-bottom: 40px;
        font-weight: bold;
        font-size: 1.8rem;
    }

    .list-group-item strong {
        font-size: 0.95rem;
    }

    .badge {
        font-size: 0.85rem;
    }
</style>
</head>
<body>

<!-- Back Button -->
<a href="/" class="position-absolute top-0 start-0 m-4 d-flex align-items-center text-white text-decoration-none">
    <div class="back-button me-2">
        <i class="bi bi-arrow-left" style="font-size: 1.2rem;"></i>
    </div>
    <span>Kembali</span>
</a>

<div class="container-custom">
    <h1 class="page-title">Cek Status Pesanan</h1>

    <!-- Form Input ID Pesanan -->
    <div class="profile-card">
        <h3>
            <i class="bi bi-receipt me-2"></i>
            {{ __('Masukkan Nomor Resi Pesanan') }}
        </h3>
        <p>{{ __('Silakan masukkan Nomor Resi pesanan Anda untuk melihat statusnya.') }}</p>

        <form method="POST" action="{{ route('check-status-pesanan')}}">
            @csrf
            <div class="mb-3">
                <label for="nomor_resi" class="form-label">Nomor Resi Pesanan</label>
                <input type="text" name="nomor_resi" id="nomor_resi" class="form-control" placeholder="Contoh: 12345" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cek Status</button>
        </form>
    </div>

    <!-- Detail Pesanan -->
    @if (isset($pesanan))
        <div class="profile-card mt-4">
            <h3>
                <i class="bi bi-info-circle me-2"></i>
                {{ __('Detail Pesanan') }}
            </h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>ID Pesanan</strong>
                    <span>{{ $pesanan->id }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Nama Pemesan</strong>
                    <span>{{ $pesanan->nama_pemesan }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>No HP</strong>
                    <span>{{ $pesanan->no_hp }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Alamat</strong>
                    <span>{{ $pesanan->alamat }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Tanggal Pemesanan</strong>
                    <span>{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Jenis Layanan</strong>
                    <span>{{ optional($pesanan->layanan)->nama_layanan ?? '-' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Harga per Kg</strong>
                    <span>Rp {{ number_format(optional($pesanan->layanan)->harga ?? 0, 0, ',', '.') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Berat</strong>
                    <span>{{ $pesanan->berat }} Kg</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Status Pesanan</strong>
                    <span>
                        @php
                            $status = $pesanan->status;
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
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Status Pembayaran</strong>
                    <span>
                        @if ($pesanan->pembayaran && $pesanan->pembayaran->status_pembayaran == 'Lunas')
                        <span class="badge bg-success">Lunas</span>
                        @elseif ($pesanan->pembayaran)
                        <span class="badge bg-warning text-dark">Pending</span>
                        @else
                        <span class="badge bg-secondary">Belum ada pembayaran</span>
                        @endif
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center rounded-3 shadow-sm" style="background-color: #194376; color: white;">
                    <strong class="d-flex align-items-center">
                        <i class="bi bi-cash me-2"></i>
                        Total Bayar
                    </strong>
                    <span class="fs-5 fw-bold">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                </li>
            </ul>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger mt-4 text-center">
            {{ session('error') }}
        </div>
    @else
        <div class="alert alert-info mt-4 text-center">
            Nomor resi tidak tersedia.
        </div>
    @endif
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>