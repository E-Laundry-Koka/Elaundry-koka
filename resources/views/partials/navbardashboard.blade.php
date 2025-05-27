<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-light navbar-light sticky-top px-4 py-0 shadow-sm">
    <!-- Mobile Brand -->
    <a href="{{ route('dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="bi bi-list-task"></i></h2>
    </a>

    <!-- Sidebar Toggle -->
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="bi bi-list fs-3"></i>
    </a>

    <!-- Search Bar (Hidden on small screens) -->
    <form class="d-none d-md-flex ms-4">
        <input class="form-control border-0 shadow-sm" type="search" placeholder="Cari...">
    </form>

    <!-- Right Side Navbar -->
    <div class="navbar-nav align-items-center ms-auto">
        <!-- Messages Dropdown -->
        <div class="nav-item dropdown">
            <!-- <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-chat-left-text me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Pesan</span>
            </a> -->
            <div class="dropdown-menu dropdown-menu-end bg-white border-0 rounded shadow m-0">
                <a href="#" class="dropdown-item">
                    <div class="d-flex align-items-center">
                        <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                        <div class="ms-2">
                            <h6 class="fw-normal mb-0">John mengirim pesan</h6>
                            <small>15 menit lalu</small>
                        </div>
                    </div>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item text-center">Lihat semua pesan</a>
            </div>
        </div>

        <!-- Notifications Dropdown -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Notifikasi</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-white border-0 rounded shadow m-0">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Profil diperbarui</h6>
                    <small>15 menit lalu</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Pengguna baru ditambahkan</h6>
                    <small>15 menit lalu</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Kata sandi diubah</h6>
                    <small>15 menit lalu</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item text-center">Lihat semua notifikasi</a>
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-white border-0 rounded shadow m-0">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">Profil Saya</a>
                <a href="javascript:void(0);" class="dropdown-item disabled" aria-disabled="true" style="pointer-events: none; opacity: 0.6;">
                    <i class=""></i>Pengaturan
                </a> 
                <!-- fa fa-cog me-2 -->
                <!-- <a href="" class="dropdown-item">Pengaturan</a> // -->
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->