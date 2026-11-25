@extends('layouts.home.kapus.app')

@section('page-title', 'Dashboard Kepala Puskesmas')

@section(
    'page-description',
    'Monitoring pelayanan Puskesmas'
)

@section('content')

<div class="row">

    {{-- Total Pasien --}}
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-icon">

                        <div class="icon-big text-center icon-primary bubble-shadow-small">

                            <i class="fas fa-users"></i>

                        </div>

                    </div>

                    <div class="col col-stats ms-3">

                        <div class="numbers">

                            <p class="card-category">
                                Total Pasien
                            </p>

                            <h4 class="card-title">
                                {{ $totalPasien }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>


    {{-- Total Dokter --}}
    <div class="col-sm-6 col-md-3">

        <div class="card card-stats card-round">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-icon">

                        <div class="icon-big text-center icon-info bubble-shadow-small">

                            <i class="fas fa-user-md"></i>

                        </div>

                    </div>

                    <div class="col col-stats ms-3">

                        <div class="numbers">

                            <p class="card-category">
                                Total Dokter
                            </p>

                            <h4 class="card-title">
                                {{ $totalDokter }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Total Poli --}}
    <div class="col-sm-6 col-md-3">

        <div class="card card-stats card-round">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-icon">

                        <div class="icon-big text-center icon-success bubble-shadow-small">

                            <i class="fas fa-hospital"></i>

                        </div>

                    </div>

                    <div class="col col-stats ms-3">

                        <div class="numbers">

                            <p class="card-category">
                                Total Poli
                            </p>

                            <h4 class="card-title">
                                {{ $totalPoli }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Kunjungan Hari Ini --}}
    <div class="col-sm-6 col-md-3">

        <div class="card card-stats card-round">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-icon">

                        <div class="icon-big text-center icon-warning bubble-shadow-small">

                            <i class="fas fa-calendar-check"></i>

                        </div>

                    </div>

                    <div class="col col-stats ms-3">

                        <div class="numbers">

                            <p class="card-category">
                                Kunjungan Hari Ini
                            </p>

                            <h4 class="card-title">
                                {{ $totalKunjungan }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Antrean Hari Ini --}}

<div class="row">

    <div class="col-md-12">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-head-row">

                    <div class="card-title">

                        Antrean Hari Ini

                    </div>

                    <div class="card-tools">

                        {{ $hariIni->translatedFormat('l, d F Y') }}

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- Menunggu --}}
                    <div class="col-md-4">

                        <div class="card card-round border">

                            <div class="card-body text-center">

                                <i class="fas fa-clock fa-2x text-warning mb-3"></i>

                                <h6 class="text-muted">
                                    Menunggu
                                </h6>

                                <h2>
                                    {{ $menunggu }}
                                </h2>

                            </div>

                        </div>

                    </div>


                    {{-- Dipanggil --}}
                    <div class="col-md-4">

                        <div class="card card-round border">

                            <div class="card-body text-center">

                                <i class="fas fa-bullhorn fa-2x text-primary mb-3"></i>

                                <h6 class="text-muted">
                                    Sedang Dipanggil
                                </h6>

                                <h2>
                                    {{ $dipanggil }}
                                </h2>

                            </div>

                        </div>

                    </div>


                    {{-- Selesai --}}
                    <div class="col-md-4">

                        <div class="card card-round border">

                            <div class="card-body text-center">

                                <i class="fas fa-check-circle fa-2x text-success mb-3"></i>

                                <h6 class="text-muted">
                                    Selesai
                                </h6>

                                <h2>
                                    {{ $selesai }}
                                </h2>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Statistik Kunjungan Berdasarkan Poli --}}

<div class="row">

    <div class="col-md-12">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-head-row">

                    <div>

                        <h4 class="card-title mb-1">
                            Kunjungan Berdasarkan Poli
                        </h4>

                        <p class="text-muted mb-0">
                            Statistik kunjungan pasien hari ini
                        </p>

                    </div>

                </div>

            </div>
                @if($grafikPoli->count() > 0)

    <div class="table-responsive">

        <table class="table table-hover">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Poli</th>
                    <th>Total Kunjungan</th>
                </tr>
            </thead>

            <tbody>

                @foreach($grafikPoli as $statistik)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <strong>
                                {{ $statistik->nama_poli }}
                            </strong>
                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $statistik->total }}

                                pasien

                            </span>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

                @else

                    <div class="text-center py-4">

                        <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>

                        <h5>
                            Belum Ada Kunjungan
                        </h5>

                        <p class="text-muted mb-0">
                            Belum terdapat kunjungan pasien.
                        </p>

                    </div>

                @endif


        </div>


    </div>

</div>

</div>
{{-- ================================================= --}}
{{-- GRAFIK KUNJUNGAN --}}
{{-- ================================================= --}}

<div class="row">

    {{-- Grafik konsultasi pasien --}}

    <div class="col-md-7">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-head-row">

                    <div>

                        <h4 class="card-title mb-1">
                            Grafik Kunjungan Konsultasi
                        </h4>

                        <p class="text-muted mb-0">
                            Jumlah kunjungan pasien berdasarkan tanggal
                        </p>

                    </div>

                    <div>

                        <span class="badge bg-primary">
                            Rekam Medis
                        </span>

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div
                    style="
                        position: relative;
                        height: 300px;
                    "
                >

                    <canvas id="kunjunganKonsultasiChart"></canvas>

                </div>

            </div>

        </div>

    </div>


    {{-- Grafik per poli --}}

    <div class="col-md-5">

        <div class="card card-round">

            <div class="card-header">

                <div class="card-head-row">

                    <div>

                        <h4 class="card-title mb-1">
                            Kunjungan per Poli
                        </h4>

                        <p class="text-muted mb-0">
                            Total pasien berdasarkan poli
                        </p>

                    </div>

                </div>

            </div>


            <div class="card-body">

                <div
                    style="
                        position: relative;
                        height: 300px;
                    "
                >

                    <canvas id="kunjunganPoliChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>
    

</div>

</div>

</div>

@endsection

@push('js')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATA GRAFIK DARI LARAVEL
    |--------------------------------------------------------------------------
    */

    const grafikKunjungan =
        @json($grafikKunjungan ?? []);


    /*
    |--------------------------------------------------------------------------
    | GRAFIK KUNJUNGAN PER POLI
    |--------------------------------------------------------------------------
    */

    const canvasKunjungan =
        document.getElementById(
            'kunjunganKonsultasiChart'
        );


    if (
        canvasKunjungan &&
        grafikKunjungan.data &&
        grafikKunjungan.polis
    ) {

        const labels =
            grafikKunjungan.data.map(
                item => item.label
            );


        const datasets =
            grafikKunjungan.polis.map(
                (poli, index) => {

                    const key =
                        'poli_' + poli.id_poli;


                    return {

                        label:
                            poli.nama_poli,

                        data:
                            grafikKunjungan.data.map(
                                item =>
                                    Number(
                                        item[key] ?? 0
                                    )
                            ),

                        borderWidth: 2,

                        tension: 0.4,

                        fill: false,

                        pointRadius: 3,

                        pointHoverRadius: 5
                    };

                }
            );


        new Chart(
            canvasKunjungan,
            {

                type: 'line',

                data: {

                    labels: labels,

                    datasets: datasets

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    interaction: {

                        mode: 'index',

                        intersect: false

                    },

                    plugins: {

                        legend: {

                            display: true,

                            position: 'bottom'

                        }

                    },

                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0

                            }

                        }

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | GRAFIK TOTAL KUNJUNGAN PER POLI
    |--------------------------------------------------------------------------
    */

    const canvasPoli =
        document.getElementById(
            'kunjunganPoliChart'
        );


    if (canvasPoli) {

        const labelPoli =
            @json($labelPoli ?? []);

        const dataPoli =
            @json($dataPoli ?? []);


        new Chart(
            canvasPoli,
            {

                type: 'bar',

                data: {

                    labels: labelPoli,

                    datasets: [

                        {

                            label:
                                'Total Kunjungan',

                            data:
                                dataPoli,

                            borderWidth: 1

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            display: false

                        }

                    },

                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0

                            }

                        }

                    }

                }

            }
        );

    }

});

</script>

@endpush