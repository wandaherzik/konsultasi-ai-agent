@extends('layouts.home.dokter.app')

@section('page-title', 'Antrean Pasien')

@section(
    'page-description',
    'Kelola antrean pasien pada jadwal pelayanan Anda'
)

@section('content')

<div class="col-md-12">

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div>

                    <h4 class="card-title mb-1">
                        Antrean Pasien
                    </h4>

                    <p class="text-muted mb-0">

                        {{ $dokter->nama_dokter }}

                        -

                        {{ $hariIni->translatedFormat('l, d F Y') }}

                    </p>

                </div>


                <div class="card-tools">

                    <span class="badge bg-primary">

                        {{ $antrians->count() }}

                        Pasien

                    </span>

                </div>

            </div>

        </div>


        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">

                    <i class="fas fa-check-circle me-1"></i>

                    {{ session('success') }}

                </div>

            @endif


            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>No. Antrean</th>

                            <th>Nama Pasien</th>

                            <th>Poli</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($antrians as $antrian)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <span
                                        class="badge bg-primary"
                                        style="font-size: 14px;"
                                    >

                                        {{ $antrian->no_antrian }}

                                    </span>

                                </td>


                                <td>

                                    {{ $antrian
                                        ->pasien
                                        ->nama_pasien }}

                                </td>


                                <td>

                                    {{ $antrian
                                        ->poli
                                        ->nama_poli }}

                                </td>


                                <td>

                                    @php

                                        $badge = match (
                                            $antrian->status_antrian
                                        ) {

                                            'menunggu'
                                                => 'warning',

                                            'dipanggil'
                                                => 'primary',

                                            'selesai'
                                                => 'success',

                                            'batal'
                                                => 'danger',

                                            default
                                                => 'secondary',

                                        };

                                    @endphp


                                    <span
                                        class="badge bg-{{
                                            $badge
                                        }}"
                                    >

                                        {{
                                            ucfirst(
                                                $antrian
                                                    ->status_antrian
                                            )
                                        }}

                                    </span>

                                </td>


                                <td>

                                    @if(
                                        $antrian
                                            ->status_antrian
                                        === 'menunggu'
                                    )

                                        <form
                                            action="{{
                                                route(
                                                    'dokter.antrian.panggil',
                                                    $antrian->id_antrian
                                                )
                                            }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-primary"
                                            >

                                                <i
                                                    class="fas fa-bullhorn me-1"
                                                ></i>

                                                Panggil

                                            </button>

                                        </form>

                                    @elseif(
                                        $antrian
                                            ->status_antrian
                                        === 'dipanggil'
                                    )

                                                <a
                                                    href="{{ route(
                                                        'dokter.rekam-medis.pilih-konsultasi',
                                                        $antrian->id_antrian
                                                    ) }}"
                                                    class="btn btn-sm btn-success"
                                                >
                                                    <i class="fas fa-file-medical me-1"></i>
                                                    Rekam Medis
                                                </a>

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-success"
                                            >

                                                <i
                                                    class="fas fa-check me-1"
                                                ></i>

                                                Selesai

                                            </button>

                                        </form>

                                    @else

                                        <span
                                            class="text-muted"
                                        >
                                            -
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="fas fa-users
                                               fa-3x
                                               text-muted
                                               mb-3"
                                    ></i>

                                    <h5>
                                        Belum Ada Antrean
                                    </h5>

                                    <p class="text-muted mb-0">

                                        Belum ada pasien yang
                                        terdaftar untuk jadwal
                                        Anda hari ini.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection