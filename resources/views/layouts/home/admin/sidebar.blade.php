<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">

    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">

            <a href="{{ route('admin.dashboard') }}" class="logo">
                <img
                    src="{{ asset('kaiadmin-lite-1.2.0/assets/img/puskesmas.png') }}"
                    alt="Logo Puskesmas AI"
                    class="navbar-brand"
                    height="60"
                />
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>

                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>

            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>

        </div>
        <!-- End Logo Header -->
    </div>


    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            <ul class="nav nav-secondary">

                {{-- ============================= --}}
                {{-- DASHBOARD --}}
                {{-- ============================= --}}

                <li class="nav-item">

    <a href="{{ route('admin.dashboard') }}">

        <i class="fas fa-home"></i>

        <p>Dashboard</p>

    </a>

</li>


<li class="nav-section">

    <span class="sidebar-mini-icon">
        <i class="fa fa-ellipsis-h"></i>
    </span>

    <h4 class="text-section">
        Manajemen
    </h4>

</li>


<li class="nav-item">

    <a href="{{ route('admin.users.index') }}">

        <i class="fas fa-users"></i>

        <p>Manajemen User</p>

    </a>

</li>


<li class="nav-item {{ request()->routeIs('admin.pasien.*') ? 'active' : '' }}">
    <a href="{{ route('admin.pasien.index') }}">
        <i class="fas fa-users"></i>
        <p>Data Pasien</p>
    </a>
</li>


<li class="nav-item {{ request()->routeIs('admin.dokter.*') ? 'active' : '' }}">

    <a href="{{ route('admin.dokter.index') }}">

        <i class="fas fa-user-md"></i>

        <p>Data Dokter</p>

    </a>

</li>


<li class="nav-item">
    <a href="{{ route('admin.poli.index') }}">
        <i class="fas fa-hospital"></i>
        <p>Data Poli</p>
    </a>
</li>




<li class="nav-section">

    <span class="sidebar-mini-icon">
        <i class="fa fa-ellipsis-h"></i>
    </span>

    <h4 class="text-section">
        Pelayanan
    </h4>

</li>


<li class="nav-item">
    <a href="{{ route('admin.jadwal-dokter.index') }}">
        <i class="fas fa-calendar-alt"></i>
        <p>Jadwal Dokter</p>
    </a>
</li>



                {{-- ============================= --}}
                {{-- LOGOUT --}}
                {{-- ============================= --}}

<li class="nav-item">

    <form
        action="{{ route('logout') }}"
        method="POST"
        class="m-0"
    >

        @csrf

        <button
            type="submit"
            class="btn btn-danger me-2"
        >

            <i class="fas fa-sign-out-alt me-2"></i>

        </button>

    </form>

</li>

            </ul>

        </div>
    </div>

</div>
<!-- End Sidebar -->