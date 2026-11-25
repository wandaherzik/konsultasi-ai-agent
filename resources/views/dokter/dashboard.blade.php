@extends('layouts.home.dokter.app')

@section('page-title', 'Dashboard Dokter')

@section(
    'page-description',
    'Informasi pelayanan dan antrean pasien'
)

@section('content')

<div class="page-inner">

    {{-- ====================================================== --}}
    {{-- WELCOME CARD --}}
    {{-- ====================================================== --}}

    <div class="row">

        <div class="col-md-12">

            <div
                class="card card-round overflow-hidden"
                style="
                    background: linear-gradient(
                        135deg,
                        #1572e8 0%,
                        #3b8df5 100%
                    );
                    border: none;
                "
            >

                <div class="card-body p-4">

                    <div class="row align-items-center">

                        <div class="col-md-8">

                            <div
                                class="d-flex align-items-center"
                            >

                                <div
                                    class="avatar avatar-xl me-3"
                                >

                                    <span
                                        class="avatar-title
                                               rounded-circle
                                               bg-white
                                               text-primary"
                                        style="
                                            width: 70px;
                                            height: 70px;
                                            font-size: 28px;
                                        "
                                    >

                                        <i class="fas fa-user-md"></i>

                                    </span>

                                </div>


                                <div class="text-white">

                                    <p
                                        class="mb-1"
                                        style="opacity: .85;"
                                    >

                                        Selamat Datang,

                                    </p>

                                    <h2
                                        class="fw-bold mb-1 text-white"
                                    >

                                        {{ $dokter->nama_dokter }}

                                    </h2>

                                    <p
                                        class="mb-0"
                                        style="opacity: .85;"
                                    >

                                        <i
                                            class="fas fa-stethoscope me-1"
                                        ></i>

                                        Dokter Pelayanan Puskesmas

                                    </p>

                                </div>

                            </div>

                        </div>


                        <div
                            class="col-md-4 text-md-end mt-4 mt-md-0"
                        >

                            <div
                                class="text-white"
                            >

                                <div
                                    class="mb-2"
                                    style="opacity: .8;"
                                >

                                    <i
                                        class="far fa-calendar-alt me-1"
                                    ></i>

                                    Hari Pelayanan

                                </div>

                                <h4
                                    class="fw-bold text-white mb-0"
                                >

                                    {{ now()->translatedFormat('l, d F Y') }}

                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- STATISTIK ANTREAN --}}
    {{-- ====================================================== --}}

    <div class="row">


        {{-- TOTAL --}}

        <div class="col-sm-6 col-lg-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div
                                class="
                                    icon-big
                                    text-center
                                    icon-primary
                                    bubble-shadow-small
                                "
                            >

                                <i class="fas fa-users"></i>

                            </div>

                        </div>


                        <div
                            class="col col-stats ms-3 ms-sm-0"
                        >

                            <div class="numbers">

                                <p class="card-category">
                                    Total Antrean
                                </p>

                                <h4 class="card-title">
                                    {{ $totalAntrian }}
                                </h4>

                                <small class="text-muted">
                                    Pasien hari ini
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- MENUNGGU --}}

        <div class="col-sm-6 col-lg-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div
                                class="
                                    icon-big
                                    text-center
                                    icon-warning
                                    bubble-shadow-small
                                "
                            >

                                <i class="fas fa-clock"></i>

                            </div>

                        </div>


                        <div
                            class="col col-stats ms-3 ms-sm-0"
                        >

                            <div class="numbers">

                                <p class="card-category">
                                    Menunggu
                                </p>

                                <h4 class="card-title">
                                    {{ $menunggu }}
                                </h4>

                                <small class="text-muted">
                                    Menunggu pelayanan
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- DIPANGGIL --}}

        <div class="col-sm-6 col-lg-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div
                                class="
                                    icon-big
                                    text-center
                                    icon-info
                                    bubble-shadow-small
                                "
                            >

                                <i class="fas fa-bullhorn"></i>

                            </div>

                        </div>


                        <div
                            class="col col-stats ms-3 ms-sm-0"
                        >

                            <div class="numbers">

                                <p class="card-category">
                                    Dipanggil
                                </p>

                                <h4 class="card-title">
                                    {{ $dipanggil }}
                                </h4>

                                <small class="text-muted">
                                    Sedang dilayani
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- SELESAI --}}

        <div class="col-sm-6 col-lg-3">

            <div class="card card-stats card-round">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-icon">

                            <div
                                class="
                                    icon-big
                                    text-center
                                    icon-success
                                    bubble-shadow-small
                                "
                            >

                                <i class="fas fa-check-circle"></i>

                            </div>

                        </div>


                        <div
                            class="col col-stats ms-3 ms-sm-0"
                        >

                            <div class="numbers">

                                <p class="card-category">
                                    Selesai
                                </p>

                                <h4 class="card-title">
                                    {{ $selesai }}
                                </h4>

                                <small class="text-muted">
                                    Pelayanan selesai
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- INFORMASI ANTREAN --}}
    {{-- ====================================================== --}}

    <div class="row">


        {{-- ANTREAN PASIEN --}}

        <div class="col-md-8">

            <div class="card card-round h-100">

                <div class="card-header">

                    <div class="card-head-row">

                        <div>

                            <h4 class="card-title mb-1">

                                <i
                                    class="fas fa-users text-primary me-2"
                                ></i>

                                Antrean Pasien Hari Ini

                            </h4>

                            <p class="text-muted mb-0">

                                Kelola pasien yang terdaftar
                                pada jadwal pelayanan Anda.

                            </p>

                        </div>


                        <div>

                            <span
                                class="badge bg-primary px-3 py-2"
                            >

                                {{ $totalAntrian }}

                                Pasien

                            </span>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <div
                        class="d-flex
                               align-items-center
                               justify-content-between
                               p-3
                               rounded"
                        style="background: #f8f9fa;"
                    >

                        <div>

                            <h6 class="fw-bold mb-1">

                                Status Antrean

                            </h6>

                            <small class="text-muted">

                                Pantau antrean pasien
                                secara langsung.

                            </small>

                        </div>


                        <div class="text-end">

                            <div>

                                <span
                                    class="badge bg-warning me-1"
                                >

                                    {{ $menunggu }}
                                    Menunggu

                                </span>

                                <span
                                    class="badge bg-info me-1"
                                >

                                    {{ $dipanggil }}
                                    Dipanggil

                                </span>

                                <span
                                    class="badge bg-success"
                                >

                                    {{ $selesai }}
                                    Selesai

                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="text-center mt-4">

                        <a
                            href="{{
                                route(
                                    'dokter.antrian.index'
                                )
                            }}"
                            class="btn btn-primary btn-round px-4"
                        >

                            <i
                                class="fas fa-list-ol me-2"
                            ></i>

                            Kelola Antrean

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- MENU CEPAT --}}

        <div class="col-md-4 mt-4 mt-md-0">

            <div class="card card-round h-100">

                <div class="card-header">

                    <h4 class="card-title mb-0">

                        <i
                            class="fas fa-th-large
                                   text-primary
                                   me-2"
                        ></i>

                        Menu Cepat

                    </h4>

                </div>


                <div class="card-body">


                    {{-- ANTREAN --}}

                    <a
                        href="{{
                            route(
                                'dokter.antrian.index'
                            )
                        }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="
                                d-flex
                                align-items-center
                                p-3
                                rounded
                                mb-3
                                border
                            "
                        >

                            <div
                                class="
                                    rounded-circle
                                    bg-primary
                                    text-white
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                    me-3
                                "
                                style="
                                    width: 45px;
                                    height: 45px;
                                "
                            >

                                <i class="fas fa-users"></i>

                            </div>


                            <div>

                                <h6
                                    class="fw-bold text-dark mb-1"
                                >

                                    Antrean Pasien

                                </h6>

                                <small class="text-muted">

                                    Kelola antrean hari ini

                                </small>

                            </div>

                        </div>

                    </a>


                    {{-- REKAM MEDIS --}}

                    <a
                        href="{{
                            route(
                                'dokter.rekam-medis.index'
                            )
                        }}"
                        class="text-decoration-none"
                    >

                        <div
                            class="
                                d-flex
                                align-items-center
                                p-3
                                rounded
                                border
                            "
                        >

                            <div
                                class="
                                    rounded-circle
                                    bg-success
                                    text-white
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                    me-3
                                "
                                style="
                                    width: 45px;
                                    height: 45px;
                                "
                            >

                                <i
                                    class="fas fa-file-medical"
                                ></i>

                            </div>


                            <div>

                                <h6
                                    class="fw-bold text-dark mb-1"
                                >

                                    Rekam Medis

                                </h6>

                                <small class="text-muted">

                                    Lihat riwayat pasien

                                </small>

                            </div>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- INFORMASI PELAYANAN --}}
    {{-- ====================================================== --}}

    <div class="row mt-4">

        <div class="col-md-12">

            <div class="card card-round">

                <div class="card-body">

                    <div
                        class="d-flex
                               align-items-center"
                    >

                        <div
                            class="
                                rounded-circle
                                bg-light
                                text-primary
                                d-flex
                                align-items-center
                                justify-content-center
                                me-3
                            "
                            style="
                                width: 50px;
                                height: 50px;
                                font-size: 20px;
                            "
                        >

                            <i class="fas fa-info-circle"></i>

                        </div>


                        <div>

                            <h6 class="fw-bold mb-1">

                                Informasi Pelayanan

                            </h6>

                            <p class="text-muted mb-0">

                                Gunakan halaman antrean untuk
                                memanggil pasien yang sedang
                                menunggu. Setelah pelayanan selesai,
                                pastikan rekam medis pasien telah
                                dicatat dengan lengkap.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection