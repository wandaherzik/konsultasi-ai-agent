<?php

namespace App\Http\Controllers\Kapus;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanKunjunganExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Poli;

class LaporanController extends Controller
{
    /**
     * Menampilkan laporan.
     */
    public function index(
    Request $request
): View {

    $query = RekamMedis::with([
        'pasien',
        'dokter',
        'antrian.poli',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Filter tanggal mulai
    |--------------------------------------------------------------------------
    */

    if ($request->filled('tanggal_mulai')) {

        $query->whereHas('antrian', function ($q) use ($request) {

            $q->whereDate(
                'tanggal_kunjungan',
                '>=',
                $request->tanggal_mulai
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Filter tanggal selesai
    |--------------------------------------------------------------------------
    */

    if ($request->filled('tanggal_selesai')) {

        $query->whereHas('antrian', function ($q) use ($request) {

            $q->whereDate(
                'tanggal_kunjungan',
                '<=',
                $request->tanggal_selesai
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Filter Poli
    |--------------------------------------------------------------------------
    */

    if ($request->filled('id_poli')) {

        $query->whereHas('antrian', function ($q) use ($request) {

            $q->where(
                'id_poli',
                $request->id_poli
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Data laporan
    |--------------------------------------------------------------------------
    */

    $laporans = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();


    /*
    |--------------------------------------------------------------------------
    | Data Poli
    |--------------------------------------------------------------------------
    */

    $polis = Poli::orderBy(
        'nama_poli'
    )->get();


    /*
    |--------------------------------------------------------------------------
    | Total kunjungan
    |--------------------------------------------------------------------------
    */

    $totalKunjungan = (clone $query)->count();


    /*
    |--------------------------------------------------------------------------
    | Rekap Poli
    |--------------------------------------------------------------------------
    */

    $rekapPoli = (clone $query)
        ->get()
        ->groupBy(function ($rekamMedis) {

            return $rekamMedis
                ->antrian
                ->poli
                ->nama_poli ?? 'Tidak diketahui';

        })
        ->map(function ($data) {

            return $data->count();

        });


    return view(
        'kapus.laporan.index',
        compact(
            'laporans',
            'polis',
            'rekapPoli',
            'totalKunjungan'
        )
    );
}


    /**
     * Export laporan ke PDF.
     */
  public function exportPdf(
    Request $request
) {

    $query = RekamMedis::with([
        'pasien',
        'dokter',
        'antrian.poli',
    ]);


    /*
    |--------------------------------------------------------------------------
    | Filter tanggal kunjungan
    |--------------------------------------------------------------------------
    */

    if ($request->filled('id_poli')) {

    $query->whereHas('antrian', function ($q) use ($request) {

        $q->where(
            'id_poli',
            $request->id_poli
        );

    });

}

    if ($request->filled('tanggal_mulai')) {

        $query->whereHas('antrian', function ($q) use ($request) {

            $q->whereDate(
                'tanggal_kunjungan',
                '>=',
                $request->tanggal_mulai
            );

        });

    }


    if ($request->filled('tanggal_selesai')) {

        $query->whereHas('antrian', function ($q) use ($request) {

            $q->whereDate(
                'tanggal_kunjungan',
                '<=',
                $request->tanggal_selesai
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Ambil data
    |--------------------------------------------------------------------------
    */

    $laporans = $query
        ->latest()
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Rekap poli
    |--------------------------------------------------------------------------
    */

    $rekapPoli = $laporans
        ->groupBy(function ($laporan) {

            return $laporan
                ->antrian
                ->poli
                ->nama_poli ?? 'Tidak diketahui';

        })
        ->map(function ($data) {

            return $data->count();

        });


    /*
    |--------------------------------------------------------------------------
    | Total kunjungan
    |--------------------------------------------------------------------------
    */

    $totalKunjungan = $laporans->count();


    $tanggalMulai =
        $request->tanggal_mulai;

    $tanggalSelesai =
        $request->tanggal_selesai;


    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    $pdf = Pdf::loadView(
        'kapus.laporan.pdf',
        compact(
            'laporans',
            'rekapPoli',
            'totalKunjungan',
            'tanggalMulai',
            'tanggalSelesai'
        )
    );


    $pdf->setPaper(
        'a4',
        'landscape'
    );


    return $pdf->download(
        'laporan-kunjungan-puskesmas.pdf'
    );
}

/**
 * Export laporan ke Excel.
 */
public function exportExcel(
    Request $request
) {

    return Excel::download(

        new LaporanKunjunganExport(
            $request->tanggal_mulai,
            $request->tanggal_selesai,
            $request->id_poli
        ),

        'laporan-kunjungan-puskesmas.xlsx'
    );
}
}