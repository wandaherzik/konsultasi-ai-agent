@extends('layouts.home.pasien.app')

@section('page-title', 'Riwayat Rekam Medis')

@section(
    'page-description',
    'Riwayat pemeriksaan kesehatan Anda'
)

@section('content')

<div class="col-md-12">

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div>

                    <h4 class="card-title mb-1">
                        Riwayat Rekam Medis
                    </h4>

                    <p class="text-muted mb-0">
                        Riwayat pemeriksaan kesehatan Anda
                    </p>

                </div>

                <div class="card-tools">

                    <span class="badge bg-primary">
                        {{ $rekamMedis->total() }}
                        Pemeriksaan
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

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>Dokter</th>

                            <th>Poli</th>

                            <th>Keluhan</th>

                            <th>Diagnosa Akhir</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($rekamMedis as $rekam)

                            <tr>

                                <td>
                                    {{
                                        $rekamMedis->firstItem()
                                        + $loop->index
                                    }}
                                </td>


                                <td>

                                    {{ $rekam->created_at
                                        ? $rekam->created_at
                                            ->translatedFormat('d F Y')
                                        : '-'
                                    }}

                                    <br>

                                    <small class="text-muted">

                                        {{ $rekam->created_at
                                            ? $rekam->created_at
                                                ->format('H:i')
                                            : '-'
                                        }}

                                    </small>

                                </td>


                                <td>

                                    {{
                                        $rekam->dokter
                                            ?->nama_dokter
                                        ?? '-'
                                    }}

                                </td>


                                <td>

                                    {{
                                        $rekam->antrian
                                            ?->poli
                                            ?->nama_poli
                                        ?? '-'
                                    }}

                                </td>


                                <td>

                                    <span
                                        class="d-inline-block text-truncate"
                                        style="max-width: 220px;"
                                    >

                                        {{
                                            $rekam->keluhan_pasien
                                            ?: '-'
                                        }}

                                    </span>

                                </td>


                                <td>

                                    <span class="badge bg-info">

                                        {{
                                            $rekam->diagnosa_akhir
                                            ?: '-'
                                        }}

                                    </span>

                                </td>


                                <td>

                                    <a
                                        href="{{
                                            route(
                                                'pasien.rekam-medis.show',
                                                $rekam->id_rekammedis
                                            )
                                        }}"
                                        class="btn btn-sm btn-primary"
                                    >

                                        <i
                                            class="fas fa-eye me-1"
                                        ></i>

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="fas fa-file-medical fa-3x
                                               text-muted mb-3"
                                    ></i>

                                    <h5>
                                        Belum Ada Rekam Medis
                                    </h5>

                                    <p class="text-muted mb-0">

                                        Anda belum memiliki
                                        riwayat pemeriksaan.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($rekamMedis->hasPages())

                <div class="mt-3">

                    {{ $rekamMedis->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection