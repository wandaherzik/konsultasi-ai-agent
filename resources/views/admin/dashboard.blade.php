@extends('layouts.home.admin.app')

@section('page-title', 'Dashboard')

@section('content')

{{-- ========================================================= --}}
{{-- HEADER DASHBOARD --}}
{{-- ========================================================= --}}

<div class="row mb-4">

    <div class="col-md-8">

        <div class="card card-round">

            <div class="card-body">

                <div class="d-flex align-items-center">

                    <div
                        class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                        style="width: 55px; height: 55px;"
                    >

                        <i class="fas fa-hospital text-white fa-lg"></i>

                    </div>

                    <div>

                        <h3 class="mb-1">
                            Dashboard Administrasi Umum
                        </h3>

                        <p class="text-muted mb-0">
                            Pantau dan kelola aktivitas pelayanan
                            Puskesmas melalui sistem informasi.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="col-md-4">

        <div
            class="card card-round bg-primary text-white"
        >

            <div class="card-body">

                <div class="d-flex align-items-center">

                    <div class="me-3">

                        <i class="fas fa-calendar-alt fa-2x"></i>

                    </div>

                    <div>

                        <small>
                            Hari ini
                        </small>

                        <h5 class="mb-0 text-white">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </h5>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- STATISTIK --}}
{{-- ========================================================= --}}

<div class="row">


    {{-- TOTAL User Terdaftar --}}
<div class="col-sm-6 col-lg-3">

    <div class="card card-stats card-round">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                    style="width: 50px; height: 50px;"
                >

                    <i class="fas fa-users"></i>

                </div>

                <div class="ms-3">

                    <p class="text-muted mb-1">
                        Total User
                    </p>

                    <h3 class="mb-0">
                        {{ $totalUser }}
                    </h3>

                </div>

            </div>

            <div class="mt-3">

                <small class="text-muted">
                    <i class="fas fa-user-check text-primary me-1"></i>
                    Pengguna terdaftar
                </small>

            </div>

        </div>

    </div>

</div>



    {{-- TOTAL Pasien --}}
    <div class="col-sm-6 col-lg-3">

    <div class="card card-stats card-round">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center"
                    style="width: 50px; height: 50px;"
                >

                    <i class="fas fa-user-md"></i>

                </div>

                <div class="ms-3">

                    <p class="text-muted mb-1">
                        Total Pasien
                    </p>

                    <h3 class="mb-0">
                        {{ $totalPasien }}
                    </h3>

                </div>

            </div>

            <div class="mt-3">

                <small class="text-muted">
                    <i class="fas fa-hospital-user text-info me-1"></i>
                    Pasien terdaftar
                </small>

            </div>

        </div>

    </div>

</div>


    {{-- Total Dokter --}}
<div class="col-sm-6 col-lg-3">

    <div class="card card-stats card-round">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                    style="width: 50px; height: 50px;"
                >

                    <i class="fas fa-user-md"></i>

                </div>

                <div class="ms-3">

                    <p class="text-muted mb-1">
                        Total Dokter
                    </p>

                    <h3 class="mb-0">
                        {{ $totalDokter }}
                    </h3>

                </div>

            </div>

            <div class="mt-3">

                <small class="text-muted">
                    <i class="fas fa-stethoscope text-success me-1"></i>
                    Tenaga medis
                </small>

            </div>

        </div>

    </div>

</div>



    {{-- Total Poli --}}
  <div class="col-sm-6 col-lg-3">

    <div class="card card-stats card-round">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center"
                    style="width: 50px; height: 50px;"
                >

                    <i class="fas fa-hospital"></i>

                </div>

                <div class="ms-3">

                    <p class="text-muted mb-1">
                        Total Poli
                    </p>

                    <h3 class="mb-0">
                        {{ $totalPoli }}
                    </h3>

                </div>

            </div>

            <div class="mt-3">

                <small class="text-muted">
                    <i class="fas fa-hospital text-warning me-1"></i>
                    Layanan tersedia
                </small>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MAIN CONTENT --}}
{{-- ========================================================= --}}

