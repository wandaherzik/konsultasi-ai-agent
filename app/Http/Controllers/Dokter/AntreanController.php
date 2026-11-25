<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AntreanController extends Controller
{
    /**
     * Menampilkan daftar antrean dokter.
     */
    public function index(): View
    {
        $dokter = Auth::user()->dokter;

        $hariIni = Carbon::today();

        $idPoli = $dokter->jadwalDokter()
            ->pluck('id_poli');

        $antrians = Antrian::with([
            'pasien',
            'poli',
            'konsultasiAI',
        ])
        ->whereIn('id_poli', $idPoli)
        ->whereDate(
            'tanggal_kunjungan',
            $hariIni
        )
        ->orderByDesc('skor_urgensi')
        ->orderBy('no_antrian')
        ->get();

        return view(
            'dokter.antrian.index',
            compact(
                'dokter',
                'antrians',
                'hariIni'
            )
        );
    }


    /**
     * Memanggil pasien.
     */
    public function panggil(
        string $id
    ): RedirectResponse {

        $dokter = Auth::user()->dokter;

        $idPoli = $dokter->jadwalDokter()
            ->pluck('id_poli');

        $antrian = Antrian::where(
            'id_antrian',
            $id
        )
        ->whereIn(
            'id_poli',
            $idPoli
        )
        ->where(
            'status_antrian',
            'menunggu'
        )
        ->firstOrFail();

        $antrian->update([
            'status_antrian' => 'dipanggil',
        ]);

        return redirect()
            ->route('dokter.antrian.index')
            ->with(
                'success',
                'Pasien nomor ' .
                $antrian->no_antrian .
                ' berhasil dipanggil.'
            );
    }


    /**
     * Menyelesaikan antrean pasien.
     */
    public function selesai(
        string $id
    ): RedirectResponse {

        $dokter = Auth::user()->dokter;

        $idPoli = $dokter->jadwalDokter()
            ->pluck('id_poli');

        $antrian = Antrian::where(
            'id_antrian',
            $id
        )
        ->whereIn(
            'id_poli',
            $idPoli
        )
        ->where(
            'status_antrian',
            'dipanggil'
        )
        ->firstOrFail();

        $antrian->update([
            'status_antrian' => 'selesai',
        ]);

        return redirect()
            ->route('dokter.antrian.index')
            ->with(
                'success',
                'Antrean pasien berhasil diselesaikan.'
            );
    }
}