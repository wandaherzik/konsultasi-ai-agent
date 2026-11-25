@extends('layouts.home.pasien.app')

@section('page-title', 'Detail Rekam Medis')

@section(
    'page-description',
    'Detail riwayat pemeriksaan kesehatan'
)

@section('content')

<div class="page-inner">

    {{-- HEADER --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Detail Rekam Medis
            </h3>

            <p class="text-muted mb-0">
                Detail riwayat pemeriksaan Anda
            </p>

        </div>

        <a
            href="{{ route('pasien.rekam-medis.index') }}"
            class="btn btn-secondary"
        >

            <i class="fas fa-arrow-left me-1"></i>

            Kembali

        </a>

    </div>


    {{-- INFORMASI PEMERIKSAAN --}}

    <div class="card card-round mb-4">

        <div class="card-header">

            <h4 class="card-title">
                Informasi Pemeriksaan
            </h4>

        </div>

        <div class="card-body">

            <div class="row">

                {{-- TANGGAL --}}

                <div class="col-md-6 mb-3">

                    <small class="text-muted">
                        Tanggal Pemeriksaan
                    </small>

                    <h5 class="fw-bold">

                        {{
                            $rekamMedis->created_at
                            ? $rekamMedis->created_at
                                ->translatedFormat('d F Y H:i')
                            : '-'
                        }}

                    </h5>

                </div>


                {{-- DOKTER --}}

                <div class="col-md-6 mb-3">

                    <small class="text-muted">
                        Dokter
                    </small>

                    <h5 class="fw-bold">

                        {{
                            $rekamMedis->dokter
                                ?->nama_dokter
                            ?? '-'
                        }}

                    </h5>

                </div>


                {{-- POLI --}}

                <div class="col-md-6 mb-3">

                    <small class="text-muted">
                        Poli
                    </small>

                    <h5 class="fw-bold">

                        {{
                            $rekamMedis->antrian
                                ?->poli
                                ?->nama_poli
                            ?? '-'
                        }}

                    </h5>

                </div>


                {{-- ID REKAM MEDIS --}}

                <div class="col-md-6 mb-3">

                    <small class="text-muted">
                        ID Rekam Medis
                    </small>

                    <h5 class="fw-bold">

                        {{ $rekamMedis->id_rekammedis }}

                    </h5>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
{{-- HASIL KONSULTASI AI --}}
{{-- ========================================================= --}}

@if($rekamMedis->konsultasiAI)

    <div class="card card-round mb-4">

        <div class="card-header">

            <div>

                <h4 class="card-title mb-1">
                    Hasil Konsultasi AI
                </h4>

                <small class="text-muted">
                    Ringkasan konsultasi yang digunakan
                    dalam pemeriksaan ini
                </small>

            </div>

        </div>


        <div class="card-body">

            {{-- HEADER --}}

            <div class="d-flex justify-content-between
                        align-items-start mb-3">

                <div>

                    <h6 class="fw-bold mb-1">

                        Konsultasi AI

                        <span class="text-muted">

                            #{{ $rekamMedis->konsultasiAI
                                ->id_konsultasi_ai }}

                        </span>

                    </h6>


                    <small class="text-muted">

                        <i class="far fa-calendar-alt me-1"></i>

                        {{
                            $rekamMedis->konsultasiAI->updated_at
                            ? $rekamMedis->konsultasiAI
                                ->updated_at
                                ->format('d F Y H:i')
                            : '-'
                        }}

                    </small>

                </div>


                <span class="badge bg-success">

                    Selesai

                </span>

            </div>


            {{-- KELUHAN --}}

            <div class="mb-3">

                <label class="text-muted fw-bold">

                    Keluhan Pasien

                </label>

                <div class="bg-light rounded p-3 mt-1">

                    {{
                        $rekamMedis->konsultasiAI
                            ->keluhan_pasien
                        ?: '-'
                    }}

                </div>

            </div>


            {{-- INFORMASI AI --}}

            <div class="row">

                {{-- DIAGNOSA AWAL --}}

                <div class="col-md-6 mb-3">

                    <label class="text-muted fw-bold">

                        Diagnosa Awal AI

                    </label>

                    <div class="bg-light rounded p-3 mt-1">

                        {{
                            $rekamMedis->konsultasiAI
                                ->diagnosa_awal
                            ?: '-'
                        }}

                    </div>

                </div>


                {{-- POLI --}}

                <div class="col-md-6 mb-3">

                    <label class="text-muted fw-bold">

                        Rekomendasi Poli

                    </label>

                    <div class="bg-light rounded p-3 mt-1">

                        {{
                            $rekamMedis->konsultasiAI
                                ->saran_poli
                            ?: '-'
                        }}

                    </div>

                </div>


                {{-- DOKTER --}}

                <div class="col-md-6 mb-3">

                    <label class="text-muted fw-bold">

                        Rekomendasi Dokter

                    </label>

                    <div class="bg-light rounded p-3 mt-1">

                        {{
                            $rekamMedis->konsultasiAI
                                ->rekomendasi_dokter
                            ?: '-'
                        }}

                    </div>

                </div>


                {{-- SKOR URGENSI --}}

                <div class="col-md-6 mb-3">

                    <label class="text-muted fw-bold">

                        Skor Urgensi

                    </label>

                    <div class="bg-light rounded p-3 mt-1">

                        @if(
                            $rekamMedis->konsultasiAI
                                ->skor_urgensi !== null
                        )

                            {{
                                $rekamMedis->konsultasiAI
                                    ->skor_urgensi
                            }}

                            <span class="text-muted">
                                / 100
                            </span>

                        @else

                            -

                        @endif

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- RINGKASAN / RESPONS AI --}}
            {{-- ================================================= --}}

            <div>

                <label class="text-muted fw-bold">

                    Ringkasan / Respons AI

                </label>

                <div class="bg-light rounded p-3 mt-1">

                    {!! nl2br(
                        e(
                            $rekamMedis->konsultasiAI
                                ->respon_ai
                            ?: '-'
                        )
                    ) !!}

                </div>

            </div>

        </div>

    </div>

@else

    <div class="card card-round mb-4">

        <div class="card-body">

            <div class="text-center py-4">

                <i class="fas fa-robot fa-2x
                          text-muted mb-3"></i>

                <p class="text-muted mb-0">

                    Tidak terdapat data konsultasi AI
                    yang terkait dengan pemeriksaan ini.

                </p>

            </div>

        </div>

    </div>

@endif


    {{-- HASIL PEMERIKSAAN DOKTER --}}

    <div class="card card-round">

        <div class="card-header">

            <h4 class="card-title">
                Hasil Pemeriksaan Dokter
            </h4>

        </div>

        <div class="card-body">

            {{-- KELUHAN --}}

            <div class="mb-4">

                <label class="text-muted fw-bold">
                    Keluhan Pasien
                </label>

                <div class="bg-light rounded p-3 mt-2">

                    {{
                        $rekamMedis->keluhan_pasien
                        ?: '-'
                    }}

                </div>

            </div>


            {{-- DIAGNOSA AWAL --}}

            <div class="mb-4">

                <label class="text-muted fw-bold">
                    Diagnosa Awal
                </label>

                <div class="bg-light rounded p-3 mt-2">

                    {{
                        $rekamMedis->diagnosa_awal
                        ?: '-'
                    }}

                </div>

            </div>


            {{-- DIAGNOSA AKHIR --}}

            <div class="mb-4">

                <label class="text-muted fw-bold">
                    Diagnosa Akhir
                </label>

                <div>

                    <div class="alert alert-info mb-0">

                        <i class="fas fa-stethoscope me-2"></i>

                        <strong>

                            {{
                                $rekamMedis->diagnosa_akhir
                                ?: '-'
                            }}

                        </strong>

                    </div>

                </div>

            </div>


            {{-- TINDAKAN --}}

            <div class="mb-4">

                <label class="text-muted fw-bold">
                    Tindakan
                </label>

                <div class="bg-light rounded p-3 mt-2">

                    {{
                        $rekamMedis->tindakan
                        ?: '-'
                    }}

                </div>

            </div>


            {{-- CATATAN --}}

            <div>

                <label class="text-muted fw-bold">
                    Catatan Dokter
                </label>

                <div class="bg-light rounded p-3 mt-2">

                    {{
                        $rekamMedis->catatan
                        ?: '-'
                    }}

                </div>

            </div>

        </div>


        <div class="card-footer">

            <small class="text-muted">

                <i class="far fa-calendar-alt me-1"></i>

                Dicatat pada:

                {{
                    $rekamMedis->created_at
                    ? $rekamMedis->created_at
                        ->translatedFormat('d F Y H:i')
                    : '-'
                }}

            </small>

        </div>

    </div>

</div>

@endsection