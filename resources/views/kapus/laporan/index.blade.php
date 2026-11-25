@extends('layouts.home.kapus.app')

@section('page-title', 'Laporan Kunjungan')

@section(
    'page-description',
    'Laporan kunjungan pasien Puskesmas'
)

@section('content')

<div class="col-md-12">

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div>

                    <h4 class="card-title mb-1">
                        Laporan Kunjungan Pasien
                    </h4>

                </div>

            </div>

        </div>


        <div class="card-body">



            <div class="row">

    {{-- Total Kunjungan --}}
    <div class="col-md-3">

        <div class="card card-round">

            <div class="card-body">

                <div class="d-flex align-items-center">

                    <div class="avatar avatar-lg">

                        <span class="avatar-title rounded-circle bg-primary">

                            <i class="fas fa-users"></i>

                        </span>

                    </div>

                    <div class="ms-3">

                        <p class="text-muted mb-1">
                            Total Kunjungan
                        </p>

                        <h3 class="mb-0">
                            {{ $totalKunjungan }}
                        </h3>

                    </div>

                </div>

            </div>

        </div>

    </div>

    

    {{-- Rekap Poli --}}
    @foreach($rekapPoli as $namaPoli => $total)

        <div class="col-md-3">

            <div class="card card-round">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="avatar avatar-lg">

                            <span class="avatar-title rounded-circle bg-info">

                                <i class="fas fa-hospital"></i>

                            </span>

                        </div>

                        <div class="ms-3">

                            <p class="text-muted mb-1">

                                {{ $namaPoli }}

                            </p>

                            <h3 class="mb-0">

                                {{ $total }}

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>

            {{-- Filter --}}

            <form
                action="{{ route('kapus.laporan.index') }}"
                method="GET"
                class="mb-4"
            >

                <div class="row">

                <div class="col-md-2">

    <label class="form-label">
        Poli
    </label>

    <select
        name="id_poli"
        class="form-select"
    >

        <option value="">
            Semua Poli
        </option>

        @foreach($polis as $poli)

            <option
                value="{{ $poli->id_poli }}"
                {{ request('id_poli') == $poli->id_poli ? 'selected' : '' }}
            >
                {{ $poli->nama_poli }}
            </option>

        @endforeach

    </select>

</div>

                    <div class="col-md-3">

                        <label class="form-label">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            class="form-control"
                            value="{{ request('tanggal_mulai') }}"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label">
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="tanggal_selesai"
                            class="form-control"
                            value="{{ request('tanggal_selesai') }}"
                        >

                    </div>
                    


                    <div class="col-md-4 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary me-2"
                        >

                            <i class="fas fa-filter me-1"></i>

                            Filter

                        </button>


                        <a
                            href="{{ route('kapus.laporan.index') }}"
                            class="btn btn-secondary me-2"
                        >

                            <i class="fas fa-sync-alt me-1"></i>

                            Reset

                        </a>

                            <a
        href="{{ route(
            'kapus.kapus.laporan.export-pdf',
            request()->query()
        ) }}"
        class="btn btn-danger me-2"
        target="_blank"
    >

        <i class="fas fa-file-pdf me-1"></i>

    </a>

    <a
    href="{{ route(
        'kapus.laporan.export-excel',
        request()->query()
    ) }}"
    class="btn btn-success me-2"
>
    <i class="fas fa-file-excel me-1"></i>

</a>

                    </div>

                </div>

            </form>


            {{-- Tabel --}}

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>No. Antrean</th>

                            <th>Pasien</th>

                            <th>Dokter</th>

                            <th>Poli</th>

                            <th>Diagnosa Akhir</th>

                            <th>Tindakan</th>

                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse(
                            $laporans as $laporan
                        )

                            <tr>

                                <td>
                                    {{
                                        $laporans->firstItem()
                                        + $loop->index
                                    }}
                                </td>


                                <td>
                                    {{
                                        $laporan->created_at
                                            ->format('d-m-Y')
                                    }}
                                </td>


                                <td>

                                    <span class="badge bg-primary">

                                        {{
                                            $laporan
                                                ->antrian
                                                ->no_antrian
                                        }}

                                    </span>

                                </td>


                                <td>

                                    {{
                                        $laporan
                                            ->nama_pasien
                                    }}

                                </td>


                                <td>

                                    {{
                                        $laporan
                                            ->dokter
                                            ->nama_dokter
                                    }}

                                </td>


                                <td>

                                    {{
                                        $laporan
                                            ->antrian
                                            ->poli
                                            ->nama_poli
                                    }}

                                </td>


                                <td>

                                    {{
                                        $laporan
                                            ->diagnosa_akhir
                                    }}

                                </td>


                                <td>

                                    {{
                                        $laporan
                                            ->tindakan
                                    }}

                                </td>


                                <td>

                                    <span class="badge bg-success">

                                        Selesai

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="fas fa-file-medical
                                               fa-3x
                                               text-muted
                                               mb-3"
                                    ></i>

                                    <h5>
                                        Belum Ada Data Kunjungan
                                    </h5>

                                    <p class="text-muted mb-0">

                                        Belum terdapat rekam medis
                                        pada periode yang dipilih.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}

            @if($laporans->hasPages())

                <div class="d-flex justify-content-end mt-3">

                    {{ $laporans->links() }}

                </div>

            @endif

        </div>


    </div>

</div>

@endsection