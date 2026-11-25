@extends('layouts.home.pasien.app')

@section('page-title', 'Profil Pasien')

@section(
    'page-description',
    'Informasi profil dan data pribadi Anda'
)

@section('content')

<div class="row">

    <div class="col-md-8">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-head-row">

                    <div>

                        <h4 class="card-title">
                            Profil Saya
                        </h4>

                        <p class="text-muted mb-0">
                            Informasi data pribadi pasien
                        </p>

                    </div>

                    <div class="card-tools">

                        <a
                            href="{{ route('pasien.profil.edit') }}"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-edit me-1"></i>
                            Edit Profil
                        </a>

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


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Nama Lengkap
                        </label>

                        <div class="fw-bold">
                            {{ $pasien->nama_pasien ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Username
                        </label>

                        <div class="fw-bold">
                            {{ $user->username }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            NIK
                        </label>

                        <div class="fw-bold">
                            {{ $pasien->nik ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Nomor HP
                        </label>

                        <div class="fw-bold">
                            {{ $pasien->no_hp ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Tanggal Lahir
                        </label>

                        <div class="fw-bold">
                            {{ $pasien->tanggal_lahir ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Jenis Kelamin
                        </label>

                        <div class="fw-bold">
                            {{ $pasien->jenis_kelamin ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Nomor BPJS
                        </label>

                        <div class="fw-bold">
                            {{ $pasien->bpjs ?? '-' }}
                        </div>

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="text-muted">
                            Alamat
                        </label>

                        <div class="fw-bold">
                            {{ $pasien->alamat ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection