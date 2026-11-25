@extends('layouts.home.dokter.app')

@section('page-title', 'Riwayat Rekam Medis')

@section(
    'page-description',
    'Riwayat rekam medis pasien yang pernah Anda tangani'
)

@section('content')

<div class="page-inner">

    {{-- ========================================= --}}
    {{-- HEADER --}}
    {{-- ========================================= --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Riwayat Rekam Medis
            </h3>

            <p class="text-muted mb-0">
                Pasien yang pernah Anda tangani
            </p>

        </div>

        <div>

            <span class="badge bg-primary px-3 py-2">

                <i class="fas fa-file-medical me-1"></i>

                {{ $rekamMedis->total() }} Rekam Medis

            </span>

        </div>

    </div>


    {{-- ========================================= --}}
    {{-- INFORMASI DOKTER --}}
    {{-- ========================================= --}}

    <div class="card card-round mb-4">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 60px;
                        height: 60px;
                        font-size: 25px;
                    "
                >

                    <i class="fas fa-user-md"></i>

                </div>

                <div>

                    <h5 class="fw-bold mb-1">

                        {{ $dokter->nama_dokter }}

                    </h5>

                    <p class="text-muted mb-0">

                        ID Dokter:
                        {{ $dokter->id_dokter }}

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================= --}}
    {{-- TABEL --}}
    {{-- ========================================= --}}

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div>

                    <h4 class="card-title mb-1">
                        Riwayat Pasien
                    </h4>

                    <p class="text-muted mb-0">
                        Daftar riwayat pemeriksaan pasien
                    </p>

                </div>

            </div>

        </div>


        <div class="card-body">

        {{-- ========================================= --}}
{{-- SEARCH --}}
{{-- ========================================= --}}

<div class="mb-4">

    <form
        action="{{ route('dokter.rekam-medis.index') }}"
        method="GET"
    >

        <div class="row align-items-end">

            <div class="col-md-8">

                <label class="form-label fw-bold">
                    Cari Pasien
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari berdasarkan nama pasien..."
                        value="{{ request('search') }}"
                    >

                </div>

            </div>


            <div class="col-md-4 mt-3 mt-md-0">

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="fas fa-search me-1"></i>

                        Cari

                    </button>


                    @if(request('search'))

                        <a
                            href="{{ route('dokter.rekam-medis.index') }}"
                            class="btn btn-secondary"
                        >

                            <i class="fas fa-times me-1"></i>

                            Reset

                        </a>

                    @endif

                </div>

            </div>

        </div>

    </form>

</div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>
                                No
                            </th>

                            <th>
                                Pasien
                            </th>

                            <th>
                                Poli
                            </th>

                            <th>
                                Diagnosa
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($rekamMedis as $rekam)

                            <tr>

                                {{-- NO --}}

                                <td>

                                    {{ $rekamMedis
                                        ->firstItem() + $loop->index }}

                                </td>


                                {{-- PASIEN --}}

                                <td>

                                    <div class="d-flex align-items-center">

                                        <div
                                            class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2"
                                            style="
                                                width: 42px;
                                                height: 42px;
                                            "
                                        >

                                            <i class="fas fa-user"></i>

                                        </div>

                                        <div>

                                            <strong>

                                                {{ $rekam->pasien->nama_pasien
                                                    ?? $rekam->nama_pasien }}

                                            </strong>

                                            <br>

                                            <small class="text-muted">

                                                {{ $rekam->id_pasien }}

                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- POLI --}}

                                <td>

                                    <span class="badge bg-info">

                                        <i class="fas fa-clinic-medical me-1"></i>

                                        {{ $rekam->antrian->poli->nama_poli
                                            ?? '-' }}

                                    </span>

                                </td>


                                {{-- DIAGNOSA --}}

                                <td>

                                    <span
                                        class="text-truncate d-inline-block"
                                        style="max-width: 200px;"
                                    >

                                        {{ $rekam->diagnosa_akhir ?: '-' }}

                                    </span>

                                </td>


                                {{-- TANGGAL --}}

                                <td>

                                    <i class="far fa-calendar-alt text-primary me-1"></i>

                                    {{ $rekam->created_at
                                        ? $rekam->created_at->format('d/m/Y')
                                        : '-' }}

                                </td>


                                {{-- AKSI --}}

                                <td>

                                    <a
                                        href="{{ route(
                                            'dokter.rekam-medis.show',
                                            $rekam->id_rekammedis
                                        ) }}"
                                        class="btn btn-sm btn-primary"
                                    >

                                        <i class="fas fa-eye me-1"></i>

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center py-5"
                                >

                                    <div
                                        class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="
                                            width: 80px;
                                            height: 80px;
                                            font-size: 30px;
                                        "
                                    >

                                        <i class="fas fa-file-medical text-muted"></i>

                                    </div>

                                    <h5 class="fw-bold">
                                        Belum Ada Rekam Medis
                                    </h5>

                                    <p class="text-muted mb-0">

                                        Belum terdapat pasien yang
                                        memiliki rekam medis bersama Anda.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ================================= --}}
            {{-- PAGINATION --}}
            {{-- ================================= --}}

            @if($rekamMedis->hasPages())

                <div class="d-flex justify-content-end mt-3">

                    {{ $rekamMedis->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection