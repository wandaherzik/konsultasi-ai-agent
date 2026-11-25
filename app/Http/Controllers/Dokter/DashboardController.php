<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $dokter = Auth::user()->dokter;

        $hariIni = Carbon::today();

        // Ambil ID poli yang menjadi jadwal dokter
        $idPoli = $dokter->jadwalDokter()
            ->pluck('id_poli');

        // Ambil antrian hari ini berdasarkan poli dokter
        $antrianHariIni = Antrian::whereIn(
            'id_poli',
            $idPoli
        )
        ->where(
            'tanggal_kunjungan',
            $hariIni->toDateString()
        );

        $totalAntrian = (clone $antrianHariIni)
            ->count();

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

        return view(
            'dokter.dashboard',
            compact(
                'dokter',
                'hariIni',
                'totalAntrian',
                'menunggu',
                'dipanggil',
                'selesai'
            )
        );
    }
}