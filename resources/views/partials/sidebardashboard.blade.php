<!-- Sidebar -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="/" class="navbar-brand mx-4 mb-3" >
            <h3 class="text-primary" style="color: rgb(0, 126, 205) !important;"><i class="fa fa-soap me-2"></i>KOKA LAUNDRY</h3>
        </a>

        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                @if(Auth::user()->foto_profile)
                    <img class="rounded-circle" src="{{ asset(Auth::user()->foto_profile) }}" alt="User" style="width: 40px; height: 40px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa fa-user text-white"></i>
                    </div>
                @endif
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <!-- <i class="fas fa-user fa-0.5x text-primary"></i> -->
                <span>
                    @if(Auth::user()->role)
                        {{ Auth::user()->role->display_name ?? Auth::user()->role->role_name ?? 'Admin' }}
                    @else
                        Admin
                    @endif
                </span>
            </div>
        </div>

        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i>Beranda
            </a>

            <a href="{{ route('admin.management') }}" class="nav-item nav-link {{ request()->routeIs('admin.management') ? 'active' : '' }}">
                <i class="fa fa-user-cog me-2"></i>Admin
            </a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('orders.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-shopping-basket me-2"></i>Pesanan
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('orders.create') }}" class="nav-link dropdown-item mb-1 {{ request()->routeIs('orders.create') ? 'active' : '' }}" style="background-color:rgb(231, 231, 231);"><i class="fa fa-plus-circle"></i> Buat Pesanan</a>
                    <a href="{{ route('payments.index') }}" class="nav-link dropdown-item {{ request()->routeIs('orders.history') ? 'active' : '' }}" style="background-color:rgb(231, 231, 231);"><i class="fa fa-receipt"></i> Riwayat Pembayaran</a>
                </div>
            </div>

            <a href="javascript:void(0);" class="nav-item nav-link disabled" aria-disabled="true" style="pointer-events: none; opacity: 0.6;">
                <i class="fa fa-file-download me-2"></i>Unduh Tagihan
            </a>

            <a href="javascript:void(0);" class="nav-item nav-link disabled" aria-disabled="true" style="pointer-events: none; opacity: 0.6;">
                <i class="fa fa-cog me-2"></i>Setting
            </a>

            <a href="{{ route('logout') }}" class="nav-item nav-link text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt me-2"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>
</div>