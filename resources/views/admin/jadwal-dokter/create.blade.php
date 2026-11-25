@extends('layouts.home.admin.app')

@section('content')

<div class="container">
    <div class="page-inner">

        {{-- Header --}}
        <div class="d-flex align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    Tambah Jadwal Dokter
                </h3>

                <p class="text-muted mb-0">
                    Tambahkan jadwal praktik dokter.
                </p>
            </div>

        </div>

        {{-- Validation Error --}}
        @if($errors->any())

            <div class="alert alert-danger">

                <strong>Terjadi kesalahan:</strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <div class="card card-round">

            <div class="card-header">

                <div class="card-title">
                    Form Jadwal Dokter
                </div>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.jadwal-dokter.store') }}"
                      method="POST">

                    @csrf

                    <div class="row">

                        {{-- Dokter --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">
                                Dokter
                                <span class="text-danger">*</span>
                            </label>

                            <select name="id_dokter"
                                    class="form-select @error('id_dokter') is-invalid @enderror"
                                    required>

                                <option value="">
                                    -- Pilih Dokter --
                                </option>

                                @foreach($dokters as $dokter)

                                    <option value="{{ $dokter->id_dokter }}"
                                        {{ old('id_dokter') == $dokter->id_dokter ? 'selected' : '' }}>

                                        {{ $dokter->nama_dokter }}
                                        -
                                        {{ $dokter->spesialisasi_dokter }}

                                    </option>

                                @endforeach

                            </select>

                            @error('id_dokter')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Poli --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">
                                Poli
                                <span class="text-danger">*</span>
                            </label>

                            <select name="id_poli"
                                    class="form-select @error('id_poli') is-invalid @enderror"
                                    required>

                                <option value="">
                                    -- Pilih Poli --
                                </option>

                                @foreach($polis as $poli)

                                    <option value="{{ $poli->id_poli }}"
                                        {{ old('id_poli') == $poli->id_poli ? 'selected' : '' }}>

                                        {{ $poli->nama_poli }}

                                    </option>

                                @endforeach

                            </select>

                            @error('id_poli')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Hari --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Hari Praktik
                                <span class="text-danger">*</span>
                            </label>

                            <select name="hari"
                                    class="form-select @error('hari') is-invalid @enderror"
                                    required>

                                <option value="">
                                    -- Pilih Hari --
                                </option>

                                @foreach([
                                    'Senin',
                                    'Selasa',
                                    'Rabu',
                                    'Kamis',
                                    'Jumat',
                                    'Sabtu'
                                ] as $hari)

                                    <option value="{{ $hari }}"
                                        {{ old('hari') == $hari ? 'selected' : '' }}>

                                        {{ $hari }}

                                    </option>

                                @endforeach

                            </select>

                            @error('hari')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Jam Buka --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Jam Buka
                                <span class="text-danger">*</span>
                            </label>

                            <input type="time"
                                   name="jam_buka"
                                   value="{{ old('jam_buka') }}"
                                   class="form-control @error('jam_buka') is-invalid @enderror"
                                   required>

                            @error('jam_buka')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Jam Tutup --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Jam Tutup
                                <span class="text-danger">*</span>
                            </label>

                            <input type="time"
                                   name="jam_tutup"
                                   value="{{ old('jam_tutup') }}"
                                   class="form-control @error('jam_tutup') is-invalid @enderror"
                                   required>

                            @error('jam_tutup')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <a href="{{ route('admin.jadwal-dokter.index') }}"
                           class="btn btn-secondary">

                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali

                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fas fa-save me-1"></i>
                            Simpan Jadwal

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection