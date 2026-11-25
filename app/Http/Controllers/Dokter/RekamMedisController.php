<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\RekamMedis;
use App\Models\KonsultasiAI;
use App\Services\RekamMedisIdGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar rekam medis dokter.
     */
    public function index(Request $request): View
    {
        $dokter = Auth::user()->dokter;

        if (!$dokter) {
            abort(404, 'Data dokter tidak ditemukan.');
        }

        $query = RekamMedis::with([
            'pasien',
            'dokter',
            'antrian.poli',
            'konsultasiAI',
        ])
        ->where(
            'id_dokter',
            $dokter->id_dokter
        );

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas(
                'pasien',
                function ($q) use ($search) {

                    $q->where(
                        'nama_pasien',
                        'like',
                        '%' . $search . '%'
                    );

                }
            );
        }

        $rekamMedis = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'dokter.rekam-medis.index',
            compact(
                'dokter',
                'rekamMedis'
            )
        );
    }


    /**
     * Detail rekam medis.
     */
   /**
 * Detail rekam medis.
 */
public function show(string $id): View
{
    $dokter = Auth::user()->dokter;

    if (!$dokter) {
        abort(404, 'Data dokter tidak ditemukan.');
    }

    $rekamMedis = RekamMedis::with([
        'pasien',
        'dokter',
        'antrian.poli',
        'konsultasiAI',
    ])
    ->where(
        'id_dokter',
        $dokter->id_dokter
    )
    ->where(
        'id_rekammedis',
        $id
    )
    ->firstOrFail();

    return view(
        'dokter.rekam-medis.show',
        compact(
            'dokter',
            'rekamMedis'
        )
    );
}


   /**
 * Memilih riwayat konsultasi AI
 * berdasarkan antrean pasien.
 */
public function pilihKonsultasi(
    Request $request,
    string $id
): View {

    $dokter = Auth::user()->dokter;

    if (!$dokter) {
        abort(404, 'Data dokter tidak ditemukan.');
    }


    /*
    |--------------------------------------------------------------------------
    | Ambil antrean pasien
    |--------------------------------------------------------------------------
    */

    $antrian = Antrian::with([
        'pasien',
        'poli',
    ])
    ->where(
        'id_antrian',
        $id
    )
    ->where(
        'status_antrian',
        'dipanggil'
    )
    ->firstOrFail();


    /*
    |--------------------------------------------------------------------------
    | Pastikan poli sesuai dokter
    |--------------------------------------------------------------------------
    */

    $idPoli = $dokter->jadwalDokter()
        ->pluck('id_poli');

    if (
        !$idPoli->contains(
            $antrian->id_poli
        )
    ) {
        abort(403);
    }


    /*
    |--------------------------------------------------------------------------
    | Pastikan belum memiliki rekam medis
    |--------------------------------------------------------------------------
    */

    $rekamMedis = RekamMedis::where(
        'id_antrian',
        $antrian->id_antrian
    )->first();

    if ($rekamMedis) {

        return redirect()
            ->route(
                'dokter.rekam-medis.show',
                $rekamMedis->id_rekammedis
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Query riwayat konsultasi
    |--------------------------------------------------------------------------
    */

    $query = KonsultasiAI::where(
        'id_pasien',
        $antrian->id_pasien
    )
    ->where(
        'status_konsultasi',
        'selesai'
    );


    /*
    |--------------------------------------------------------------------------
    | Filter berdasarkan keluhan
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(
            'keluhan_pasien',
            'like',
            '%' . $search . '%'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Filter berdasarkan poli
    |--------------------------------------------------------------------------
    */

    if ($request->filled('poli')) {

        $query->where(
            'saran_poli',
            $request->poli
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Filter berdasarkan tanggal
    |--------------------------------------------------------------------------
    */

    if ($request->filled('tanggal')) {

        $query->whereDate(
            'updated_at',
            $request->tanggal
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Ambil data konsultasi
    |--------------------------------------------------------------------------
    */

    $riwayatKonsultasi = $query
        ->latest('updated_at')
        ->paginate(5)
        ->withQueryString();


    /*
    |--------------------------------------------------------------------------
    | Ambil daftar poli dari riwayat konsultasi
    |--------------------------------------------------------------------------
    */

    $daftarPoli = KonsultasiAI::where(
        'id_pasien',
        $antrian->id_pasien
    )
    ->where(
        'status_konsultasi',
        'selesai'
    )
    ->whereNotNull(
        'saran_poli'
    )
    ->where(
        'saran_poli',
        '!=',
        ''
    )
    ->select('saran_poli')
    ->distinct()
    ->orderBy('saran_poli')
    ->pluck('saran_poli');


    return view(
        'dokter.rekam-medis.pilih-konsultasi',
        compact(
            'dokter',
            'antrian',
            'riwayatKonsultasi',
            'daftarPoli'
        )
    );
}

/** Menampilkan form rekam medis
 * berdasarkan konsultasi AI yang dipilih.
 */
public function create(
    string $id,
    string $idKonsultasi
): View {

    $dokter = Auth::user()->dokter;

    if (!$dokter) {
        abort(404, 'Data dokter tidak ditemukan.');
    }


    /*
    |--------------------------------------------------------------------------
    | Ambil antrean
    |--------------------------------------------------------------------------
    */

    $antrian = Antrian::with([
        'pasien',
        'poli',
    ])
    ->where(
        'id_antrian',
        $id
    )
    ->where(
        'status_antrian',
        'dipanggil'
    )
    ->firstOrFail();


    /*
    |--------------------------------------------------------------------------
    | Pastikan poli sesuai dokter
    |--------------------------------------------------------------------------
    */

    $idPoli = $dokter->jadwalDokter()
        ->pluck('id_poli');

    if (
        !$idPoli->contains(
            $antrian->id_poli
        )
    ) {
        abort(403);
    }


    /*
    |--------------------------------------------------------------------------
    | Ambil konsultasi AI yang dipilih
    |--------------------------------------------------------------------------
    |
    | Harus:
    | - milik pasien yang sedang diperiksa
    | - status selesai
    |
    */

    $konsultasiAI = KonsultasiAI::where(
        'id_konsultasi_ai',
        $idKonsultasi
    )
    ->where(
        'id_pasien',
        $antrian->id_pasien
    )
    ->where(
        'status_konsultasi',
        'selesai'
    )
    ->firstOrFail();


    /*
    |--------------------------------------------------------------------------
    | Pastikan belum ada rekam medis untuk antrean ini
    |--------------------------------------------------------------------------
    */

    $rekamMedis = RekamMedis::where(
        'id_antrian',
        $antrian->id_antrian
    )->first();


    if ($rekamMedis) {

        return redirect()
            ->route(
                'dokter.rekam-medis.show',
                $rekamMedis->id_rekammedis
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Tampilkan form
    |--------------------------------------------------------------------------
    */

    return view(
        'dokter.rekam-medis.create',
        compact(
            'dokter',
            'antrian',
            'konsultasiAI'
        )
    );
}


    /**
     * Menyimpan rekam medis.
     */
    public function store(
        Request $request,
        string $id,
        string $idKonsultasi,
        RekamMedisIdGenerator $idGenerator
    ): RedirectResponse {

        $request->validate([

            'diagnosa_akhir' => [
                'required',
                'string',
                'max:255',
            ],

            'tindakan' => [
                'required',
                'string',
            ],

            'catatan' => [
                'nullable',
                'string',
            ],

        ], [

            'diagnosa_akhir.required' =>
                'Diagnosa akhir wajib diisi.',

            'tindakan.required' =>
                'Tindakan wajib diisi.',

        ]);


        $dokter = Auth::user()->dokter;

        if (!$dokter) {
            abort(404, 'Data dokter tidak ditemukan.');
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil antrean
        |--------------------------------------------------------------------------
        */

        $antrian = Antrian::with([
            'pasien',
        ])
        ->where(
            'id_antrian',
            $id
        )
        ->where(
            'status_antrian',
            'dipanggil'
        )
        ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Pastikan poli sesuai dokter
        |--------------------------------------------------------------------------
        */

        $idPoli = $dokter->jadwalDokter()
            ->pluck('id_poli');

        if (
            !$idPoli->contains(
                $antrian->id_poli
            )
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil konsultasi yang dipilih
        |--------------------------------------------------------------------------
        */

        $konsultasiAI = KonsultasiAI::where(
            'id_konsultasi_ai',
            $idKonsultasi
        )
        ->where(
            'id_pasien',
            $antrian->id_pasien
        )
        ->where(
            'status_konsultasi',
            'selesai'
        )
        ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Cegah duplikasi rekam medis
        |--------------------------------------------------------------------------
        */

        if (
            RekamMedis::where(
                'id_antrian',
                $antrian->id_antrian
            )->exists()
        ) {

            return redirect()
                ->route(
                    'dokter.antrian.index'
                )
                ->with(
                    'success',
                    'Rekam medis untuk pasien ini sudah dibuat.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan rekam medis
        |--------------------------------------------------------------------------
        */

        RekamMedis::create([

            'id_rekammedis' =>
                $idGenerator->generate(),

            'id_pasien' =>
                $antrian->id_pasien,

            'id_dokter' =>
                $dokter->id_dokter,

            'id_antrian' =>
                $antrian->id_antrian,

            'id_konsultasi_ai' =>
                $konsultasiAI->id_konsultasi_ai,

            'nama_pasien' =>
                $antrian->pasien->nama_pasien,

            'keluhan_pasien' =>
                $konsultasiAI->keluhan_pasien
                ?? 'Tidak tersedia',

            'diagnosa_awal' =>
                $konsultasiAI->diagnosa_awal
                ?? 'Belum tersedia',

            'diagnosa_akhir' =>
                $request->diagnosa_akhir,

            'tindakan' =>
                $request->tindakan,

            'catatan' =>
                $request->catatan,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Selesaikan antrean
        |--------------------------------------------------------------------------
        */

        $antrian->update([

            'status_antrian' =>
                'selesai',

        ]);


        return redirect()
            ->route(
                'dokter.antrian.index'
            )
            ->with(
                'success',
                'Rekam medis berhasil disimpan dan antrean pasien telah selesai.'
            );
    }
}