<div class="row">


    {{-- ===================================================== --}}
    {{-- STATISTIK KUNJUNGAN --}}
    {{-- ===================================================== --}}

    <div class="col-md-8">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-head-row">

                    <div>

                        <h4 class="card-title mb-1">
                            Statistik Kunjungan
                        </h4>

                        <p class="text-muted mb-0">
                            Ringkasan aktivitas kunjungan pasien
                        </p>

                    </div>


                    <div class="card-tools">

                        <span class="badge bg-light text-primary">

                            <i class="fas fa-chart-line me-1"></i>

                            Monitoring

                        </span>

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div
                    id="kunjunganChart"
                    style="
                        min-height: 300px;
                        width: 100%;
                    "
                ></div>

            </div>

        </div>

    </div>



    {{-- ===================================================== --}}
    {{-- INFORMASI SISTEM --}}
    {{-- ===================================================== --}}

    <div class="col-md-4">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-head-row">

                    <div>

                        <h4 class="card-title mb-1">
                            Informasi Sistem
                        </h4>

                        <p class="text-muted mb-0">
                            Fitur utama aplikasi
                        </p>

                    </div>

                </div>

            </div>


            <div class="card-body">


                {{-- AI --}}
                <div
                    class="d-flex align-items-center p-3 mb-3 rounded"
                    style="background: rgba(13, 110, 253, 0.08);"
                >

                    <div
                        class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                        style="width: 45px; height: 45px;"
                    >

                        <i class="fas fa-robot"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h6 class="mb-1">
                            AI Agent
                        </h6>

                        <small class="text-muted">
                            Asisten konsultasi awal pasien
                        </small>

                    </div>


                    <i class="fas fa-check-circle text-success"></i>

                </div>



                {{-- DOKTER --}}
                <div
                    class="d-flex align-items-center p-3 mb-3 rounded"
                    style="background: rgba(25, 135, 84, 0.08);"
                >

                    <div
                        class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                        style="width: 45px; height: 45px;"
                    >

                        <i class="fas fa-user-md"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h6 class="mb-1">
                            Dokter
                        </h6>

                        <small class="text-muted">
                            Pemeriksaan dan rekam medis
                        </small>

                    </div>


                    <i class="fas fa-check-circle text-success"></i>

                </div>



                {{-- PASIEN --}}
                <div
                    class="d-flex align-items-center p-3 mb-3 rounded"
                    style="background: rgba(13, 202, 240, 0.08);"
                >

                    <div
                        class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3"
                        style="width: 45px; height: 45px;"
                    >

                        <i class="fas fa-users"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h6 class="mb-1">
                            Pasien
                        </h6>

                        <small class="text-muted">
                            Pendaftaran dan pelayanan kesehatan
                        </small>

                    </div>


                    <i class="fas fa-check-circle text-success"></i>

                </div>



                {{-- SISTEM --}}
                <div
                    class="d-flex align-items-center p-3 rounded"
                    style="background: rgba(108, 117, 125, 0.08);"
                >

                    <div
                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                        style="width: 45px; height: 45px;"
                    >

                        <i class="fas fa-database"></i>

                    </div>


                    <div class="flex-grow-1">

                        <h6 class="mb-1">
                            Sistem Informasi
                        </h6>

                        <small class="text-muted">
                            Pengelolaan data Puskesmas
                        </small>

                    </div>


                    <i class="fas fa-check-circle text-success"></i>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- STATUS PELAYANAN --}}
{{-- ========================================================= --}}

<div class="row">


    <div class="col-md-12">

        <div class="card card-round">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <div class="d-flex align-items-center">

                            <div
                                class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                style="
                                    width: 50px;
                                    height: 50px;
                                "
                            >

                                <i class="fas fa-server"></i>

                            </div>

                            <div>

                                <h5 class="mb-1">
                                    Sistem Berjalan Normal
                                </h5>

                                <p class="text-muted mb-0">
                                    Seluruh layanan sistem informasi
                                    Puskesmas dapat digunakan.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4 text-md-end mt-3 mt-md-0">

                        <span class="badge bg-success px-3 py-2">

                            <i class="fas fa-circle me-1"
                               style="font-size: 8px;">
                            </i>

                            Sistem Aktif

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection