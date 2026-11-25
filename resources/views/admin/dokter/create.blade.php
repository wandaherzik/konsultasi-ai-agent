@extends('layouts.home.admin.app')

@section('content')

<div class="page-inner">

    <div class="d-flex align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Tambah Dokter</h3>
            <p class="text-muted mb-0">
                Tambahkan data dokter baru
            </p>
        </div>
    </div>

    <div class="card card-round">

        <div class="card-header">
            <div class="card-title">
                Form Data Dokter
            </div>
        </div>

        <form action="{{ route('admin.dokter.store') }}"
              method="POST">

            @csrf

            <div class="card-body">

                {{-- Akun User --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Akun User
                    </label>

                    <select name="id_user"
                            class="form-select @error('id_user') is-invalid @enderror">

                        <option value="">
                            -- Pilih Akun Dokter --
                        </option>

                        @foreach($users as $user)

                            <option value="{{ $user->id_user }}"
                                {{ old('id_user') == $user->id_user ? 'selected' : '' }}>

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

                    <small class="text-muted">
                        Pilih akun yang memiliki role dokter.
                    </small>

                </div>

                {{-- Nama Dokter --}}
                <div class="mb-3">

                    <label class="form-label fw-bold">
                        Nama Dokter
                    </label>

                    <input type="text"
                           name="nama_dokter"
                           value="{{ old('nama_dokter') }}"
                           class="form-control @error('nama_dokter') is-invalid @enderror"
                           placeholder="Contoh: dr. Wanda">

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
                           value="{{ old('spesialisasi_dokter') }}"
                           class="form-control @error('spesialisasi_dokter') is-invalid @enderror"
                           placeholder="Contoh: Dokter Umum">

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
                        Simpan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection