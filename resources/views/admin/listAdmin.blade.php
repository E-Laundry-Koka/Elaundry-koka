@extends('layouts.dashboard')
@section('title', 'Manajemen Admin | Koka Laundry')
@section('content')

    <style>
        /* Override Bootstrap Colors */
        :root {
            --bs-primary: rgb(0, 126, 205);
            --bs-primary-rgb: 0, 126, 205;
        }

        .bg-primary,
        .btn-primary,
        .badge.bg-primary,
        .modal-header.bg-gradient,
        .hover-shadow:hover {
            background-color: var(--bs-primary) !important;
        }

        .text-primary,
        a.text-primary,
        .nav-link.active,
        .dropdown-item.active {
            color: var(--bs-primary) !important;
        }

        .border-primary {
            border-color: var(--bs-primary) !important;
        }

        .btn-outline-primary {
            color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        /* Custom Banner & Widgets */
        .bg-primary.rounded.p-4.text-white {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        /* Card Statistik Timbul */
        .stat-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Efek timbul */
            transition: all 0.3s ease; /* Transisi mulus */
        }

        /* Hover Effect for Statistics Cards */
        .stat-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Efek timbul lebih kuat saat hover */
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

    <!-- Page Header Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Manajemen Admin</h6>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Manajemen Admin</li>
                            </ol>
                        </nav>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                            <i class="fa fa-plus me-2"></i>Tambah Admin
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Statistics Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 stat-card">
                    <i class="fa fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Admin</p>
                        <h6 class="mb-0 fw-bold text-primary" data-toggle="counter-up">{{ $totalAdmin ?? '12' }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 stat-card">
                    <i class="fa fa-user-check fa-3x text-success"></i>
                    <div class="ms-3">
                        <p class="mb-2">Admin Aktif</p>
                        <h6 class="mb-0 fw-bold text-success" data-toggle="counter-up">{{ $adminAktif ?? '10' }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 stat-card">
                    <i class="fa fa-map-marker-alt fa-3x text-info"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Lokasi</p>
                        <h6 class="mb-0 fw-bold text-info" data-toggle="counter-up">{{ $totalLokasi ?? '5' }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 stat-card">
                    <i class="fa fa-user-times fa-3x text-warning"></i>
                    <div class="ms-3">
                        <p class="mb-2">Admin Nonaktif</p>
                        <h6 class="mb-0 fw-bold text-warning" data-toggle="counter-up">{{ $adminNonaktif ?? '2' }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Statistics End -->

    <!-- Admin List Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Daftar Admin</h6>
                <div class="d-flex">
                    <input type="text" class="form-control me-2" placeholder="Cari admin..." style="width: 200px;">
                    <select class="form-select me-2" style="width: 150px;">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">#</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Terakhir Login</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"></td>
                            <td>Ahmad Rizki</td>
                            <td>ahmad@kokaloundry.com</td>
                            <td><span class="badge bg-danger">Super Admin</span></td>
                            <td>Jakarta Pusat</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td>2 jam yang lalu</td>
                            <td>
                                <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#detailAdminModal">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning me-1">
                                    <i class="fa fa-ban"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"></td>
                            <td>Siti Nurhaliza</td>
                            <td>siti@kokaloundry.com</td>
                            <td><span class="badge bg-primary">Admin</span></td>
                            <td>Jakarta Selatan</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td>1 hari yang lalu</td>
                            <td>
                                <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#detailAdminModal">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning me-1">
                                    <i class="fa fa-ban"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"></td>
                            <td>Budi Santoso</td>
                            <td>budi@kokaloundry.com</td>
                            <td><span class="badge bg-info">Operator</span></td>
                            <td>Jakarta Barat</td>
                            <td><span class="badge bg-secondary">Nonaktif</span></td>
                            <td>1 minggu yang lalu</td>
                            <td>
                                <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#detailAdminModal">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-success me-1">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Admin List End -->

    <!-- Location Management Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Manajemen Lokasi</h6>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                            <i class="fa fa-plus me-2"></i>Tambah Lokasi
                        </button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Jakarta Pusat</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fa fa-edit me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fa fa-trash me-2"></i>Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="text-muted mb-2">Jl. Sudirman No. 123</p>
                                <div class="d-flex justify-content-between">
                                    <small class="text-success">4 Admin Aktif</small>
                                    <small class="text-primary">Status: Operasional</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Jakarta Selatan</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fa fa-edit me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fa fa-trash me-2"></i>Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="text-muted mb-2">Jl. Gatot Subroto No. 456</p>
                                <div class="d-flex justify-content-between">
                                    <small class="text-success">3 Admin Aktif</small>
                                    <small class="text-primary">Status: Operasional</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Jakarta Barat</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fa fa-edit me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fa fa-trash me-2"></i>Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="text-muted mb-2">Jl. Puri Indah No. 789</p>
                                <div class="d-flex justify-content-between">
                                    <small class="text-warning">2 Admin Aktif</small>
                                    <small class="text-warning">Status: Maintenance</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Location Management End -->

    <!-- Modal Add Admin -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient text-white">
                    <h5 class="modal-title" id="addAdminModalLabel" style="color: white;">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="konfirmasi_password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="super_admin">Super Admin</option>
                                        <option value="admin">Admin</option>
                                        <option value="operator">Operator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <select class="form-select" id="lokasi" required>
                                        <option value="">Pilih Lokasi</option>
                                        <option value="jakarta_pusat">Jakarta Pusat</option>
                                        <option value="jakarta_selatan">Jakarta Selatan</option>
                                        <option value="jakarta_barat">Jakarta Barat</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">No. Telepon</label>
                                    <input type="tel" class="form-control" id="telepon">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control" id="foto" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan Admin</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Location -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient text-white">
                    <h5 class="modal-title" id="addLocationModalLabel">Tambah Lokasi Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                            <input type="text" class="form-control" id="nama_lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_lokasi" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat_lokasi" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kota" class="form-label">Kota</label>
                                    <input type="text" class="form-control" id="kota" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input type="text" class="form-control" id="kode_pos">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status_lokasi" class="form-label">Status</label>
                            <select class="form-select" id="status_lokasi" required>
                                <option value="">Pilih Status</option>
                                <option value="operasional">Operasional</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="tutup">Tutup Sementara</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan Lokasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

@endsection