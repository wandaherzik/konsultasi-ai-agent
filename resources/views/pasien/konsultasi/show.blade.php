@extends('layouts.home.pasien.app')

@section('page-title', 'Konsultasi AI')

@section(
    'page-description',
    'Riwayat dan hasil konsultasi AI'
)

@section('content')

<div class="row justify-content-center">

    <div class="col-md-10">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <div class="card card-round mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h4 class="fw-bold mb-1">

                            <i class="fas fa-robot text-primary me-2"></i>

                            Konsultasi AI

                        </h4>

                        <p class="text-muted mb-0">

                            Konsultasi #{{ $konsultasi->id_konsultasi_ai }}

                        </p>

                    </div>


                    <div>

                        @if(
                            $konsultasi->status_konsultasi
                            === 'berlangsung'
                        )

                            <span class="badge bg-success">

                                <i class="fas fa-circle me-1"></i>

                                Sedang Berlangsung

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                <i class="fas fa-check-circle me-1"></i>

                                Selesai

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- HASIL ANALISIS AI --}}
        {{-- ===================================================== --}}

        @if(
            $konsultasi->diagnosa_awal ||
            $konsultasi->saran_poli ||
            $konsultasi->rekomendasi_dokter ||
            $konsultasi->skor_urgensi !== null
        )

        <div class="card card-round mb-4">

            <div class="card-header">

                <div class="card-title">

                    <i class="fas fa-clipboard-check text-primary me-2"></i>

                    Hasil Analisis Awal

                </div>

            </div>


            <div class="card-body">

                {{-- Peringatan --}}

                <div class="alert alert-info">

                    <div class="d-flex">

                        <div class="me-3">

                            <i class="fas fa-info-circle fa-lg"></i>

                        </div>

                        <div>

                            <strong>Informasi Penting</strong>

                            <p class="mb-0 mt-1">

                                Hasil ini merupakan analisis awal dari
                                AI Agent dan bukan merupakan diagnosis
                                dokter. Pemeriksaan langsung oleh tenaga
                                medis tetap diperlukan.

                            </p>

                        </div>

                    </div>

                </div>


                <div class="row mt-4">


                    {{-- Diagnosis --}}

                    <div class="col-md-6 mb-4">

                        <div class="border rounded p-3 h-100">

                            <div class="d-flex align-items-center mb-2">

                                <div class="me-3">

                                    <i
                                        class="fas fa-stethoscope
                                               text-primary fa-lg"
                                    ></i>

                                </div>

                                <div>

                                    <small class="text-muted">

                                        Analisis Awal

                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        Kemungkinan Kondisi

                                    </h6>

                                </div>

                            </div>


                            <p class="mb-0">

                                {{ $konsultasi->diagnosa_awal ?? '-' }}

                            </p>

                        </div>

                    </div>


                    {{-- Urgensi --}}

                    <div class="col-md-6 mb-4">

                        <div class="border rounded p-3 h-100">

                            <div class="d-flex align-items-center mb-2">

                                <div class="me-3">

                                    <i
                                        class="fas fa-exclamation-triangle
                                               text-warning fa-lg"
                                    ></i>

                                </div>

                                <div>

                                    <small class="text-muted">

                                        Tingkat Urgensi

                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        Prioritas Keluhan

                                    </h6>

                                </div>

                            </div>


                            @if(
                                $konsultasi->skor_urgensi !== null
                            )

                                @php

                                    $skor =
                                        (int)
                                        $konsultasi->skor_urgensi;

                                    if ($skor <= 25) {

                                        $kategori =
                                            'Rendah';

                                        $badge =
                                            'success';

                                    } elseif ($skor <= 60) {

                                        $kategori =
                                            'Sedang';

                                        $badge =
                                            'warning';

                                    } else {

                                        $kategori =
                                            'Tinggi';

                                        $badge =
                                            'danger';

                                    }

                                @endphp


                                <div class="d-flex align-items-center">

                                    <h3 class="fw-bold mb-0 me-2">

                                        {{ $skor }}%

                                    </h3>

                                    <span
                                        class="badge bg-{{ $badge }}"
                                    >

                                        {{ $kategori }}

                                    </span>

                                </div>

                            @else

                                <span class="text-muted">

                                    Belum tersedia

                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- Poli --}}

                    <div class="col-md-6 mb-4">

                        <div class="border rounded p-3 h-100">

                            <div class="d-flex align-items-center mb-2">

                                <div class="me-3">

                                    <i
                                        class="fas fa-hospital
                                               text-info fa-lg"
                                    ></i>

                                </div>

                                <div>

                                    <small class="text-muted">

                                        Rekomendasi Layanan

                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        Poli / Klaster

                                    </h6>

                                </div>

                            </div>


                            @if($konsultasi->saran_poli)

                                <h5 class="fw-bold text-primary mb-0">

                                    {{ $konsultasi->saran_poli }}

                                </h5>

                            @else

                                <span class="text-muted">

                                    Belum tersedia

                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- Dokter --}}

                    <div class="col-md-6 mb-4">

                        <div class="border rounded p-3 h-100">

                            <div class="d-flex align-items-center mb-2">

                                <div class="me-3">

                                    <i
                                        class="fas fa-user-md
                                               text-success fa-lg"
                                    ></i>

                                </div>

                                <div>

                                    <small class="text-muted">

                                        Rekomendasi Dokter

                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        Dokter yang Bertugas

                                    </h6>

                                </div>

                            </div>


@if($konsultasi->rekomendasi_dokter)

        @foreach(explode(',', $konsultasi->rekomendasi_dokter) as $dokter)

            <div class="d-flex align-items-center mb-2">

                <div class="avatar avatar-sm me-2">

                    <span class="avatar-title rounded-circle bg-primary">

                        <i class="fas fa-user-md"></i>

                    </span>

                </div>

                <div>
                    <strong>
                        {{ trim($dokter) }}
                    </strong>
                </div>

            </div>

        @endforeach

    @else

        <span class="text-muted">
            Belum tersedia
        </span>

    @endif

                        </div>

                    </div>

                </div>


                {{-- Catatan --}}

                <div class="alert alert-warning mb-0">

                    <i class="fas fa-exclamation-circle me-2"></i>

                    <strong>Catatan:</strong>

                    Rekomendasi poli dan dokter merupakan hasil
                    pengolahan sistem berdasarkan hasil konsultasi.
                    Pasien tetap disarankan melakukan pemeriksaan
                    langsung oleh dokter.

                </div>

            </div>

        </div>

        @endif


        {{-- ===================================================== --}}
        {{-- RIWAYAT PERCAKAPAN --}}
        {{-- ===================================================== --}}

        <div class="card card-round mb-4">

            <div class="card-header">

                <div class="card-title">

                    <i class="fas fa-comments text-primary me-2"></i>

                    Percakapan Konsultasi

                </div>

            </div>


            <div class="card-body">

                <div
                    style="
                        max-height: 500px;
                        overflow-y: auto;
                    "
                    class="pe-2"
                >

                    @forelse(
                        $konsultasi->pesan as $pesan
                    )

                        @if($pesan->pengirim === 'pasien')

                            {{-- Pesan Pasien --}}

                            <div class="d-flex justify-content-end mb-4">

                                <div
                                    class="text-end"
                                    style="max-width: 75%;"
                                >

                                    <div
                                        class="small text-muted mb-1"
                                    >

                                        Anda

                                    </div>


                                    <div
                                        class="bg-primary text-white
                                               rounded p-3 text-start"
                                    >

                                        {{ $pesan->pesan }}

                                    </div>

                                </div>

                            </div>

                        @else

                            {{-- Pesan AI --}}

                            <div class="d-flex mb-4">

                                <div class="me-2">

                                    <span
                                        class="avatar avatar-sm
                                               bg-primary
                                               text-white"
                                    >

                                        <i class="fas fa-robot"></i>

                                    </span>

                                </div>


                                <div
                                    style="max-width: 75%;"
                                >

                                    <div
                                        class="small text-muted mb-1"
                                    >

                                        AI Agent

                                    </div>


                                    <div
                                        class="bg-light rounded p-3"
                                    >

                                        {{ $pesan->pesan }}

                                    </div>

                                </div>

                            </div>

                        @endif

                    @empty

                        <div class="text-center text-muted py-5">

                            <i
                                class="fas fa-comments fa-3x mb-3"
                            ></i>

                            <p class="mb-0">

                                Belum terdapat percakapan.

                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- INPUT PESAN LANJUTAN --}}
        {{-- ===================================================== --}}

        @if(
            $konsultasi->status_konsultasi
            === 'berlangsung'
        )

        <div class="card card-round mb-4">

            <div class="card-header">

                <div class="card-title">

                    <i class="fas fa-paper-plane text-primary me-2"></i>

                    Lanjutkan Konsultasi

                </div>

            </div>


            <div class="card-body">

                <form
                    action="{{
                        route(
                            'pasien.pasien.konsultasi.send',
                            $konsultasi->id_konsultasi_ai
                        )
                    }}"
                    method="POST"
                >

                    @csrf


                    <div class="mb-3">

                        <textarea
                            name="pesan"
                            class="form-control"
                            rows="4"
                            placeholder="Sampaikan informasi tambahan atau jawab pertanyaan AI..."
                            required
                        ></textarea>

                    </div>


                    <div
                        class="d-flex
                               justify-content-between
                               align-items-center"
                    >

                        <small class="text-muted">

                            <i class="fas fa-shield-alt me-1"></i>

                            Jangan gunakan AI sebagai pengganti
                            pemeriksaan dokter.

                        </small>


                        <button
                            type="submit"
                            class="btn btn-primary btn-round"
                        >

                            <i class="fas fa-paper-plane me-1"></i>

                            Kirim Pesan

                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- AKHIRI KONSULTASI --}}
        {{-- ===================================================== --}}

         <div class="card card-round mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="fw-bold mb-1">
                        Sudah selesai berkonsultasi?
                    </h6>

                    <small class="text-muted">
                        Anda dapat mengakhiri konsultasi kapan saja.
                    </small>

                </div>

                <form
                    action="{{ route(
                        'pasien.pasien.konsultasi.finish',
                        ['id' => $konsultasi->id_konsultasi_ai]
                    ) }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-danger"
                        onclick="return confirm(
                            'Apakah Anda yakin ingin mengakhiri konsultasi ini?'
                        );"
                    >

                        <i class="fas fa-check-circle me-1"></i>

                        Akhiri Konsultasi

                    </button>

                </form>

            </div>

        </div>

    </div>

        @else

            {{-- Konsultasi selesai --}}

            <div class="alert alert-success">

                <i
                    class="fas fa-check-circle me-2"
                ></i>

                Konsultasi ini telah selesai.

                Anda dapat melihat kembali hasil
                analisis dan riwayat percakapan di halaman ini.

            </div>

        @endif

        @if($konsultasi->status_konsultasi === 'selesai')

    <a
        href="{{ route(
            'pasien.pasien.antrian.create',
            [
                'id_konsultasi_ai' =>
                    $konsultasi->id_konsultasi_ai
            ]
        ) }}"
        class="btn btn-primary"
    >

        <i class="fas fa-calendar-plus me-1"></i>

        Gunakan Hasil Konsultasi untuk Antrean

    </a>

@endif


        {{-- ===================================================== --}}
        {{-- KEMBALI --}}
        {{-- ===================================================== --}}

        <div class="d-flex justify-content-between mb-4">

            <a
                href="{{
                    route(
                        'pasien.pasien.konsultasi.index'
                    )
                }}"
                class="btn btn-light"
            >

                <i class="fas fa-arrow-left me-1"></i>

                Kembali ke Riwayat Konsultasi

            </a>

        </div>

    </div>

</div>

@endsection

