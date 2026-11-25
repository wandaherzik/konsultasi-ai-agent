<!-- Main Panel -->
<div class="main-panel">

    <!-- Main Header -->
    <div class="main-header">

        <div class="main-header-logo">

            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">

                <a href="#" class="logo">

                    <img
                        src="{{ asset('kaiadmin-lite-1.2.0/assets/img/puskesmas.png') }}"
                        alt="Logo Puskesmas AI"
                        class="navbar-brand"
                        height="60"
                    />

                </a>

                <div class="nav-toggle">

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


        <!-- Navbar Header -->
        <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
        >

            <div class="container-fluid">

                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                    <li class="nav-item topbar-user dropdown hidden-caret">

                        <a
                            class="dropdown-toggle profile-pic"
                            data-bs-toggle="dropdown"
                            href="#"
                            aria-expanded="false"
                        >

                            <div class="avatar-sm">
                            </div>

                        </a>

                    </li>

                </ul>

            </div>

        </nav>
        <!-- End Navbar -->

    </div>
    <!-- End Main Header -->
<br>
<br>

    <!-- Main Content -->
    <div class="container-fluid main-content">

        <div class="page-inner">

            <!-- Page Header -->
            <div
                class="
                    d-flex
                    align-items-start
                    align-items-md-center
                    flex-column
                    flex-md-row
                    pt-3
                    pb-3
                    gap-3
                "
            >

                <!-- Page Actions -->
                @hasSection('page-actions')

                    <div class="ms-md-auto d-flex flex-wrap gap-2">

                        @yield('page-actions')

                    </div>

                @endif

            </div>
            <!-- End Page Header -->


            <!-- Alert Success -->
            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >

                    <i class="fas fa-check-circle me-2"></i>

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>

                </div>

            @endif
            <!-- End Alert Success -->


            <!-- Alert Error -->
            @if(session('error'))

                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >

                    <i class="fas fa-exclamation-circle me-2"></i>

                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>

                </div>

            @endif
            <!-- End Alert Error -->


            <!-- Validation Errors -->
            @if($errors->any())

                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >

                    <strong>
                        Terdapat kesalahan:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>

                </div>

            @endif
            <!-- End Validation Errors -->


            <!-- Page Content -->
            <div class="page-content-center">

                @yield('content')

            </div>
            <!-- End Page Content -->


        </div>

    </div>
    <!-- End Main Content -->


</div>
<!-- End Main Panel -->

<style>

    /* =====================================================
       HILANGKAN SIDEBAR
       ===================================================== */

    .sidebar {
        display: none !important;
        visibility: hidden !important;
    }


    /* =====================================================
       MAIN PANEL FULL WIDTH
       ===================================================== */

    .main-panel {
        width: 100% !important;
        min-height: 100vh !important;

        margin-left: 0 !important;
        margin-right: 0 !important;

        padding-left: 0 !important;
        padding-right: 0 !important;
    }


    /* =====================================================
       MAIN HEADER FULL WIDTH
       ===================================================== */

    .main-header {
        width: 100% !important;

        margin-left: 0 !important;
        margin-right: 0 !important;

        padding-left: 0 !important;
        padding-right: 0 !important;
    }


    /* =====================================================
       NAVBAR FULL WIDTH
       ===================================================== */

    .main-header .navbar {
        width: 100% !important;

        margin-left: 0 !important;
        margin-right: 0 !important;

        padding-left: 0 !important;
        padding-right: 0 !important;
    }


    /* Container navbar */
    .main-header .navbar .container-fluid {
        width: 100% !important;
        max-width: 100% !important;

        margin-left: 0 !important;
        margin-right: 0 !important;
    }


    /* =====================================================
       LOGO HEADER
       ===================================================== */

    .main-header-logo {
        margin-left: 0 !important;
        padding-left: 0 !important;
    }


    .logo-header {
        margin-left: 0 !important;
    }


    /* =====================================================
       MAIN CONTENT
       ===================================================== */

 
    /* =====================================================
       PAGE CONTENT CENTER
       ===================================================== */

  


    /* =====================================================
       HILANGKAN TOGGLE SIDEBAR
       ===================================================== */

    .nav-toggle {
        display: none !important;
    }


    /* =====================================================
       MOBILE
       ===================================================== */

    @media (max-width: 768px) {

        .main-header {
            width: 100% !important;
        }

        .main-content {
            width: 100% !important;
        }

        .page-content-center {

            min-height: auto;

            padding-top: 20px;
            padding-bottom: 20px;

        }

    }

</style>