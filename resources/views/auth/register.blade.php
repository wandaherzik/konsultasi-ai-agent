@extends('layouts.home.login.app')

@section('page-title', 'Pendaftaran Pasien')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-title">
                    Pendaftaran Pasien
                </div>

            </div>

            <div class="card-body">

                <p class="text-muted mb-4">
                    Silakan lengkapi data berikut untuk membuat akun
                    dan mendaftarkan diri sebagai pasien.
                </p>

                @if($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Terdapat kesalahan:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form
                    action="{{ route('register.store') }}"
                    method="POST"
                >

                    @csrf

                    {{-- ========================= --}}
                    {{-- DATA PASIEN --}}
                    {{-- ========================= --}}

                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-user me-2"></i>
                        Data Pasien
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="nama_pasien"
                                class="form-control"
                                value="{{ old('nama_pasien') }}"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                NIK
                            </label>

                            <input
                                type="text"
                                name="nik"
                                class="form-control"
                                value="{{ old('nik') }}"
                                maxlength="16"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih --
                                </option>

                                <option
                                    value="Laki-laki"
                                    {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}
                                >
                                    Laki-laki
                                </option>

                                <option
                                    value="Perempuan"
                                    {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}
                                >
                                    Perempuan
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                class="form-control"
                                value="{{ old('tanggal_lahir') }}"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nomor BPJS
                                <small class="text-muted">
                                    (Opsional)
                                </small>
                            </label>

                            <input
                                type="text"
                                name="no_bpjs"
                                class="form-control"
                                value="{{ old('no_bpjs') }}"
                                maxlength="25"
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nomor Telepon
                            </label>

                            <input
                                type="text"
                                name="no_telepon"
                                class="form-control"
                                value="{{ old('no_telepon') }}"
                                maxlength="15"
                                required
                            >

                        </div>

                        <div class="col-md-12 mb-4">

                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="3"
                                required
                            >{{ old('alamat') }}</textarea>

                        </div>

                    </div>


                    {{-- ========================= --}}
                    {{-- DATA AKUN --}}
                    {{-- ========================= --}}

                    <h5 class="fw-bold mb-3">

                        <i class="fas fa-lock me-2"></i>

                        Data Akun

                    </h5>

                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                value="{{ old('username') }}"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="form-label">
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>


                    <div class="d-flex justify-content-between align-items-center">

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-light"
                        >
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali ke Login
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary btn-round"
                        >
                            <i class="fas fa-user-plus me-1"></i>
                            Daftar Akun
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection