<?php

namespace App\Http\Controllers\Kapus;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(
        Request $request
    ): View {

        $hariIni = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Statistik utama
        |--------------------------------------------------------------------------
        */

        $totalPasien = Pasien::count();

        $totalDokter = Dokter::count();

        $totalPoli = Poli::count();

        $totalKunjungan = Antrian::count();


        /*
        |--------------------------------------------------------------------------
        | Statistik antrean hari ini
        |--------------------------------------------------------------------------
        */

        $antrianHariIni = Antrian::where(
            'tanggal_kunjungan',
            $hariIni->toDateString()
        );

        $menunggu = (clone $antrianHariIni)
            ->where(
                'status_antrian',
                'menunggu'
            )
            ->count();

        $dipanggil = (clone $antrianHariIni)
            ->where(
                'status_antrian',
                'dipanggil'
            )
            ->count();

        $selesai = (clone $antrianHariIni)
            ->where(
                'status_antrian',
                'selesai'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Periode grafik
        |--------------------------------------------------------------------------
        */

        $periode = $request->get(
            'periode',
            'hari'
        );

        $periodeValid = [
            'hari',
            'minggu',
            'bulan',
            'tahun',
        ];

        if (!in_array(
            $periode,
            $periodeValid
        )) {
            $periode = 'hari';
        }


        /*
        |--------------------------------------------------------------------------
        | Grafik kunjungan
        |--------------------------------------------------------------------------
        */

        $grafikKunjungan =
            $this->getGrafikKunjungan(
                $periode
            );


        /*
        |--------------------------------------------------------------------------
        | Total kunjungan berdasarkan poli
        |--------------------------------------------------------------------------
        */

        $grafikPoli = Antrian::query()

            ->join(
                'poli',
                'antrian.id_poli',
                '=',
                'poli.id_poli'
            )

            ->select(
                'poli.nama_poli',
                DB::raw(
                    'COUNT(antrian.id_antrian) as total'
                )
            )

            ->groupBy(
                'poli.id_poli',
                'poli.nama_poli'
            )

            ->orderByDesc('total')

            ->get();


       /*
|--------------------------------------------------------------------------
| Data untuk grafik Chart.js
|--------------------------------------------------------------------------
*/

$labelKunjungan = $grafikKunjungan['data']
    ->pluck('label')
    ->values();

$labelPoli = $grafikPoli
    ->pluck('nama_poli')
    ->values();

$dataPoli = $grafikPoli
    ->pluck('total')
    ->map(fn ($total) => (int) $total)
    ->values();


/*
|--------------------------------------------------------------------------
| Data kunjungan keseluruhan
|--------------------------------------------------------------------------
|
| Untuk grafik garis, kita jumlahkan seluruh poli
| pada setiap periode.
|
*/

$dataKunjungan = $grafikKunjungan['data']
    ->map(function ($row) use ($grafikKunjungan) {

        $total = 0;

        foreach ($grafikKunjungan['polis'] as $poli) {

            $key = 'poli_' . $poli->id_poli;

            $total += (int) ($row[$key] ?? 0);
        }

        return $total;
    })
    ->values();


return view(
    'kapus.dashboard',
    compact(
        'hariIni',
        'totalPasien',
        'totalDokter',
        'totalPoli',
        'totalKunjungan',
        'menunggu',
        'dipanggil',
        'selesai',
        'periode',
        'grafikKunjungan',
        'grafikPoli',
        'labelKunjungan',
        'dataKunjungan',
        'labelPoli',
        'dataPoli'
    )
);
    }


    /*
    |--------------------------------------------------------------------------
    | Data grafik kunjungan
    |--------------------------------------------------------------------------
    */

    private function getGrafikKunjungan(
        string $periode
    ) {

        $polis = Poli::orderBy(
            'nama_poli'
        )->get();

        $hasil = collect();


        /*
        |--------------------------------------------------------------------------
        | HARI
        |--------------------------------------------------------------------------
        */

        if ($periode === 'hari') {

            $tanggalMulai = Carbon::today()
                ->subDays(6);

            $tanggalSelesai = Carbon::today();

            $data = Antrian::query()

                ->join(
                    'poli',
                    'antrian.id_poli',
                    '=',
                    'poli.id_poli'
                )

                ->whereBetween(
                    'antrian.tanggal_kunjungan',
                    [
                        $tanggalMulai->toDateString(),
                        $tanggalSelesai->toDateString(),
                    ]
                )

                ->select(
                    'antrian.tanggal_kunjungan',
                    'antrian.id_poli',
                    DB::raw(
                        'COUNT(antrian.id_antrian) as total'
                    )
                )

                ->groupBy(
                    'antrian.tanggal_kunjungan',
                    'antrian.id_poli'
                )

                ->get();


            for (
                $tanggal = $tanggalMulai->copy();
                $tanggal->lte($tanggalSelesai);
                $tanggal->addDay()
            ) {

                $row = [
                    'label' =>
                        $tanggal->translatedFormat(
                            'd M'
                        ),
                ];


                foreach ($polis as $poli) {

                    $item = $data->first(
                        function ($item) use (
                            $tanggal,
                            $poli
                        ) {

                            return
                                $item->tanggal_kunjungan
                                === $tanggal->toDateString()
                                &&
                                $item->id_poli
                                === $poli->id_poli;
                        }
                    );


                    $row[
                        'poli_' . $poli->id_poli
                    ] = $item
                        ? (int) $item->total
                        : 0;
                }


                $hasil->push($row);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | MINGGU
        |--------------------------------------------------------------------------
        */

        elseif ($periode === 'minggu') {

            $tanggalMulai = Carbon::today()
                ->subWeeks(7)
                ->startOfWeek();

            $tanggalSelesai = Carbon::today()
                ->endOfWeek();


            $data = Antrian::query()

                ->select(
                    'id_poli',
                    DB::raw(
                        'YEARWEEK(
                            tanggal_kunjungan,
                            1
                        ) as minggu'
                    ),
                    DB::raw(
                        'COUNT(id_antrian) as total'
                    )
                )

                ->whereBetween(
                    'tanggal_kunjungan',
                    [
                        $tanggalMulai->toDateString(),
                        $tanggalSelesai->toDateString(),
                    ]
                )

                ->groupBy(
                    'id_poli',
                    DB::raw(
                        'YEARWEEK(
                            tanggal_kunjungan,
                            1
                        )'
                    )
                )

                ->get();


            for (
                $tanggal = $tanggalMulai->copy();
                $tanggal->lte($tanggalSelesai);
                $tanggal->addWeek()
            ) {

                $minggu = $tanggal->format('oW');

                $row = [
                    'label' =>
                        'Minggu ' .
                        $tanggal->weekOfYear,
                ];


                foreach ($polis as $poli) {

                    $item = $data->first(
                        function ($item) use (
                            $minggu,
                            $poli
                        ) {

                            return
                                $item->minggu == $minggu
                                &&
                                $item->id_poli
                                === $poli->id_poli;
                        }
                    );


                    $row[
                        'poli_' . $poli->id_poli
                    ] = $item
                        ? (int) $item->total
                        : 0;
                }


                $hasil->push($row);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | BULAN
        |--------------------------------------------------------------------------
        */

        elseif ($periode === 'bulan') {

            $tanggalMulai = Carbon::today()
                ->subMonths(11)
                ->startOfMonth();

            $tanggalSelesai = Carbon::today()
                ->endOfMonth();


            $data = Antrian::query()

                ->select(
                    'id_poli',
                    DB::raw(
                        "DATE_FORMAT(
                            tanggal_kunjungan,
                            '%Y-%m'
                        ) as bulan"
                    ),
                    DB::raw(
                        'COUNT(id_antrian) as total'
                    )
                )

                ->whereBetween(
                    'tanggal_kunjungan',
                    [
                        $tanggalMulai->toDateString(),
                        $tanggalSelesai->toDateString(),
                    ]
                )

                ->groupBy(
                    'id_poli',
                    DB::raw(
                        "DATE_FORMAT(
                            tanggal_kunjungan,
                            '%Y-%m'
                        )"
                    )
                )

                ->get();


            for (
                $tanggal = $tanggalMulai->copy();
                $tanggal->lte($tanggalSelesai);
                $tanggal->addMonth()
            ) {

                $bulan = $tanggal->format('Y-m');

                $row = [
                    'label' =>
                        $tanggal->translatedFormat(
                            'M Y'
                        ),
                ];


                foreach ($polis as $poli) {

                    $item = $data->first(
                        function ($item) use (
                            $bulan,
                            $poli
                        ) {

                            return
                                $item->bulan === $bulan
                                &&
                                $item->id_poli
                                === $poli->id_poli;
                        }
                    );


                    $row[
                        'poli_' . $poli->id_poli
                    ] = $item
                        ? (int) $item->total
                        : 0;
                }


                $hasil->push($row);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TAHUN
        |--------------------------------------------------------------------------
        */

        elseif ($periode === 'tahun') {

            $tahunSekarang =
                Carbon::today()->year;

            $tahunMulai =
                $tahunSekarang - 4;


            $data = Antrian::query()

                ->select(
                    'id_poli',
                    DB::raw(
                        'YEAR(tanggal_kunjungan) as tahun'
                    ),
                    DB::raw(
                        'COUNT(id_antrian) as total'
                    )
                )

                ->whereBetween(
                    DB::raw(
                        'YEAR(tanggal_kunjungan)'
                    ),
                    [
                        $tahunMulai,
                        $tahunSekarang,
                    ]
                )

                ->groupBy(
                    'id_poli',
                    DB::raw(
                        'YEAR(tanggal_kunjungan)'
                    )
                )

                ->get();


            for (
                $tahun = $tahunMulai;
                $tahun <= $tahunSekarang;
                $tahun++
            ) {

                $row = [
                    'label' => (string) $tahun,
                ];


                foreach ($polis as $poli) {

                    $item = $data->first(
                        function ($item) use (
                            $tahun,
                            $poli
                        ) {

                            return
                                (int) $item->tahun
                                === $tahun
                                &&
                                $item->id_poli
                                === $poli->id_poli;
                        }
                    );


                    $row[
                        'poli_' . $poli->id_poli
                    ] = $item
                        ? (int) $item->total
                        : 0;
                }


                $hasil->push($row);
            }
        }


        return [
            'polis' => $polis,
            'data' => $hasil,
        ];
    }
}