@extends('layouts.home.admin.app')

@section('title', 'Edit Poli')

@section('content')

<div class="page-inner">

    {{-- Header --}}

    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">

        <div>

            <h3 class="fw-bold mb-2">
                Edit Poli
            </h3>

            <h6 class="op-7 mb-2">
                Perbarui informasi poli
            </h6>

        </div>


        <div class="ms-md-auto py-2 py-md-0">

            <a href="{{ route('admin.poli.index') }}"
               class="btn btn-secondary btn-round">

                <i class="fas fa-arrow-left me-1"></i>

                Kembali

            </a>

        </div>

    </div>


    {{-- Validation Error --}}

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


    {{-- Form --}}

    <div class="card card-round">

        <div class="card-header">

            <h4 class="card-title">
                Form Edit Poli
            </h4>

        </div>


        <div class="card-body">

            <form action="{{ route('admin.poli.update', $poli->id_poli) }}"
                  method="POST">

                @csrf

                @method('PUT')


                {{-- ID Poli --}}

                <div class="form-group mb-3">

                    <label for="id_poli">

                        ID Poli

                    </label>

                    <input type="text"
                           id="id_poli"
                           class="form-control"
                           value="{{ $poli->id_poli }}"
                           readonly>

                    <small class="form-text text-muted">

                        ID Poli tidak dapat diubah.

                    </small>

                </div>


                {{-- Nama Poli --}}

                <div class="form-group mb-3">

                    <label for="nama_poli">

                        Nama Poli
                        <span class="text-danger">*</span>

                    </label>

                    <input type="text"
                           id="nama_poli"
                           name="nama_poli"
                           class="form-control @error('nama_poli') is-invalid @enderror"
                           value="{{ old('nama_poli', $poli->nama_poli) }}"
                           required>

                    @error('nama_poli')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Deskripsi --}}

                <div class="form-group mb-3">

                    <label for="deskripsi">

                        Deskripsi
                        <span class="text-danger">*</span>

                    </label>

                    <textarea id="deskripsi"
                              name="deskripsi"
                              rows="4"
                              class="form-control @error('deskripsi') is-invalid @enderror"
                              required>{{ old('deskripsi', $poli->deskripsi) }}</textarea>

                    @error('deskripsi')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Kapasitas --}}

                <div class="form-group mb-4">

                    <label for="kapasitas_harian">

                        Kapasitas Harian
                        <span class="text-danger">*</span>

                    </label>

                    <input type="number"
                           id="kapasitas_harian"
                           name="kapasitas_harian"
                           min="1"
                           class="form-control @error('kapasitas_harian') is-invalid @enderror"
                           value="{{ old('kapasitas_harian', $poli->kapasitas_harian) }}"
                           required>

                    <small class="form-text text-muted">

                        Jumlah maksimal pasien yang dapat dilayani
                        dalam satu hari.

                    </small>

                    @error('kapasitas_harian')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Button --}}

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('admin.poli.index') }}"
                       class="btn btn-secondary">

                        Batal

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save me-1"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection