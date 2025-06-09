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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        /* Hover Effect for Statistics Cards */
        .stat-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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

        .alert {
            margin-bottom: 1rem;
        }
    </style>
    <!-- Page Header Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Manajemen Admin</h6>
                    
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('gagal'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('gagal') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
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
                        <h6 class="mb-0 fw-bold text-primary">{{ $totaladmin ?? '0' }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 stat-card">
                    <i class="fa fa-map-marker-alt fa-3x text-info"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Lokasi</p>
                        <h6 class="mb-0 fw-bold text-info">{{ $totalLokasi ?? '0' }}</h6>
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
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admin as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($user->foto_profile)
                                        <img class="rounded-circle" src="{{ asset('storage/' . $user->foto_profile) }}" alt="Foto Profil" style="width: 40px; height: 40px;">
                                    @else
                                        <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="Default" style="width: 40px; height: 40px;">
                                    @endif
                                </td>
                                <td>{{ $user->name ?? '-' }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>
                                    @php
                                        $roleLabels = [
                                            'super_admin' => ['text' => 'Super Admin', 'class' => 'bg-danger'],
                                            'admin' => ['text' => 'Admin', 'class' => 'bg-primary'],
                                        ];
                                        $role = $roleLabels[($user->role)->role_name] ?? ['text' => 'Tidak Diketahui', 'class' => 'bg-secondary'];
                                    @endphp
                                    <span class="badge {{ $role['class'] }}">{{ $role['text'] }}</span>
                                </td>
                                <td>{{ optional($user->lokasi)->nama_lokasi ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAdminModal{{ $user->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger me-1" onclick="confirmDelete('{{ $user->id }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data admin ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    {{ $admin->links() }}
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
                        @forelse ($lokasiList as $location)
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">{{ $location->nama_lokasi }}</h6>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fa fa-cog"></i>
                                            </button>
                                            <!-- Dropdown menu untuk setiap lokasi individual -->
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editLokasiModal{{ $location->id }}">
                                                        <i class="fa fa-edit me-2"></i>Edit
                                                    </button>
                                                </li>
                                                <li>
                                                    <form id="delete-form-{{ $location->id }}" action="{{ route('lokasi.destroy', $location->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button class="dropdown-item" onclick="confirmDelete('{{ $location->id }}')">
                                                        <i class="fa fa-trash me-2"></i>Hapus
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-2">{{ $location->alamat }}, {{ $location->kota }}, {{ $location->kode_pos }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted">Belum ada lokasi tersedia.</p>
                            </div>
                        @endforelse
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
                    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" id="addAdminForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="konfirmasi_password">
                                    <div id="passwordError" class="text-danger mt-1" style="display: none;">
                                        Password tidak cocok
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role_id" required>
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <select class="form-select" id="id_lokasi" name="id_lokasi" required>
                                        <option value="">Pilih Lokasi</option>
                                        @foreach ($lokasiList as $location)
                                            <option value="{{ $location->id }}">{{ $location->nama_lokasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">No. Telepon</label>
                                    <input type="tel" class="form-control" id="telepon" name="no_hp" minlength="12" maxlength="13" pattern="^08\d{10,11}$">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control" id="foto" name="foto_profile" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Admin -->
    @foreach ($admin as $adm)
    <div class="modal fade" id="editAdminModal{{ $adm->id }}" tabindex="-1" aria-labelledby="editAdminModalLabel{{ $adm->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient text-white">
                    <h5 class="modal-title" id="editAdminModalLabel" style="color: white;">Edit Data Admin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.update', ['id' => $adm->id]) }}" method="POST" enctype="multipart/form-data" id="editAdminForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="name" value="{{ $adm->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $adm->email }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="konfirmasi_password">
                                    <div id="passwordError" class="text-danger mt-1" style="display: none;">
                                        Password tidak cocok
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role_id" required>
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $adm->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi</label>
                                    <select class="form-select" id="id_lokasi" name="id_lokasi" required>
                                        <option value="">Pilih Lokasi</option>
                                        @foreach ($lokasiList as $location)
                                            <option value="{{ $location->id }}" {{ $adm->id_lokasi == $location->id ? 'selected' : '' }}>
                                                {{ $location->nama_lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">No. Telepon</label>
                                    <input type="tel" class="form-control" id="telepon" name="no_hp" value="{{ $adm->no_hp }}" minlength="12" maxlength="13" pattern="^08\d{10,11}$" title="Masukkan Nomor Telepon dengan Benar">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control" id="foto" name="foto_profile" accept="image/*">
                                    <!-- Tampilkan foto lama jika ada -->
                                    @if($adm->foto_profile)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $adm->foto_profile) }}" alt="Foto Profil" width="100" class="img-thumbnail">
                                            <p class="text-muted">Foto saat ini</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $adm->alamat }}</textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
    <!-- Modal Edit Lokasi -->
    @foreach ($lokasiList as $lokasi)
    <div class="modal fade" id="editLokasiModal{{ $lokasi->id }}" tabindex="-1" aria-labelledby="editLokasiModalLabel{{ $lokasi->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-gradient text-white">
                    <h5 class="modal-title" id="editLokasiModalLabel" style="color: white;">Edit Data Lokasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('lokasi.update', ['id' => $lokasi->id]) }}" method="POST" enctype="multipart/form-data" id="editAdminForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                                <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" value="{{ $lokasi->nama_lokasi }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kota" class="form-label">Kota</label>
                                <input type="text" class="form-control" id="kota" name="kota" value="{{ $lokasi->kota }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $lokasi->alamat }}</textarea>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="kode_pos" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ $lokasi->kode_pos }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Lokasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Add Location -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('lokasi.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-gradient text-white">
                        <h5 class="modal-title" id="addLocationModalLabel" style="color: white;">Tambah Lokasi Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" class="form-control" id="nama_lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_lokasi" class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" id="alamat_lokasi" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kota" class="form-label">Kota</label>
                                    <input type="text" name="kota" class="form-control" id="kota" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_pos" class="form-label">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control" id="kode_pos">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Lokasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password confirmation validation
        document.getElementById('konfirmasi_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const errorDiv = document.getElementById('passwordError');

            if (password !== confirmPassword) {
                errorDiv.style.display = 'block';
            } else {
                errorDiv.style.display = 'none';
            }
        });

        // Form submission validation
        document.getElementById('addAdminForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('konfirmasi_password').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                document.getElementById('passwordError').style.display = 'block';
                return false;
            }
        });
    </script>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

@endsection

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>