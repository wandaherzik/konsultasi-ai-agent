@extends('layouts.home.pasien.app')

@section('page-title', 'Daftar Antrean')

@section(
    'page-description',
    'Pendaftaran antrean pemeriksaan pasien'
)

@section('content')

<div class="page-inner">

    {{-- HEADER --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Daftar Antrean
            </h3>

            <p class="text-muted mb-0">
                Pilih konsultasi AI dan jadwal dokter yang sesuai.
            </p>

        </div>

        <a
            href="{{ route('pasien.antrian.index') }}"
            class="btn btn-secondary"
        >

            <i class="fas fa-arrow-left me-1"></i>

            Kembali

        </a>

    </div>


    {{-- ERROR --}}

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('pasien.antrian.store') }}"
        method="POST"
    >

        @csrf


        {{-- ========================================================= --}}
        {{-- KONSULTASI AI --}}
        {{-- ========================================================= --}}

        <div class="card card-round mb-4">

            <div class="card-header">

                <h4 class="card-title">

                    <i class="fas fa-robot text-primary me-2"></i>

                    Hasil Konsultasi AI

                </h4>

            </div>


            <div class="card-body">


                <div class="alert alert-info">

                    <i class="fas fa-info-circle me-2"></i>

                    Pilih hasil konsultasi AI yang ingin digunakan
                    sebagai dasar kunjungan. Konsultasi yang ditampilkan
                    hanya konsultasi yang sudah selesai.

                </div>


                {{-- TANPA KONSULTASI AI --}}

                <div class="form-check mb-3">

                    <input
                        class="form-check-input"
                        type="radio"
                        name="id_konsultasi_ai"
                        id="tanpa_konsultasi"
                        value=""
                        checked
                    >

                    <label
                        class="form-check-label"
                        for="tanpa_konsultasi"
                    >

                        <strong>
                            Tidak menggunakan konsultasi AI
                        </strong>

                        <br>

                        <small class="text-muted">

                            Saya ingin memilih poli dan dokter
                            secara langsung.

                        </small>

                    </label>

                </div>


                @forelse ($konsultasisAI as $konsultasi)

                    <div class="card border mb-3">

                        <div class="card-body">

                            <div class="form-check">

                                <input
                                    class="form-check-input konsultasi-radio"
                                    type="radio"
                                    name="id_konsultasi_ai"
                                    id="konsultasi_{{ $konsultasi->id_konsultasi_ai }}"
                                    value="{{ $konsultasi->id_konsultasi_ai }}"
                                    data-poli="{{ strtolower(trim($konsultasi->saran_poli)) }}"
                                >

                                <label
                                    class="form-check-label w-100"
                                    for="konsultasi_{{ $konsultasi->id_konsultasi_ai }}"
                                >

                                    <div class="d-flex justify-content-between">

                                        <strong>

                                            {{ $konsultasi->saran_poli }}

                                        </strong>

                                        <small class="text-muted">

                                            {{ $konsultasi->updated_at
                                                ? $konsultasi->updated_at->format(
                                                    'd/m/Y H:i'
                                                )
                                                : '-' }}

                                        </small>

                                    </div>


                                    <div class="mt-2">

                                        <small class="text-muted">
                                            Keluhan:
                                        </small>

                                        <div>

                                            {{ $konsultasi->keluhan_pasien }}

                                        </div>

                                    </div>


                                    <div class="mt-2">

                                        <small class="text-muted">
                                            Analisis awal:
                                        </small>

                                        <div>

                                            {{ $konsultasi->diagnosa_awal ?? '-' }}

                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-4">

                        <i
                            class="fas fa-robot fa-2x text-muted mb-3"
                        ></i>

                        <p class="text-muted mb-0">

                            Belum terdapat konsultasi AI yang
                            sudah selesai.

                        </p>

                        <small class="text-muted">

                            Anda tetap dapat mendaftar antrean
                            tanpa menggunakan konsultasi AI.

                        </small>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- JADWAL DOKTER --}}
        {{-- ========================================================= --}}

        <div class="card card-round mb-4">

            <div class="card-header">

                <h4 class="card-title">

                    <i class="fas fa-user-md text-success me-2"></i>

                    Pilih Dokter

                </h4>

            </div>


            <div class="card-body">


                <div class="mb-3">

                    <label
                        for="id_jadwaldokter"
                        class="form-label fw-bold"
                    >

                        Jadwal Dokter

                    </label>


                    <select
                        name="id_jadwaldokter"
                        id="id_jadwaldokter"
                        class="form-select @error('id_jadwaldokter') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Pilih Dokter --
                        </option>


                        @foreach ($jadwalDokters as $jadwal)

                            <option
                                value="{{ $jadwal->id_jadwaldokter }}"
                                data-poli="{{ strtolower(trim($jadwal->poli->nama_poli)) }}"
                                data-hari="{{ strtolower($jadwal->hari) }}"
                                {{ old('id_jadwaldokter') == $jadwal->id_jadwaldokter ? 'selected' : '' }}
                            >

                                {{ $jadwal->dokter->nama_dokter }}

                                -
                                {{ $jadwal->poli->nama_poli }}

                                -
                                {{ $jadwal->hari }}

                                {{ $jadwal->jam_mulai
                                    ? '(' . $jadwal->jam_mulai . ' - ' . $jadwal->jam_selesai . ')'
                                    : '' }}

                            </option>

                        @endforeach

                    </select>


                    @error('id_jadwaldokter')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <div
                    id="infoPoli"
                    class="alert alert-primary d-none"
                >

                    <i class="fas fa-info-circle me-2"></i>

                    <span id="infoPoliText"></span>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- TANGGAL KUNJUNGAN --}}
        {{-- ========================================================= --}}

        <div class="card card-round mb-4">

            <div class="card-header">

                <h4 class="card-title">

                    <i class="fas fa-calendar-alt text-warning me-2"></i>

                    Tanggal Kunjungan

                </h4>

            </div>


            <div class="card-body">

                <div class="mb-3">

                    <label
                        for="tanggal_kunjungan"
                        class="form-label fw-bold"
                    >

                        Tanggal Kunjungan

                    </label>


                    <input
                        type="date"
                        name="tanggal_kunjungan"
                        id="tanggal_kunjungan"
                        class="form-control @error('tanggal_kunjungan') is-invalid @enderror"
                        value="{{ old('tanggal_kunjungan') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        required
                    >


                    @error('tanggal_kunjungan')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <div
                    id="infoTanggal"
                    class="alert alert-warning d-none"
                >

                    <i class="fas fa-calendar-day me-2"></i>

                    <span id="infoTanggalText"></span>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- TOMBOL --}}
        {{-- ========================================================= --}}

        <div class="d-flex justify-content-between">

            <a
                href="{{ route('pasien.antrian.index') }}"
                class="btn btn-secondary"
            >

                <i class="fas fa-arrow-left me-1"></i>

                Batal

            </a>


            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="fas fa-ticket-alt me-1"></i>

                Daftar Antrean

            </button>

        </div>

    </form>

</div>


{{-- ================================================================ --}}
{{-- JAVASCRIPT --}}
{{-- ================================================================ --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const konsultasiRadios =
            document.querySelectorAll(
                '.konsultasi-radio'
            );

        const dokterSelect =
            document.getElementById(
                'id_jadwaldokter'
            );

        const infoPoli =
            document.getElementById(
                'infoPoli'
            );

        const infoPoliText =
            document.getElementById(
                'infoPoliText'
            );


        /*
        |--------------------------------------------------------------------------
        | Simpan seluruh option dokter
        |--------------------------------------------------------------------------
        */

        const semuaDokter = [];

        Array.from(
            dokterSelect.options
        ).forEach(function (option) {

            if (option.value) {

                semuaDokter.push({

                    value:
                        option.value,

                    text:
                        option.text,

                    poli:
                        option.dataset.poli

                });

            }

        });


        /*
        |--------------------------------------------------------------------------
        | Filter dokter berdasarkan poli AI
        |--------------------------------------------------------------------------
        */

        function filterDokter(
            namaPoli
        ) {

            dokterSelect.innerHTML = '';

            const defaultOption =
                document.createElement('option');

            defaultOption.value = '';

            defaultOption.textContent =
                '-- Pilih Dokter --';

            dokterSelect.appendChild(
                defaultOption
            );


            semuaDokter.forEach(
                function (dokter) {

                    if (
                        !namaPoli ||
                        dokter.poli === namaPoli
                    ) {

                        const option =
                            document.createElement(
                                'option'
                            );

                        option.value =
                            dokter.value;

                        option.textContent =
                            dokter.text;

                        option.dataset.poli =
                            dokter.poli;

                        dokterSelect.appendChild(
                            option
                        );

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Ketika konsultasi dipilih
        |--------------------------------------------------------------------------
        */

        konsultasiRadios.forEach(
            function (radio) {

                radio.addEventListener(
                    'change',
                    function () {

                        const poli =
                            this.dataset.poli;

                        filterDokter(
                            poli
                        );


                        if (poli) {

                            infoPoli.classList
                                .remove('d-none');

                            infoPoliText.textContent =
                                'Dokter yang ditampilkan berasal dari '
                                + 'poli rekomendasi: '
                                + this.closest(
                                    '.form-check'
                                ).querySelector(
                                    'label strong'
                                ).textContent.trim();

                        }

                    }
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Jika "Tidak menggunakan konsultasi AI"
        |--------------------------------------------------------------------------
        */

        const tanpaKonsultasi =
            document.getElementById(
                'tanpa_konsultasi'
            );


        tanpaKonsultasi.addEventListener(
            'change',
            function () {

                if (this.checked) {

                    filterDokter(null);

                    infoPoli.classList
                        .add('d-none');

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Validasi tampilan tanggal berdasarkan hari jadwal
        |--------------------------------------------------------------------------
        */

        const tanggalInput =
            document.getElementById(
                'tanggal_kunjungan'
            );

        const infoTanggal =
            document.getElementById(
                'infoTanggal'
            );

        const infoTanggalText =
            document.getElementById(
                'infoTanggalText'
            );


        function cekTanggal() {

            const selectedOption =
                dokterSelect.options[
                    dokterSelect.selectedIndex
                ];


            if (
                !tanggalInput.value ||
                !selectedOption ||
                !selectedOption.value
            ) {

                infoTanggal.classList
                    .add('d-none');

                return;

            }


            const tanggal =
                new Date(
                    tanggalInput.value
                    + 'T00:00:00'
                );


            const hari =
                tanggal.toLocaleDateString(
                    'id-ID',
                    {
                        weekday: 'long'
                    }
                ).toLowerCase();


            const hariJadwal =
                selectedOption.dataset.hari
                ?.toLowerCase();


            if (
                hariJadwal &&
                hari !== hariJadwal
            ) {

                infoTanggal.classList
                    .remove('d-none');

                infoTanggalText.textContent =
                    'Tanggal yang dipilih tidak sesuai '
                    + 'dengan hari praktik dokter. '
                    + 'Jadwal dokter tersedia pada hari '
                    + selectedOption.dataset.hari
                    + '.';

            } else {

                infoTanggal.classList
                    .add('d-none');

            }

        }


        dokterSelect.addEventListener(
            'change',
            cekTanggal
        );


        tanggalInput.addEventListener(
            'change',
            cekTanggal
        );

    }
);

</script>

@endsection