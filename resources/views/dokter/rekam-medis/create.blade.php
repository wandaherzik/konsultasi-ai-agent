@extends('layouts.home.dokter.app')

@section('page-title', 'Rekam Medis')

@section(
    'page-description',
    'Pemeriksaan dan rekam medis pasien'
)

@section('content')

<div class="col-md-12">

    <div class="card card-round">

        <div class="card-header">

            <h4 class="card-title">
                Rekam Medis Pasien
            </h4>

        </div>

        <div class="card-body">

            {{-- INFORMASI PASIEN --}}

            <div class="alert alert-info">

                <strong>
                    Pasien:
                </strong>

                {{ $antrian->pasien->nama_pasien }}

                <br>

                <strong>
                    Nomor Antrean:
                </strong>

                {{ $antrian->no_antrian }}

            </div>


            {{-- KONSULTASI AI YANG DIPILIH --}}

            <div class="card border mb-4">

                <div class="card-header">

                    <h5 class="mb-0">
                        Konsultasi AI yang Dipilih
                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Keluhan Pasien
                        </label>

                        <div class="bg-light rounded p-3">

                            {{ $konsultasiAI->keluhan_pasien ?? '-' }}

                        </div>

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Diagnosa Awal AI
                        </label>

                        <div class="bg-light rounded p-3">

                            {{ $konsultasiAI->diagnosa_awal ?? '-' }}

                        </div>

                    </div>


                    <div>

                        <label class="form-label fw-bold">
                            Rekomendasi Poli
                        </label>

                        <div class="bg-light rounded p-3">

                            {{ $konsultasiAI->saran_poli ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- FORM REKAM MEDIS --}}

            <form
                action="{{ route(
                    'dokter.rekam-medis.store',
                    [
                        'id' => $antrian->id_antrian,
                        'idKonsultasi' =>
                            $konsultasiAI->id_konsultasi_ai,
                    ]
                ) }}"
                method="POST"
            >

                @csrf


                {{-- DIAGNOSA AKHIR --}}

                <div class="mb-3">

                    <label class="form-label">
                        Diagnosa Akhir
                    </label>

                    <input
                        type="text"
                        name="diagnosa_akhir"
                        class="form-control @error('diagnosa_akhir') is-invalid @enderror"
                        value="{{ old('diagnosa_akhir') }}"
                        placeholder="Masukkan diagnosa akhir"
                    >

                    @error('diagnosa_akhir')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- TINDAKAN --}}

                <div class="mb-3">

                    <label class="form-label">
                        Tindakan
                    </label>

                    <textarea
                        name="tindakan"
                        class="form-control @error('tindakan') is-invalid @enderror"
                        rows="5"
                        placeholder="Masukkan tindakan yang dilakukan"
                    >{{ old('tindakan') }}</textarea>

                    @error('tindakan')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- CATATAN --}}

                <div class="mb-3">

                    <label class="form-label">
                        Catatan
                    </label>

                    <textarea
                        name="catatan"
                        class="form-control"
                        rows="4"
                        placeholder="Catatan tambahan (opsional)"
                    >{{ old('catatan') }}</textarea>

                </div>


                <div class="d-flex justify-content-between">

                    <a
                        href="{{ route(
                            'dokter.rekam-medis.pilih-konsultasi',
                            $antrian->id_antrian
                        ) }}"
                        class="btn btn-secondary"
                    >
                        Kembali
                    </a>


                    <button
                        type="submit"
                        class="btn btn-success"
                    >

                        <i class="fas fa-save me-1"></i>

                        Simpan Rekam Medis

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection