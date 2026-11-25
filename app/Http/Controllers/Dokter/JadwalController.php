<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $dokter = $user->dokter;

        if (!$dokter) {
            abort(404, 'Data dokter tidak ditemukan.');
        }

        $jadwals = JadwalDokter::with([
            'poli'
        ])
        ->where(
            'id_dokter',
            $dokter->id_dokter
        )
        ->orderByRaw("
            FIELD(
                hari,
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            )
        ")
        ->get();

        return view(
            'dokter.jadwal.index',
            compact(
                'dokter',
                'jadwals'
            )
        );
    }
}