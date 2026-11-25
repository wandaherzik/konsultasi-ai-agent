@extends('layouts.home.dokter.app')

@section('page-title', 'Riwayat Konsultasi Pasien')

@section('content')

<div class="page-inner">

    {{-- HEADER --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Riwayat Konsultasi Pasien
            </h3>

            <p class="text-muted mb-0">
                Pilih konsultasi AI yang akan digunakan
                sebagai dasar pemeriksaan pasien.
            </p>

        </div>

        <a
            href="{{ route('dokter.antrian.index') }}"
            class="btn btn-secondary"
        >
            <i class="fas fa-arrow-left me-1"></i>
            Kembali
        </a>

    </div>


    {{-- INFORMASI PASIEN --}}

    <div class="card card-round mb-4">

        <div class="card-header">

            <h4 class="card-title">
                Informasi Pasien
            </h4>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <small class="text-muted">
                        Nama Pasien
                    </small>

                    <h5 class="fw-bold">
                        {{ $antrian->pasien->nama_pasien }}
                    </h5>

                </div>


                <div class="col-md-6">

                    <small class="text-muted">
                        Nomor Antrean
                    </small>

                    <h5 class="fw-bold">
                        {{ $antrian->no_antrian }}
                    </h5>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FILTER KONSULTASI --}}
    {{-- ========================================================= --}}

    <div class="card card-round mb-4">

        <div class="card-header">

            <h4 class="card-title mb-1">
                Filter Riwayat Konsultasi
            </h4>

            <small class="text-muted">
                Gunakan filter untuk menemukan konsultasi
                yang sesuai dengan keluhan pasien.
            </small>

        </div>


        <div class="card-body">

            <form
                action="{{ route(
                    'dokter.rekam-medis.pilih-konsultasi',
                    $antrian->id_antrian
                ) }}"
                method="GET"
            >

                <div class="row g-3">


                    {{-- CARI KELUHAN --}}

                    <div class="col-md-5">

                        <label class="form-label fw-bold">

                            <i class="fas fa-search me-1"></i>

                            Cari Keluhan

                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Contoh: demam, batuk, sakit kepala..."
                        >

                    </div>


                    {{-- FILTER POLI --}}

                    <div class="col-md-3">

                        <label class="form-label fw-bold">

                            <i class="fas fa-hospital me-1"></i>

                            Poli

                        </label>

                        <select
                            name="poli"
                            class="form-select"
                        >

                            <option value="">
                                Semua Poli
                            </option>

                            @foreach($daftarPoli as $poli)

                                <option
                                    value="{{ $poli }}"
                                    {{ request('poli') == $poli
                                        ? 'selected'
                                        : '' }}
                                >
                                    {{ $poli }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- FILTER TANGGAL --}}

                    <div class="col-md-3">

                        <label class="form-label fw-bold">

                            <i class="far fa-calendar-alt me-1"></i>

                            Tanggal Konsultasi

                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="{{ request('tanggal') }}"
                        >

                    </div>


                    {{-- TOMBOL --}}

                    <div class="col-md-1 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                            title="Cari"
                        >

                            <i class="fas fa-search"></i>

                        </button>

                    </div>

                </div>


                {{-- RESET FILTER --}}

                @if(
                    request()->filled('search') ||
                    request()->filled('poli') ||
                    request()->filled('tanggal')
                )

                    <div class="mt-3">

                        <a
                            href="{{ route(
                                'dokter.rekam-medis.pilih-konsultasi',
                                $antrian->id_antrian
                            ) }}"
                            class="btn btn-sm btn-outline-secondary"
                        >

                            <i class="fas fa-times me-1"></i>

                            Reset Filter

                        </a>

                    </div>

                @endif

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RIWAYAT KONSULTASI --}}
    {{-- ========================================================= --}}

    @if($riwayatKonsultasi->isEmpty())

        <div class="alert alert-warning">

            <i class="fas fa-info-circle me-2"></i>

            @if(
                request()->filled('search') ||
                request()->filled('poli') ||
                request()->filled('tanggal')
            )

                Tidak ditemukan konsultasi AI yang sesuai
                dengan filter yang dipilih.

            @else

                Pasien belum memiliki konsultasi AI
                yang telah selesai.

            @endif

        </div>

    @else

        <div class="card card-round">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h4 class="card-title mb-1">
                            Konsultasi AI Selesai
                        </h4>

                        <small class="text-muted">

                            Menampilkan
                            {{ $riwayatKonsultasi->count() }}
                            dari
                            {{ $riwayatKonsultasi->total() }}
                            konsultasi

                        </small>

                    </div>

                </div>

            </div>


            <div class="card-body">


                @foreach(
                    $riwayatKonsultasi
                    as $konsultasi
                )

                    <div class="card border mb-3">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-8">

                                    {{-- KELUHAN --}}

                                    <h5 class="fw-bold mb-2">

                                        {{ $konsultasi->keluhan_pasien
                                            ?? 'Keluhan tidak tersedia' }}

                                    </h5>


                                    {{-- DIAGNOSA --}}

                                    <p class="mb-1">

                                        <strong>
                                            Diagnosa Awal:
                                        </strong>

                                        {{ $konsultasi->diagnosa_awal
                                            ?? '-' }}

                                    </p>


                                    {{-- POLI --}}

                                    <p class="mb-1">

                                        <strong>
                                            Poli:
                                        </strong>

                                        {{ $konsultasi->saran_poli
                                            ?? '-' }}

                                    </p>


                                    {{-- TANGGAL --}}

                                    <small class="text-muted">

                                        <i
                                            class="far fa-calendar-alt me-1"
                                        ></i>

                                        Selesai:

                                        {{ $konsultasi->updated_at
                                            ? $konsultasi->updated_at->format(
                                                'd F Y H:i'
                                            )
                                            : '-' }}

                                    </small>

                                </div>


                                {{-- TOMBOL PILIH --}}

                                <div
                                    class="col-md-4
                                           d-flex
                                           align-items-center
                                           justify-content-end"
                                >

                                    <a
                                        href="{{ route(
                                            'dokter.rekam-medis.create',
                                            [
                                                'id' =>
                                                    $antrian->id_antrian,

                                                'idKonsultasi' =>
                                                    $konsultasi->id_konsultasi_ai,
                                            ]
                                        ) }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="fas fa-check me-1"></i>

                                        Pilih Konsultasi

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach


            </div>

        </div>

    @endif

</div>

@endsection