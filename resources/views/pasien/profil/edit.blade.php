@extends('layouts.home.pasien.app')

@section('page-title', 'Edit Profil')

@section(
    'page-description',
    'Perbarui informasi profil Anda'
)

@section('content')

<div class="row">

    <div class="col-md-8">

        <div class="card card-round">

            <div class="card-header">

                <h4 class="card-title mb-1">
                    Edit Profil
                </h4>

                <p class="text-muted mb-0">
                    Perbarui data pribadi Anda
                </p>

            </div>


            <form
                action="{{ route('pasien.profil.update') }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="card-body">

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <div class="mb-3">

                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="nama_pasien"
                            class="form-control"
                            value="{{ old(
                                'nama_pasien',
                                $pasien->nama_pasien
                            ) }}"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            NIK
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $pasien->nik ?? '-' }}"
                            readonly
                        >

                        <small class="text-muted">
                            NIK tidak dapat diubah.
                        </small>

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                class="form-control"
                                value="{{ old(
                                    'tanggal_lahir',
                                    $pasien->tanggal_lahir
                                ) }}"
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                class="form-select"
                            >

                                <option value="">
                                    Pilih Jenis Kelamin
                                </option>

                                <option
                                    value="Laki-laki"
                                    {{ old(
                                        'jenis_kelamin',
                                        $pasien->jenis_kelamin
                                    ) === 'Laki-laki'
                                        ? 'selected'
                                        : ''
                                    }}
                                >
                                    Laki-laki
                                </option>

                                <option
                                    value="Perempuan"
                                    {{ old(
                                        'jenis_kelamin',
                                        $pasien->jenis_kelamin
                                    ) === 'Perempuan'
                                        ? 'selected'
                                        : ''
                                    }}
                                >
                                    Perempuan
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Nomor HP
                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            class="form-control"
                            value="{{ old(
                                'no_hp',
                                $pasien->no_hp
                            ) }}"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Nomor BPJS
                        </label>

                        <input
                            type="text"
                            name="bpjs"
                            class="form-control"
                            value="{{ old(
                                'bpjs',
                                $pasien->bpjs
                            ) }}"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            class="form-control"
                            rows="4"
                        >{{ old(
                            'alamat',
                            $pasien->alamat
                        ) }}</textarea>

                    </div>

                </div>


                <div class="card-footer">

                    <a
                        href="{{ route('pasien.profil.index') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fas fa-save me-1"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection