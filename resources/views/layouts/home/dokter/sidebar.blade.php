<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">

    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">

            <a href="{{ route('dokter.dashboard') }}" class="logo">
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

    <a href="{{ route('dokter.dashboard') }}">

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

    <a
        href="{{ route('dokter.rekam-medis.index') }}"
        class="nav-link"
    >

        <i class="fas fa-file-medical"></i>

        <p>
            Rekam Medis
        </p>

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

    <a
        href="{{ route('dokter.jadwal.index') }}"
        class="nav-link"
    >

        <i class="fas fa-calendar-alt"></i>

        <p>
            Jadwal Tugas
        </p>

    </a>

</li>

<li class="nav-item">

    <a href="{{
                                route(
                                    'dokter.antrian.index'
                                )
                            }}">

        <i class="fas fa-list-ol"></i>

        <p>Antrian</p>

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