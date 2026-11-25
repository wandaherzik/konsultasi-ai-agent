@extends('layouts.home.pasien.app')

@section('page-title', 'Jadwal Dokter')

@section(
    'page-description',
    'Lihat jadwal tugas dokter pada setiap poli'
)

@section('content')

<div class="col-md-12">

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div class="card-title">
                    Jadwal Dokter
                </div>

                <div class="card-tools">

                    <span class="badge bg-primary">
                        {{ $jadwalDokters->total() }} Jadwal
                    </span>

                </div>

            </div>

        </div>


        <div class="card-body">

            {{-- Filter --}}

            <form
                action="{{ route('pasien.jadwal.index') }}"
                method="GET"
                class="mb-4"
            >

                <div class="row g-3">

                    {{-- Filter Poli --}}

                    <div class="col-md-5">

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
                                    @selected(
                                        request('id_poli')
                                        == $poli->id_poli
                                    )
                                >
                                    {{ $poli->nama_poli }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Filter Hari --}}

                    <div class="col-md-5">

                        <label class="form-label">
                            Hari
                        </label>

                        <select
                            name="hari"
                            class="form-select"
                        >

                            <option value="">
                                Semua Hari
                            </option>

                            @foreach($hari as $itemHari)

                                <option
                                    value="{{ $itemHari }}"
                                    @selected(
                                        request('hari')
                                        == $itemHari
                                    )
                                >
                                    {{ $itemHari }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Tombol --}}

                    <div class="col-md-2 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >

                            <i class="fas fa-filter me-1"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>


            {{-- Tabel --}}

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Dokter</th>

                            <th>Poli</th>

                            <th>Hari</th>

                            <th>Jam Tugas</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse(
                            $jadwalDokters
                            as $jadwalDokter
                        )

                            <tr>

                                <td>
                                    {{
                                        $jadwalDokters->firstItem()
                                        + $loop->index
                                    }}
                                </td>


                                <td>

                                    <strong>
                                        {{
                                            $jadwalDokter
                                                ->dokter
                                                ->nama_dokter
                                        }}
                                    </strong>

                                    @if(
                                        $jadwalDokter
                                            ->dokter
                                            ->spesialisasi_dokter
                                    )

                                        <div class="text-muted small">

                                            {{
                                                $jadwalDokter
                                                    ->dokter
                                                    ->spesialisasi_dokter
                                            }}

                                        </div>

                                    @endif

                                </td>


                                <td>

                                    <span class="badge bg-info">

                                        {{
                                            $jadwalDokter
                                                ->poli
                                                ->nama_poli
                                        }}

                                    </span>

                                </td>


                                <td>

                                    <strong>
                                        {{ $jadwalDokter->hari }}
                                    </strong>

                                </td>


                                <td>

                                    <i
                                        class="far fa-clock me-1"
                                    ></i>

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

                                </td>
                                <td>

    <a
        href="{{ route(
            'pasien.jadwal.daftar',
            $jadwalDokter->id_jadwaldokter
        ) }}"
        class="btn btn-sm btn-primary"
    >

        <i class="fas fa-ticket-alt me-1"></i>

        Daftar Antrean

    </a>

</td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="fas fa-calendar-times
                                               fa-3x
                                               text-muted
                                               mb-3"
                                    ></i>

                                    <h5>
                                        Jadwal Tidak Ditemukan
                                    </h5>

                                    <p class="text-muted mb-0">
                                        Belum terdapat jadwal dokter.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}

            @if($jadwalDokters->hasPages())

                <div class="d-flex justify-content-end mt-3">

                    {{ $jadwalDokters->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection