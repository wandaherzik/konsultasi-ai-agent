@extends('layouts.home.pasien.app')

@section('page-title', 'Dashboard Pasien')

@section(
    'page-description',
    'Pusat layanan pasien Puskesmas Tiku'
)

@section('content')

<div class="row">

    {{-- ============================= --}}
    {{-- WELCOME --}}
    {{-- ============================= --}}

    <div class="col-md-12">

        <div class="card card-round">

            <div class="card-body">

                <div class="d-flex align-items-center">

                    <div class="avatar avatar-xl me-3">

                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="fas fa-user fa-lg"></i>
                        </span>

                    </div>

                    <div>

                        <h4 class="fw-bold mb-1">
                            Selamat Datang,
                            {{ $pasien->nama_pasien ?? $user->nama }}
                        </h4>

                        <p class="text-muted mb-0">
                            Silakan pilih layanan yang ingin Anda gunakan.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- KONSULTASI AI --}}
    {{-- ============================= --}}

    <div class="col-md-6 col-lg-3">

        <div class="card card-round">

            <div class="card-body">

                <div class="d-flex align-items-center mb-3">

                    <div class="icon-big text-center">
                        <i class="fas fa-robot text-primary"></i>
                    </div>

                </div>

                <h5 class="fw-bold">
                    Konsultasi AI
                </h5>

                <p class="text-muted">
                    Konsultasikan keluhan kesehatan Anda dengan AI Agent.
                </p>

                <a
                    href="{{ route('pasien.pasien.konsultasi.create') }}"
                    class="btn btn-primary btn-sm"
                >
                    Mulai Konsultasi
                </a>

            </div>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- JADWAL DOKTER --}}
    {{-- ============================= --}}

    <div class="col-md-6 col-lg-3">

        <div class="card card-round">

            <div class="card-body">

                <div class="icon-big text-center mb-3">
                    <i class="fas fa-calendar-doctor text-success"></i>
                </div>

                <h5 class="fw-bold">
                    Jadwal Dokter
                </h5>

                <p class="text-muted">
                    Lihat jadwal pelayanan dokter di Puskesmas.
                </p>

                <a
                    href="{{ route('pasien.jadwal.index') }}"
                    class="btn btn-success btn-sm"
                >
                    Lihat Jadwal
                </a>

            </div>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- ANTREAN --}}
    {{-- ============================= --}}

    <div class="col-md-6 col-lg-3">

        <div class="card card-round">

            <div class="card-body">

                <div class="icon-big text-center mb-3">
                    <i class="fas fa-list-ol text-warning"></i>
                </div>

                <h5 class="fw-bold">
                    Antrean Saya
                </h5>

                <p class="text-muted">
                    Lihat nomor dan status antrean pelayanan Anda.
                </p>

                <a
                    href="{{ route('pasien.antrian.index') }}"
                    class="btn btn-warning btn-sm"
                >
                    Lihat Antrean
                </a>

            </div>

        </div>

    </div>


    {{-- ============================= --}}
    {{-- REKAM MEDIS --}}
    {{-- ============================= --}}

    <div class="col-md-6 col-lg-3">

        <div class="card card-round">

            <div class="card-body">

                <div class="icon-big text-center mb-3">
                    <i class="fas fa-file-medical text-danger"></i>
                </div>

                <h5 class="fw-bold">
                    Rekam Medis
                </h5>

                <p class="text-muted">
                    Lihat riwayat pemeriksaan dan rekam medis Anda.
                </p>

                <a
                    href="{{ route('pasien.rekam-medis.index') }}"
                    class="btn btn-danger btn-sm"
                >
                    Lihat Rekam Medis
                </a>

            </div>

        </div>

    </div>
{{-- ============================= --}}
{{-- INFORMASI PELAYANAN --}}
{{-- ============================= --}}

<div class="col-md-8">

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div>
                    <h4 class="card-title mb-1">
                        Informasi Pelayanan
                    </h4>

                    <p class="text-muted mb-0">
                        Ikuti langkah berikut untuk mendapatkan pelayanan
                    </p>
                </div>

                <div class="card-tools">
                    <span class="badge bg-primary">
                        <i class="fas fa-hospital me-1"></i>
                        Pelayanan Puskesmas
                    </span>
                </div>

            </div>

        </div>


        <div class="card-body">

            {{-- Informasi utama --}}
            <div
                class="alert alert-info border-0 mb-4"
                style="border-radius: 12px;"
            >

                <div class="d-flex align-items-start">

                    <div class="me-3">

                        <i
                            class="fas fa-robot fa-2x"
                        ></i>

                    </div>

                    <div>

                        <h5 class="mb-1">
                            Mulai dengan Konsultasi AI
                        </h5>

                        <p class="mb-0">
                            Sampaikan keluhan kesehatan Anda melalui
                            layanan konsultasi AI untuk mendapatkan
                            informasi awal dan rekomendasi poli yang
                            sesuai.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Alur pelayanan --}}
            <div class="row g-3">

                {{-- Step 1 --}}
                <div class="col-md-4">

                    <div
                        class="p-3 h-100 border rounded"
                    >

                        <div
                            class="d-flex align-items-center mb-3"
                        >

                            <div
                                class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                style="
                                    width: 42px;
                                    height: 42px;
                                "
                            >

                                <i class="fas fa-comments"></i>

                            </div>

                            <div>

                                <small class="text-muted">
                                    LANGKAH 1
                                </small>

                                <h6 class="mb-0">
                                    Konsultasi
                                </h6>

                            </div>

                        </div>

                        <p class="text-muted small mb-0">
                            Ceritakan keluhan kesehatan Anda
                            melalui konsultasi AI.
                        </p>

                    </div>

                </div>


                {{-- Step 2 --}}
                <div class="col-md-4">

                    <div
                        class="p-3 h-100 border rounded"
                    >

                        <div
                            class="d-flex align-items-center mb-3"
                        >

                            <div
                                class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3"
                                style="
                                    width: 42px;
                                    height: 42px;
                                "
                            >

                                <i class="fas fa-ticket-alt"></i>

                            </div>

                            <div>

                                <small class="text-muted">
                                    LANGKAH 2
                                </small>

                                <h6 class="mb-0">
                                    Ambil Antrean
                                </h6>

                            </div>

                        </div>

                        <p class="text-muted small mb-0">
                            Dapatkan nomor antrean berdasarkan
                            hasil konsultasi.
                        </p>

                    </div>

                </div>


                {{-- Step 3 --}}
                <div class="col-md-4">

                    <div
                        class="p-3 h-100 border rounded"
                    >

                        <div
                            class="d-flex align-items-center mb-3"
                        >

                            <div
                                class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                style="
                                    width: 42px;
                                    height: 42px;
                                "
                            >

                                <i class="fas fa-user-md"></i>

                            </div>

                            <div>

                                <small class="text-muted">
                                    LANGKAH 3
                                </small>

                                <h6 class="mb-0">
                                    Pemeriksaan
                                </h6>

                            </div>

                        </div>

                        <p class="text-muted small mb-0">
                            Tunggu panggilan dan lakukan pemeriksaan
                            bersama dokter.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Footer informasi --}}
            <div class="mt-4 pt-3 border-top">

                <div
                    class="d-flex align-items-center"
                >

                    <i
                        class="fas fa-shield-alt text-success me-2"
                    ></i>

                    <small class="text-muted">
                        Hasil konsultasi AI merupakan informasi awal
                        dan bukan pengganti diagnosis dokter.
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>


    {{-- ============================= --}}
    {{-- PROFIL --}}
    {{-- ============================= --}}

    <div class="col-md-4">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-title">
                    Data Pasien
                </div>

            </div>

            <div class="card-body">

                <div class="mb-2">

                    <small class="text-muted">
                        NIK
                    </small>

                    <div class="fw-bold">
                        {{ $pasien->nik ?? '-' }}
                    </div>

                </div>

                <div class="mb-2">

                    <small class="text-muted">
                        No. BPJS
                    </small>

                    <div class="fw-bold">
                        {{ $pasien->no_bpjs ?? 'Tidak terdaftar' }}
                    </div>

                </div>

                <div class="mb-2">

                    <small class="text-muted">
                        No. Telepon
                    </small>

                    <div class="fw-bold">
                        {{ $pasien->no_telepon ?? '-' }}
                    </div>

                </div>

                <a
                    href="{{ route('pasien.profil.index') }}"
                    class="btn btn-outline-primary btn-sm w-100 mt-2"
                >
                    <i class="fas fa-user-edit me-1"></i>
                    Profil Saya
                </a>

            </div>

        </div>

    </div>

</div>

@endsection