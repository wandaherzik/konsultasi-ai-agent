@extends('layouts.home.pasien.app')

@section('page-title', 'Antrean Saya')

@section(
    'page-description',
    'Informasi pendaftaran dan antrean kunjungan Anda'
)

@section('content')

<div class="col-md-12">

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div class="card-title">
                    Antrean Saya
                </div>

                <div class="card-tools">

                    <a
                        href="{{ route(
                            'pasien.jadwal.index'
                        ) }}"
                        class="btn btn-primary btn-round"
                    >

                        <i class="fas fa-calendar-alt me-1"></i>

                        Jadwal Dokter

                    </a>

                </div>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>No. Antrean</th>

                            <th>Dokter</th>

                            <th>Poli</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($antrians as $antrian)

                            <tr>

                                <td>
                                    {{
                                        $antrians->firstItem()
                                        + $loop->index
                                    }}
                                </td>


                                <td>

                                    <span
                                        class="badge bg-primary"
                                    >
                                        {{ $antrian->no_antrian }}
                                    </span>

                                </td>


                                <td>

                                    @if($antrian->jadwalDokter)

                                        {{
                                            $antrian
                                                ->jadwalDokter
                                                ->dokter
                                                ->nama_dokter
                                        }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    {{
                                        $antrian
                                            ->poli
                                            ->nama_poli
                                    }}

                                </td>


                                <td>

                                    {{
                                        \Carbon\Carbon::parse(
                                            $antrian
                                                ->tanggal_kunjungan
                                        )->format('d-m-Y')
                                    }}

                                </td>


                                <td>

                                    @php

                                        $badge = match(
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

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="fas fa-ticket-alt
                                               fa-3x
                                               text-muted
                                               mb-3"
                                    ></i>

                                    <h5>
                                        Belum Ada Antrean
                                    </h5>

                                    <p
                                        class="text-muted"
                                    >
                                        Anda belum melakukan
                                        pendaftaran antrean.
                                    </p>

                                    <a
                                        href="{{
                                            route(
                                                'pasien.jadwal.index'
                                            )
                                        }}"
                                        class="btn btn-primary"
                                    >

                                        Lihat Jadwal Dokter

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($antrians->hasPages())

                <div
                    class="d-flex
                           justify-content-end
                           mt-3"
                >

                    {{ $antrians->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection