<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PasienRekamMedisController extends Controller
{
    /**
     * Menampilkan riwayat rekam medis pasien.
     */
    public function index(): View
    {
        $pasien = Auth::user()->pasien;

        $rekamMedis = RekamMedis::with([
            'dokter',
            'antrian.poli',
        ])
        ->where(
            'id_pasien',
            $pasien->id_pasien
        )
        ->latest()
        ->paginate(10);

        return view(
            'pasien.rekam-medis.index',
            compact(
                'pasien',
                'rekamMedis'
            )
        );
    }


    /**
     * Menampilkan detail rekam medis.
     */
    public function show(
        string $id
    ): View {

        $pasien = Auth::user()->pasien;

        $rekamMedis = RekamMedis::with([
            'dokter',
            'antrian.poli',
        ])
        ->where(
            'id_rekammedis',
            $id
        )
        ->where(
            'id_pasien',
            $pasien->id_pasien
        )
        ->firstOrFail();

        return view(
            'pasien.rekam-medis.show',
            compact(
                'pasien',
                'rekamMedis'
            )
        );
    }
}