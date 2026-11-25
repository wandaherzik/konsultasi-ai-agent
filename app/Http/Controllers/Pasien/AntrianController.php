<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\JadwalDokter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\KonsultasiAI;

class AntrianController extends Controller
{
    /**
     * Menampilkan antrean pasien.
     */
    public function index(): View
    {
        $pasien = Auth::user()->pasien;

        $antrians = Antrian::with([
            'jadwalDokter.dokter',
            'poli',
        ])
        ->where(
            'id_pasien',
            $pasien->id_pasien
        )
        ->latest('tanggal_kunjungan')
        ->latest()
        ->paginate(10);

        return view(
            'pasien.antrian.index',
            compact(
                'antrians',
                'pasien'
            )
        );
    }
    /**
     * Menampilkan form pendaftaran antrean.
     */
    /**
 * Menampilkan form pendaftaran antrean.
 */
public function create(Request $request): View
{
    $pasien = Auth::user()->pasien;

    /*
    |--------------------------------------------------------------------------
    | Ambil seluruh konsultasi AI pasien yang sudah selesai
    |--------------------------------------------------------------------------
    */

    $konsultasisAI = KonsultasiAI::where(
        'id_pasien',
        $pasien->id_pasien
    )
    ->where(
        'status_konsultasi',
        'selesai'
    )
    ->latest('updated_at')
    ->get();


    /*
    |--------------------------------------------------------------------------
    | Konsultasi yang dipilih dari tombol
    |--------------------------------------------------------------------------
    */

    $konsultasiTerpilih = null;

    if ($request->filled('id_konsultasi_ai')) {

        $konsultasiTerpilih = $konsultasisAI
            ->firstWhere(
                'id_konsultasi_ai',
                $request->id_konsultasi_ai
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Ambil jadwal dokter
    |--------------------------------------------------------------------------
    */

    $jadwalDokters = JadwalDokter::with([
        'dokter',
        'poli',
    ])
    ->orderBy('hari')
    ->orderBy('jam_buka')
    ->get();


    return view(
        'pasien.antrian.create',
        compact(
            'pasien',
            'konsultasisAI',
            'konsultasiTerpilih',
            'jadwalDokters'
        )
    );
}
    /**
     * Menyimpan pendaftaran antrean.
     */
public function store(
    Request $request
): RedirectResponse {

    $request->validate([

        'id_jadwaldokter' => [
            'required',
            'exists:jadwal_dokter,id_jadwaldokter',
        ],

        'tanggal_kunjungan' => [
            'required',
            'date',
            'after_or_equal:today',
        ],

        'id_konsultasi_ai' => [
            'nullable',
            'exists:konsultasi_ai,id_konsultasi_ai',
        ],

    ], [

        'id_jadwaldokter.required' =>
            'Jadwal dokter wajib dipilih.',

        'id_jadwaldokter.exists' =>
            'Jadwal dokter tidak ditemukan.',

        'tanggal_kunjungan.required' =>
            'Tanggal kunjungan wajib dipilih.',

        'tanggal_kunjungan.after_or_equal' =>
            'Tanggal kunjungan tidak boleh sebelum hari ini.',

        'id_konsultasi_ai.exists' =>
            'Konsultasi AI tidak ditemukan.',

    ]);


    $pasien = Auth::user()->pasien;


    /*
    |--------------------------------------------------------------------------
    | Ambil jadwal dokter
    |--------------------------------------------------------------------------
    */

    $jadwalDokter = JadwalDokter::with([
        'poli',
    ])->findOrFail(
        $request->id_jadwaldokter
    );


    /*
    |--------------------------------------------------------------------------
    | Ambil konsultasi AI yang dipilih
    |--------------------------------------------------------------------------
    */

    $konsultasiAI = null;


    if ($request->filled('id_konsultasi_ai')) {

        $konsultasiAI = KonsultasiAI::where(
            'id_konsultasi_ai',
            $request->id_konsultasi_ai
        )
        ->where(
            'id_pasien',
            $pasien->id_pasien
        )
        ->where(
            'status_konsultasi',
            'selesai'
        )
        ->firstOrFail();

    }


    /*
    |--------------------------------------------------------------------------
    | Validasi konsultasi AI harus sesuai dengan poli
    |--------------------------------------------------------------------------
    */

    if ($konsultasiAI) {

        if (
            !$konsultasiAI->saran_poli
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'id_konsultasi_ai' =>
                        'Konsultasi AI tersebut belum memiliki rekomendasi poli.'
                ]);

        }

        $namaPoliAI = trim(
            $konsultasiAI->saran_poli
        );

        $namaPoliJadwal = trim(
            $jadwalDokter->poli->nama_poli
        );

        if (
            strcasecmp(
                $namaPoliAI,
                $namaPoliJadwal
            ) !== 0
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'id_konsultasi_ai' =>
                        'Poli dokter yang dipilih tidak sesuai dengan rekomendasi poli dari konsultasi AI.'
                ]);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Validasi hari jadwal
    |--------------------------------------------------------------------------
    */

    $tanggal = \Carbon\Carbon::parse(
        $request->tanggal_kunjungan
    );

    $hari = $tanggal
        ->locale('id')
        ->translatedFormat('l');


    if (
        strtolower($hari)
        !== strtolower($jadwalDokter->hari)
    ) {

        return back()
            ->withInput()
            ->withErrors([
                'tanggal_kunjungan' =>
                    'Tanggal yang dipilih tidak sesuai dengan hari tugas dokter.'
            ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Cek pasien sudah terdaftar
    |--------------------------------------------------------------------------
    */

    $sudahTerdaftar = Antrian::where(
        'id_pasien',
        $pasien->id_pasien
    )
    ->where(
        'id_jadwaldokter',
        $jadwalDokter->id_jadwaldokter
    )
    ->where(
        'tanggal_kunjungan',
        $request->tanggal_kunjungan
    )
    ->whereNotIn(
        'status_antrian',
        ['batal']
    )
    ->exists();


    if ($sudahTerdaftar) {

        return back()
            ->withInput()
            ->withErrors([
                'tanggal_kunjungan' =>
                    'Anda sudah terdaftar pada jadwal dokter tersebut untuk tanggal yang dipilih.'
            ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Generate nomor antrean
    |--------------------------------------------------------------------------
    */

    $jumlahAntrian = Antrian::where(
        'id_jadwaldokter',
        $jadwalDokter->id_jadwaldokter
    )
    ->where(
        'tanggal_kunjungan',
        $request->tanggal_kunjungan
    )
    ->count();


    $nomorAntrian = $jumlahAntrian + 1;


    /*
    |--------------------------------------------------------------------------
    | Simpan antrean
    |--------------------------------------------------------------------------
    */

    $antrian = Antrian::create([

        'id_antrian' =>
            'ANT-' . strtoupper(
                Str::random(7)
            ),

        'id_pasien' =>
            $pasien->id_pasien,

        /*
         * Hubungkan antrean dengan
         * konsultasi AI yang dipilih.
         */
        'id_konsultasi_ai' =>
            $konsultasiAI?->id_konsultasi_ai,

        'id_jadwaldokter' =>
            $jadwalDokter->id_jadwaldokter,

        'id_poli' =>
            $jadwalDokter->id_poli,

        'no_antrian' =>
            str_pad(
                $nomorAntrian,
                3,
                '0',
                STR_PAD_LEFT
            ),

        /*
         * Ambil hasil AI.
         */
        'diagnosa_awal' =>
            $konsultasiAI?->diagnosa_awal
            ?? 'Belum ada',

        'skor_urgensi' =>
            $konsultasiAI?->skor_urgensi
            ?? 0,

        'status_antrian' =>
            'menunggu',

        'tanggal_kunjungan' =>
            $request->tanggal_kunjungan,

    ]);


    return redirect()
        ->route(
            'pasien.antrian.index'
        )
        ->with(
            'success',
            'Pendaftaran antrean berhasil.'
        );
}
}