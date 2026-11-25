@extends('layouts.home.admin.app')

@section('page-title', 'Detail Pasien')

@section(
    'page-description',
    'Informasi lengkap data pasien'
)

@section('content')

<div class="page-inner">

    {{-- HEADER --}}

    <div class="d-flex
                align-items-center
                justify-content-between
                mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Detail Pasien

            </h3>

            <p class="text-muted mb-0">

                Informasi lengkap pasien
                yang terdaftar dalam sistem.

            </p>

        </div>

    </div>


    <div class="row">

        {{-- ============================================== --}}
        {{-- INFORMASI PASIEN --}}
        {{-- ============================================== --}}

        <div class="col-md-8">

            <div class="card card-round">

                <div class="card-header">

                    <div class="card-head-row">

                        <div>

                            <h4 class="card-title mb-1">

                                <i
                                    class="fas fa-user-injured
                                           text-primary me-2"
                                ></i>

                                Informasi Pasien

                            </h4>

                            <p class="text-muted mb-0">

                                Data identitas pasien

                            </p>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <div class="row">


                        {{-- ID PASIEN --}}

                        <div class="col-md-6 mb-4">

                            <label class="text-muted mb-1">

                                ID Pasien

                            </label>

                            <h5 class="fw-bold">

                                {{ $pasien->id_pasien }}

                            </h5>

                        </div>


                        {{-- NAMA --}}

                        <div class="col-md-6 mb-4">

                            <label class="text-muted mb-1">

                                Nama Pasien

                            </label>

                            <h5 class="fw-bold">

                                {{ $pasien->nama_pasien }}

                            </h5>

                        </div>


                        {{-- NIK --}}

                        <div class="col-md-6 mb-4">

                            <label class="text-muted mb-1">

                                NIK

                            </label>

                            <h5>

                                {{ $pasien->nik ?? '-' }}

                            </h5>

                        </div>


                        {{-- TANGGAL LAHIR --}}

                        <div class="col-md-6 mb-4">

                            <label class="text-muted mb-1">

                                Tanggal Lahir

                            </label>

                            <h5>

                                @if($pasien->tanggal_lahir)

                                    {{
                                        \Carbon\Carbon::parse(
                                            $pasien->tanggal_lahir
                                        )->translatedFormat(
                                            'd F Y'
                                        )
                                    }}

                                @else

                                    -

                                @endif

                            </h5>

                        </div>


                        {{-- JENIS KELAMIN --}}

                        <div class="col-md-6 mb-4">

                            <label class="text-muted mb-1">

                                Jenis Kelamin

                            </label>

                            <div>

                                @if(
                                    $pasien->jenis_kelamin === 'L'
                                )

                                    <span
                                        class="badge bg-info px-3 py-2"
                                    >

                                        <i
                                            class="fas fa-mars me-1"
                                        ></i>

                                        Laki-laki

                                    </span>

                                @elseif(
                                    $pasien->jenis_kelamin === 'P'
                                )

                                    <span
                                        class="badge bg-danger px-3 py-2"
                                    >

                                        <i
                                            class="fas fa-venus me-1"
                                        ></i>

                                        Perempuan

                                    </span>

                                @else

                                    <span
                                        class="badge bg-secondary"
                                    >

                                        -

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- NO HP --}}

                        <div class="col-md-6 mb-4">

                            <label class="text-muted mb-1">

                                Nomor HP

                            </label>

                            <h5>

                                {{ $pasien->no_hp ?? '-' }}

                            </h5>

                        </div>


                        {{-- ALAMAT --}}

                        <div class="col-md-12 mb-2">

                            <label class="text-muted mb-1">

                                Alamat

                            </label>

                            <div
                                class="p-3 rounded"
                                style="
                                    background: #f8f9fa;
                                "
                            >

                                <i
                                    class="fas fa-map-marker-alt
                                           text-danger me-2"
                                ></i>

                                {{ $pasien->alamat ?? '-' }}

                            </div>

                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}

                <div class="card-footer">

                    <div
                        class="d-flex
                               justify-content-end
                               gap-2"
                    >

                        <a
                            href="{{
                                route(
                                    'admin.pasien.index'
                                )
                            }}"
                            class="btn btn-secondary"
                        >

                            <i
                                class="fas fa-arrow-left me-1"
                            ></i>

                            Kembali

                        </a>


                        <a
                            href="{{
                                route(
                                    'admin.pasien.edit',
                                    $pasien->id_pasien
                                )
                            }}"
                            class="btn btn-warning"
                        >

                            <i
                                class="fas fa-edit me-1"
                            ></i>

                            Edit Data

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================== --}}
        {{-- PROFIL --}}
        {{-- ============================================== --}}

        <div class="col-md-4">

            <div class="card card-round">

                <div class="card-body text-center">

                    <div
                        class="
                            rounded-circle
                            bg-primary
                            text-white
                            d-flex
                            align-items-center
                            justify-content-center
                            mx-auto
                            mb-3
                        "
                        style="
                            width: 90px;
                            height: 90px;
                            font-size: 35px;
                        "
                    >

                        <i class="fas fa-user"></i>

                    </div>


                    <h4 class="fw-bold mb-1">

                        {{ $pasien->nama_pasien }}

                    </h4>


                    <p class="text-muted mb-3">

                        Pasien

                    </p>


                    <span
                        class="badge bg-primary px-3 py-2"
                    >

                        {{ $pasien->id_pasien }}

                    </span>

                </div>

            </div>


            {{-- INFO AKUN --}}

            <div class="card card-round">

                <div class="card-header">

                    <h5 class="card-title mb-0">

                        <i
                            class="fas fa-info-circle
                                   text-primary me-2"
                        ></i>

                        Informasi

                    </h5>

                </div>

                <div class="card-body">

                    <div
                        class="
                            d-flex
                            justify-content-between
                            mb-3
                        "
                    >

                        <span class="text-muted">
                            Terdaftar
                        </span>

                        <strong>

                            {{
                                $pasien->created_at
                                    ? $pasien->created_at
                                        ->format('d/m/Y')
                                    : '-'
                            }}

                        </strong>

                    </div>


                    <div
                        class="
                            d-flex
                            justify-content-between
                        "
                    >

                        <span class="text-muted">
                            Diperbarui
                        </span>

                        <strong>

                            {{
                                $pasien->updated_at
                                    ? $pasien->updated_at
                                        ->format('d/m/Y')
                                    : '-'
                            }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection