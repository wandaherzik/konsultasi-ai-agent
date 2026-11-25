@extends('layouts.home.admin.app')

@section('page-title', 'Detail User')

@section('content')

<div class="page-inner">

    {{-- ================================================= --}}
    {{-- HEADER --}}
    {{-- ================================================= --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Detail User
            </h3>

            <p class="text-muted mb-0">
                Informasi lengkap mengenai pengguna sistem
            </p>

        </div>

        <div>

            <span class="badge bg-primary px-3 py-2">

                <i class="fas fa-user me-1"></i>

                User

            </span>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- INFORMASI USER --}}
    {{-- ================================================= --}}

    <div class="row">

        {{-- PROFILE CARD --}}
        <div class="col-md-4">

            <div class="card card-round">

                <div class="card-body text-center">

                    {{-- ICON PROFILE --}}

                    <div
                        class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="
                            width: 100px;
                            height: 100px;
                            font-size: 40px;
                        "
                    >

                        <i class="fas fa-user"></i>

                    </div>


                    {{-- NAMA --}}

                    <h4 class="fw-bold mb-1">

                        {{ $user->nama ?? '-' }}

                    </h4>


                    {{-- USERNAME --}}

                    <p class="text-muted mb-3">

                        {{ '@' . ($user->username ?? '-') }}

                    </p>


                    {{-- ROLE --}}

                    @php

                        $roleBadge = match ($user->role) {

                            'admin' => 'danger',

                            'dokter' => 'success',

                            'pasien' => 'info',

                            'kapus' => 'warning',

                            default => 'secondary',

                        };

                    @endphp


                    <span class="badge bg-{{ $roleBadge }} px-3 py-2">

                        <i class="fas fa-user-tag me-1"></i>

                        {{ ucfirst($user->role ?? '-') }}

                    </span>

                </div>

            </div>

        </div>


        {{-- DETAIL USER --}}
        <div class="col-md-8">

            <div class="card card-round">

                <div class="card-header">

                    <div class="card-head-row">

                        <div>

                            <h4 class="card-title mb-1">
                                Informasi User
                            </h4>

                            <p class="text-muted mb-0">
                                Data akun pengguna
                            </p>

                        </div>

                    </div>

                </div>


                <div class="card-body">

                    <div class="row">


                        {{-- ID USER --}}

                        <div class="col-md-6 mb-4">

                            <div class="d-flex">

                                <div
                                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                    style="
                                        width: 45px;
                                        height: 45px;
                                        min-width: 45px;
                                    "
                                >

                                    <i class="fas fa-id-card"></i>

                                </div>


                                <div>

                                    <small class="text-muted">
                                        ID User
                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        {{ $user->id_user }}

                                    </h6>

                                </div>

                            </div>

                        </div>


                        {{-- NAMA --}}

                        <div class="col-md-6 mb-4">

                            <div class="d-flex">

                                <div
                                    class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3"
                                    style="
                                        width: 45px;
                                        height: 45px;
                                        min-width: 45px;
                                    "
                                >

                                    <i class="fas fa-user"></i>

                                </div>


                                <div>

                                    <small class="text-muted">
                                        Nama Lengkap
                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        {{ $user->nama ?? '-' }}

                                    </h6>

                                </div>

                            </div>

                        </div>


                        {{-- USERNAME --}}

                        <div class="col-md-6 mb-4">

                            <div class="d-flex">

                                <div
                                    class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                    style="
                                        width: 45px;
                                        height: 45px;
                                        min-width: 45px;
                                    "
                                >

                                    <i class="fas fa-at"></i>

                                </div>


                                <div>

                                    <small class="text-muted">
                                        Username
                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        {{ $user->username ?? '-' }}

                                    </h6>

                                </div>

                            </div>

                        </div>


                        {{-- ROLE --}}

                        <div class="col-md-6 mb-4">

                            <div class="d-flex">

                                <div
                                    class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3"
                                    style="
                                        width: 45px;
                                        height: 45px;
                                        min-width: 45px;
                                    "
                                >

                                    <i class="fas fa-user-tag"></i>

                                </div>


                                <div>

                                    <small class="text-muted">
                                        Role
                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        {{ ucfirst($user->role ?? '-') }}

                                    </h6>

                                </div>

                            </div>

                        </div>


                        {{-- TANGGAL DIBUAT --}}

                        <div class="col-md-6 mb-4">

                            <div class="d-flex">

                                <div
                                    class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                                    style="
                                        width: 45px;
                                        height: 45px;
                                        min-width: 45px;
                                    "
                                >

                                    <i class="fas fa-calendar-plus"></i>

                                </div>


                                <div>

                                    <small class="text-muted">
                                        Terdaftar Sejak
                                    </small>

                                    <h6 class="fw-bold mb-0">

                                        {{ $user->created_at
                                            ? $user->created_at->format('d F Y')
                                            : '-'
                                        }}

                                    </h6>

                                </div>

                            </div>

                        </div>


                        {{-- STATUS --}}

                        <div class="col-md-6 mb-4">

                            <div class="d-flex">

                                <div
                                    class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                    style="
                                        width: 45px;
                                        height: 45px;
                                        min-width: 45px;
                                    "
                                >

                                    <i class="fas fa-check-circle"></i>

                                </div>


                                <div>

                                    <small class="text-muted">
                                        Status Akun
                                    </small>

                                    <h6 class="fw-bold mb-0 text-success">

                                        Aktif

                                    </h6>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- ACTION --}}
    {{-- ================================================= --}}

    <div class="card card-round mt-3">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="fw-bold mb-1">
                        Kelola User
                    </h6>

                    <p class="text-muted mb-0">
                        Ubah informasi atau kembali ke daftar pengguna.
                    </p>

                </div>


                <div class="d-flex gap-2">

                    {{-- KEMBALI --}}

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="btn btn-secondary"
                    >

                        <i class="fas fa-arrow-left me-1"></i>

                        Kembali

                    </a>


                    {{-- EDIT --}}

                    <a
                        href="{{ route(
                            'admin.users.edit',
                            $user->id_user
                        ) }}"
                        class="btn btn-warning"
                    >

                        <i class="fas fa-edit me-1"></i>

                        Edit User

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection