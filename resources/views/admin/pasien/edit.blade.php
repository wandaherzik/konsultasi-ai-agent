@extends('layouts.home.admin.app')

@section('page-title', 'Edit Pasien')

@section(
    'page-description',
    'Perbarui data pasien'
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

                Edit Data Pasien

            </h3>

            <p class="text-muted mb-0">

                Perbarui informasi pasien
                yang diperlukan.

            </p>

        </div>


        <a
            href="{{
                route(
                    'admin.pasien.show',
                    $pasien->id_pasien
                )
            }}"
            class="btn btn-secondary btn-round"
        >

            <i class="fas fa-arrow-left me-1"></i>

            Kembali

        </a>

    </div>


    {{-- VALIDATION ERROR --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <div class="fw-bold mb-2">

                <i class="fas fa-exclamation-circle me-1"></i>

                Terdapat kesalahan:

            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}

    <div class="card card-round">

        <div class="card-header">

            <h4 class="card-title mb-1">

                <i
                    class="fas fa-user-edit
                           text-primary me-2"
                ></i>

                Form Edit Pasien

            </h4>

            <p class="text-muted mb-0">

                ID Pasien:
                <strong>
                    {{ $pasien->id_pasien }}
                </strong>

            </p>

        </div>


        <form
            action="{{
                route(
                    'admin.pasien.update',
                    $pasien->id_pasien
                )
            }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="card-body">

                <div class="row">


                    {{-- ID PASIEN --}}

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">

                            ID Pasien

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $pasien->id_pasien }}"
                            readonly
                        >

                        <small class="text-muted">

                            ID pasien tidak dapat diubah.

                        </small>

                    </div>


                    {{-- NAMA --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="nama_pasien"
                            class="form-label fw-bold"
                        >

                            Nama Pasien
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            id="nama_pasien"
                            name="nama_pasien"
                            class="form-control @error('nama_pasien') is-invalid @enderror"
                            value="{{
                                old(
                                    'nama_pasien',
                                    $pasien->nama_pasien
                                )
                            }}"
                            placeholder="Masukkan nama pasien"
                            required
                        >

                        @error('nama_pasien')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>


                    {{-- NIK --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="nik"
                            class="form-label fw-bold"
                        >

                            NIK

                        </label>

                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            class="form-control @error('nik') is-invalid @enderror"
                            value="{{
                                old(
                                    'nik',
                                    $pasien->nik
                                )
                            }}"
                            placeholder="Masukkan NIK"
                        >

                        @error('nik')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>


                    {{-- TANGGAL LAHIR --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="tanggal_lahir"
                            class="form-label fw-bold"
                        >

                            Tanggal Lahir
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="date"
                            id="tanggal_lahir"
                            name="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{
                                old(
                                    'tanggal_lahir',
                                    $pasien->tanggal_lahir
                                )
                            }}"
                            required
                        >

                        @error('tanggal_lahir')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>


                    {{-- JENIS KELAMIN --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="jenis_kelamin"
                            class="form-label fw-bold"
                        >

                            Jenis Kelamin
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            id="jenis_kelamin"
                            name="jenis_kelamin"
                            class="form-select @error('jenis_kelamin') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            <option
                                value="L"
                                @selected(
                                    old(
                                        'jenis_kelamin',
                                        $pasien->jenis_kelamin
                                    ) === 'L'
                                )
                            >
                                Laki-laki
                            </option>

                            <option
                                value="P"
                                @selected(
                                    old(
                                        'jenis_kelamin',
                                        $pasien->jenis_kelamin
                                    ) === 'P'
                                )
                            >
                                Perempuan
                            </option>

                        </select>

                        @error('jenis_kelamin')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>


                    {{-- NO HP --}}

                    <div class="col-md-6 mb-3">

                        <label
                            for="no_hp"
                            class="form-label fw-bold"
                        >

                            Nomor HP

                        </label>

                        <input
                            type="text"
                            id="no_hp"
                            name="no_hp"
                            class="form-control @error('no_hp') is-invalid @enderror"
                            value="{{
                                old(
                                    'no_hp',
                                    $pasien->no_hp
                                )
                            }}"
                            placeholder="Contoh: 08123456789"
                        >

                        @error('no_hp')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>


                    {{-- ALAMAT --}}

                    <div class="col-md-12 mb-3">

                        <label
                            for="alamat"
                            class="form-label fw-bold"
                        >

                            Alamat
                            <span class="text-danger">*</span>

                        </label>

                        <textarea
                            id="alamat"
                            name="alamat"
                            rows="4"
                            class="form-control @error('alamat') is-invalid @enderror"
                            placeholder="Masukkan alamat pasien"
                            required
                        >{{ old(
                            'alamat',
                            $pasien->alamat
                        ) }}</textarea>

                        @error('alamat')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="card-footer">

                <div
                    class="
                        d-flex
                        justify-content-end
                        gap-2
                    "
                >

                    <a
                        href="{{
                            route(
                                'admin.pasien.show',
                                $pasien->id_pasien
                            )
                        }}"
                        class="btn btn-secondary"
                    >

                        <i
                            class="fas fa-times me-1"
                        ></i>

                        Batal

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i
                            class="fas fa-save me-1"
                        ></i>

                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection