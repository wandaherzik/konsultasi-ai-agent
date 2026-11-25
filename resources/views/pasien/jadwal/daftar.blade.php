@extends('layouts.home.pasien.app')

@section('page-title', 'Pendaftaran Antrean')

@section(
    'page-description',
    'Konfirmasi pendaftaran konsultasi dengan dokter'
)

@section('content')

<div class="col-md-8 mx-auto">

    <div class="card card-round">

        <div class="card-header">

            <div class="card-title">
                Konfirmasi Pendaftaran Antrean
            </div>

        </div>


        <div class="card-body">

            <div class="alert alert-info">

                <i class="fas fa-info-circle me-1"></i>

                Pastikan jadwal dokter yang Anda pilih
                sudah sesuai sebelum melanjutkan.

            </div>


            {{-- Informasi Dokter --}}

            <div class="mb-4">

                <h5 class="mb-3">
                    Informasi Dokter
                </h5>


                <div class="row mb-2">

                    <div class="col-md-4 text-muted">
                        Dokter
                    </div>

                    <div class="col-md-8">

                        <strong>
                            {{
                                $jadwalDokter
                                    ->dokter
                                    ->nama_dokter
                            }}
                        </strong>

                    </div>

                </div>


                <div class="row mb-2">

                    <div class="col-md-4 text-muted">
                        Spesialisasi
                    </div>

                    <div class="col-md-8">

                        {{
                            $jadwalDokter
                                ->dokter
                                ->spesialisasi_dokter
                        }}

                    </div>

                </div>


                <div class="row mb-2">

                    <div class="col-md-4 text-muted">
                        Poli
                    </div>

                    <div class="col-md-8">

                        <span class="badge bg-info">

                            {{
                                $jadwalDokter
                                    ->poli
                                    ->nama_poli
                            }}

                        </span>

                    </div>

                </div>


                <div class="row mb-2">

                    <div class="col-md-4 text-muted">
                        Hari
                    </div>

                    <div class="col-md-8">

                        <strong>
                            {{ $jadwalDokter->hari }}
                        </strong>

                    </div>

                </div>


                <div class="row">

                    <div class="col-md-4 text-muted">
                        Jam Pelayanan
                    </div>

                    <div class="col-md-8">

                        <i class="far fa-clock me-1"></i>

                        {{
                            \Carbon\Carbon::parse(
                                $jadwalDokter->jam_buka
                            )->format('H:i')
                        }}

                        -

                        {{
                            \Carbon\Carbon::parse(
                                $jadwalDokter->jam_tutup
                            )->format('H:i')
                        }}

                    </div>

                </div>

            </div>


            <hr>


            {{-- Tanggal Kunjungan --}}

            <form
                action="{{ route(
                    'pasien.antrian.store'
                ) }}"
                method="POST"
            >

                @csrf


                <input
                    type="hidden"
                    name="id_jadwaldokter"
                    value="{{ $jadwalDokter->id_jadwaldokter }}"
                >


                <div class="mb-4">

                    <label
                        for="tanggal_kunjungan"
                        class="form-label"
                    >
                        Tanggal Kunjungan
                    </label>

                    <input
                        type="date"
                        id="tanggal_kunjungan"
                        name="tanggal_kunjungan"
                        class="form-control
                               @error('tanggal_kunjungan')
                                   is-invalid
                               @enderror"
                        value="{{ old(
                            'tanggal_kunjungan'
                        ) }}"
                        required
                    >

                    @error('tanggal_kunjungan')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="d-flex
                            justify-content-between">

                    <a
                        href="{{ route(
                            'pasien.jadwal.index'
                        ) }}"
                        class="btn btn-secondary"
                    >

                        <i class="fas fa-arrow-left me-1"></i>

                        Kembali

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-check me-1"></i>

                        Konfirmasi Pendaftaran

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection