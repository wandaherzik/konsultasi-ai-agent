@extends('layouts.home.dokter.app')

@section('page-title', 'Jadwal Tugas')

@section('page-description', 'Jadwal pelayanan dan poli tempat Anda bertugas')

@section('content')

<div class="page-inner">

    {{-- ========================================== --}}
    {{-- HEADER --}}
    {{-- ========================================== --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Jadwal Tugas Dokter
            </h3>

            <p class="text-muted mb-0">
                Jadwal pelayanan dan poli tempat Anda bertugas
            </p>

        </div>

        <div>

            <span class="badge bg-primary px-3 py-2">

                <i class="fas fa-calendar-alt me-1"></i>

                Jadwal Saya

            </span>

        </div>

    </div>


    {{-- ========================================== --}}
    {{-- PROFIL DOKTER --}}
    {{-- ========================================== --}}

    <div class="card card-round mb-4">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                    style="
                        width: 70px;
                        height: 70px;
                        font-size: 28px;
                    "
                >

                    <i class="fas fa-user-md"></i>

                </div>


                <div>

                    <h4 class="fw-bold mb-1">

                        {{ $dokter->nama_dokter }}

                    </h4>

                    <p class="text-muted mb-1">

                        ID Dokter:
                        <strong>
                            {{ $dokter->id_dokter }}
                        </strong>

                    </p>

                    <span class="badge bg-success">

                        <i class="fas fa-circle me-1"
                           style="font-size: 7px;"></i>

                        Dokter Aktif

                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================== --}}
    {{-- DAFTAR JADWAL --}}
    {{-- ========================================== --}}

    <div class="card card-round">

        <div class="card-header">

            <div class="card-head-row">

                <div>

                    <h4 class="card-title mb-1">
                        Jadwal Pelayanan
                    </h4>

                    <p class="text-muted mb-0">
                        Daftar jadwal dan poli tempat Anda bertugas
                    </p>

                </div>

                <div>

                    <span class="badge bg-info">

                        {{ $jadwals->count() }} Jadwal

                    </span>

                </div>

            </div>

        </div>


        <div class="card-body">

            @if($jadwals->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th width="60">
                                    No
                                </th>

                                <th>
                                    Hari
                                </th>

                                <th>
                                    Jam Pelayanan
                                </th>

                                <th>
                                    Poli
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($jadwals as $jadwal)

                                <tr>

                                    {{-- NOMOR --}}

                                    <td>

                                        {{ $loop->iteration }}

                                    </td>


                                    {{-- HARI --}}

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                style="
                                                    width: 40px;
                                                    height: 40px;
                                                "
                                            >

                                                <i class="fas fa-calendar"></i>

                                            </div>

                                            <strong>

                                                {{ $jadwal->hari }}

                                            </strong>

                                        </div>

                                    </td>


                                    {{-- JAM --}}

                                    <td>

                                        <span class="badge bg-light text-dark">

                                            <i class="fas fa-clock text-primary me-1"></i>

                                            {{ \Carbon\Carbon::parse(
                                                $jadwal->jam_buka
                                            )->format('H:i') }}

                                            -

                                            {{ \Carbon\Carbon::parse(
                                                $jadwal->jam_tutup
                                            )->format('H:i') }}

                                        </span>

                                    </td>


                                    {{-- POLI --}}

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2"
                                                style="
                                                    width: 40px;
                                                    height: 40px;
                                                "
                                            >

                                                <i class="fas fa-hospital"></i>

                                            </div>

                                            <div>

                                                <strong>

                                                    {{ $jadwal->poli->nama_poli ?? '-' }}

                                                </strong>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- STATUS --}}

                                    <td>

                                        <span class="badge bg-success">

                                            <i class="fas fa-check-circle me-1"></i>

                                            Aktif

                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- ================================= --}}
                {{-- JIKA TIDAK ADA JADWAL --}}
                {{-- ================================= --}}

                <div class="text-center py-5">

                    <div
                        class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="
                            width: 90px;
                            height: 90px;
                            font-size: 35px;
                        "
                    >

                        <i class="fas fa-calendar-times text-muted"></i>

                    </div>


                    <h5 class="fw-bold">
                        Belum Ada Jadwal
                    </h5>

                    <p class="text-muted mb-0">

                        Saat ini belum terdapat jadwal pelayanan
                        yang ditentukan untuk Anda.

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection