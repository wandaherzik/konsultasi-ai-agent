   <!-- Navbar -->
    <div class="main-header">

        <nav class="navbar navbar-header navbar-expand-lg border-bottom">

            <div class="container-fluid">

                <!-- Mobile Sidebar Toggle -->
                <div class="d-flex align-items-center">

                    <button
                        class="btn btn-toggle toggle-sidebar d-lg-none"
                        type="button"
                    >
                        <i class="gg-menu-right"></i>
                    </button>

                    <span class="fw-bold d-lg-none ms-2">
                        Puskesmas Tiku
                    </span>

                </div>


                <!-- Topbar -->
                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                    <!-- User -->
                    <li class="nav-item topbar-user dropdown hidden-caret">

                        <a
                            class="nav-link dropdown-toggle d-flex align-items-center"
                            href="#"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >

                            <div class="avatar-sm me-2">
                                <span
                                    class="avatar-img rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                >
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>

                            <div class="profile-username">

                                <span class="op-7 d-block">
                                    Hi,
                                </span>

                                <span class="fw-bold">
                                    {{ auth()->user()->nama ?? 'Administrator' }}
                                </span>

                            </div>

                        </a>


                        <!-- User Dropdown -->
                        <ul class="dropdown-menu dropdown-user animated fadeIn">

                            <div class="dropdown-user-scroll scrollbar-outer">

                                <li>

                                    <div class="user-box">

                                        <div class="avatar-lg">

                                            <span
                                                class="avatar-img rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                            >
                                                <i class="fas fa-user fa-2x"></i>
                                            </span>

                                        </div>

                                        <div class="u-text">

                                            <h4>
                                                {{ auth()->user()->nama ?? 'Administrator' }}
                                            </h4>

                                            <p class="text-muted">
                                                {{ auth()->user()->username ?? 'admin' }}
                                            </p>

                                            <span class="badge bg-primary">
                                                {{ ucfirst(auth()->user()->role ?? 'admin') }}
                                            </span>

                                        </div>

                                    </div>

                                </li>


                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>


                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="#"
                                    >
                                        <i class="fas fa-user me-2"></i>
                                        Profil
                                    </a>

                                </li>


                                <li>

                                    <div class="dropdown-divider"></div>

                                </li>


                                <li>

                                    <form
                                        action="{{ route('logout') }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="dropdown-item text-danger"
                                        >

                                            <i class="fas fa-sign-out-alt me-2"></i>

                                            Logout

                                        </button>

                                    </form>

                                </li>

                            </div>

                        </ul>

                    </li>

                </ul>

            </div>

        </nav>

    </div>
    <!-- End Navbar -->