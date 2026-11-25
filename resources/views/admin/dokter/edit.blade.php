@extends('layouts.home.admin.app')

@section('content')

<div class="page-inner">

    <div class="d-flex align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Edit Dokter
            </h3>

            <p class="text-muted mb-0">
                Perbarui data dokter
            </p>
        </div>

    </div>

    <div class="card card-round">

        <div class="card-header">

            <div class="card-title">
                Form Edit Dokter
            </div>

        </div>

        <form action="{{ route('admin.dokter.update', $dokter->id_dokter) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- Akun --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Akun User
                    </label>

                    <select name="id_user"
                            class="form-select @error('id_user') is-invalid @enderror">

                        @foreach($users as $user)

                            <option value="{{ $user->id_user }}"
                                {{ old('id_user', $dokter->id_user) == $user->id_user ? 'selected' : '' }}>

                                {{ $user->nama }}
                                ({{ $user->username }})

                            </option>

                        @endforeach

                    </select>

                    @error('id_user')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Nama --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Nama Dokter
                    </label>

                    <input type="text"
                           name="nama_dokter"
                           value="{{ old('nama_dokter', $dokter->nama_dokter) }}"
                           class="form-control @error('nama_dokter') is-invalid @enderror">

                    @error('nama_dokter')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Spesialisasi --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Spesialisasi
                    </label>

                    <input type="text"
                           name="spesialisasi_dokter"
                           value="{{ old('spesialisasi_dokter', $dokter->spesialisasi_dokter) }}"
                           class="form-control @error('spesialisasi_dokter') is-invalid @enderror">

                    @error('spesialisasi_dokter')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <div class="card-footer">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('admin.dokter.index') }}"
                       class="btn btn-secondary">

                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save me-1"></i>
                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection