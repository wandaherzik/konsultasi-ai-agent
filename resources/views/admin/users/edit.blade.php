@extends('layouts.home.admin.app')

@section('page-title', 'Edit User')

@section('content')

<div class="page-inner">

    {{-- ================================================= --}}
    {{-- HEADER --}}
    {{-- ================================================= --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Edit User
            </h3>

            <p class="text-muted mb-0">
                Perbarui informasi akun pengguna
            </p>

        </div>

        <span class="badge bg-warning text-dark px-3 py-2">

            <i class="fas fa-user-edit me-1"></i>

            Edit User

        </span>

    </div>


    {{-- ================================================= --}}
    {{-- FORM EDIT --}}
    {{-- ================================================= --}}

    <div class="row">

        <div class="col-md-8">

            <div class="card card-round">

                <div class="card-header">

                    <div class="card-head-row">

                        <div>

                            <h4 class="card-title mb-1">
                                Informasi User
                            </h4>

                            <p class="text-muted mb-0">
                                Silakan ubah data pengguna di bawah ini.
                            </p>

                        </div>

                    </div>

                </div>


                <form
                    action="{{ route(
                        'admin.users.update',
                        $user->id_user
                    ) }}"
                    method="POST"
                >

                    @csrf

                    @method('PUT')


                    <div class="card-body">


                        {{-- ================================= --}}
                        {{-- ERROR VALIDASI --}}
                        {{-- ================================= --}}

                        @if ($errors->any())

                            <div class="alert alert-danger">

                                <div class="d-flex">

                                    <i class="fas fa-exclamation-circle me-2 mt-1"></i>

                                    <div>

                                        <strong>
                                            Terdapat kesalahan:
                                        </strong>

                                        <ul class="mb-0 mt-1">

                                            @foreach ($errors->all() as $error)

                                                <li>
                                                    {{ $error }}
                                                </li>

                                            @endforeach

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        @endif



                        {{-- ================================= --}}
                        {{-- ID USER --}}
                        {{-- ================================= --}}

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                ID User

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="fas fa-id-card"></i>

                                </span>

                                <input
                                    type="text"
                                    class="form-control bg-light"
                                    value="{{ $user->id_user }}"
                                    readonly
                                >

                            </div>

                            <small class="text-muted">

                                ID User tidak dapat diubah.

                            </small>

                        </div>



                        {{-- ================================= --}}
                        {{-- NAMA --}}
                        {{-- ================================= --}}

                        <div class="mb-4">

                            <label
                                for="nama"
                                class="form-label fw-bold"
                            >

                                Nama Lengkap

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="fas fa-user"></i>

                                </span>

                                <input
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $user->nama) }}"
                                    placeholder="Masukkan nama lengkap"
                                    maxlength="100"
                                    required
                                >

                            </div>

                            @error('nama')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- ================================= --}}
                        {{-- USERNAME --}}
                        {{-- ================================= --}}

                        <div class="mb-4">

                            <label
                                for="username"
                                class="form-label fw-bold"
                            >

                                Username

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="fas fa-at"></i>

                                </span>

                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old(
                                        'username',
                                        $user->username
                                    ) }}"
                                    placeholder="Masukkan username"
                                    maxlength="50"
                                    required
                                >

                            </div>

                            @error('username')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- ================================= --}}
                        {{-- ROLE --}}
                        {{-- ================================= --}}

                        <div class="mb-4">

                            <label
                                for="role"
                                class="form-label fw-bold"
                            >

                                Role

                                <span class="text-danger">
                                    *
                                </span>

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="fas fa-user-tag"></i>

                                </span>

                                <select
                                    id="role"
                                    name="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Role --
                                    </option>

                                    <option
                                        value="admin"
                                        {{ old(
                                            'role',
                                            $user->role
                                        ) === 'admin'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Admin
                                    </option>

                                    <option
                                        value="dokter"
                                        {{ old(
                                            'role',
                                            $user->role
                                        ) === 'dokter'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Dokter
                                    </option>

                                    <option
                                        value="pasien"
                                        {{ old(
                                            'role',
                                            $user->role
                                        ) === 'pasien'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Pasien
                                    </option>

                                    <option
                                        value="kapus"
                                        {{ old(
                                            'role',
                                            $user->role
                                        ) === 'kapus'
                                            ? 'selected'
                                            : ''
                                        }}
                                    >
                                        Kepala Puskesmas
                                    </option>

                                </select>

                            </div>

                            @error('role')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- ================================= --}}
                        {{-- PASSWORD --}}
                        {{-- ================================= --}}

                        <div class="mb-4">

                            <label
                                for="password"
                                class="form-label fw-bold"
                            >

                                Password Baru

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="fas fa-lock"></i>

                                </span>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Kosongkan jika tidak ingin mengubah password"
                                >

                            </div>

                            <small class="text-muted">

                                Kosongkan bagian ini jika password
                                tidak ingin diubah.

                            </small>

                            @error('password')

                                <div class="text-danger small mt-1">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>



                        {{-- ================================= --}}
                        {{-- KONFIRMASI PASSWORD --}}
                        {{-- ================================= --}}

                        <div class="mb-2">

                            <label
                                for="password_confirmation"
                                class="form-label fw-bold"
                            >

                                Konfirmasi Password Baru

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="fas fa-lock"></i>

                                </span>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password baru"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- ================================= --}}
                    {{-- FOOTER --}}
                    {{-- ================================= --}}

                    <div class="card-footer">

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route(
                                    'admin.users.show',
                                    $user->id_user
                                ) }}"
                                class="btn btn-secondary"
                            >

                                <i class="fas fa-times me-1"></i>

                                Batal

                            </a>


                            <button
                                type="submit"
                                class="btn btn-warning"
                            >

                                <i class="fas fa-save me-1"></i>

                                Simpan Perubahan

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- INFORMASI USER --}}
        {{-- ================================================= --}}

        <div class="col-md-4">

            <div class="card card-round">

                <div class="card-body text-center">

                    <div
                        class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center mx-auto mb-3"
                        style="
                            width: 90px;
                            height: 90px;
                            font-size: 35px;
                        "
                    >

                        <i class="fas fa-user-edit"></i>

                    </div>


                    <h5 class="fw-bold">

                        {{ $user->nama }}

                    </h5>


                    <p class="text-muted mb-3">

                        {{ '@' . $user->username }}

                    </p>


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

                        {{ ucfirst($user->role) }}

                    </span>

                </div>

            </div>



            {{-- PETUNJUK --}}

            <div class="card card-round">

                <div class="card-header">

                    <h5 class="card-title mb-0">

                        <i class="fas fa-info-circle text-primary me-1"></i>

                        Petunjuk

                    </h5>

                </div>


                <div class="card-body">

                    <ul class="text-muted ps-3 mb-0">

                        <li class="mb-2">
                            Nama dan username wajib diisi.
                        </li>

                        <li class="mb-2">
                            Role menentukan hak akses pengguna.
                        </li>

                        <li class="mb-2">
                            Password boleh dikosongkan.
                        </li>

                        <li>
                            Password baru minimal 8 karakter.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection