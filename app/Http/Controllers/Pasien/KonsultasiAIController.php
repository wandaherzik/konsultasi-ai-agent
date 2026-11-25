<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\KonsultasiAI;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Dokter;
use App\Services\Contracts\AIServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class KonsultasiAIController extends Controller
{
    /**
     * Service AI Agent
     */
    protected AIServiceInterface $aiService;

    public function __construct(
        AIServiceInterface $aiService
    ) {
        $this->aiService = $aiService;
    }


    /**
     * Mengambil data pasien yang sedang login.
     */
    private function getPasien(): Pasien
    {
        return Pasien::where(
            'id_user',
            Auth::id()
        )->firstOrFail();
    }


    /**
     * Menampilkan daftar konsultasi pasien.
     */
    public function index()
    {
        $pasien = $this->getPasien();

        $konsultasis = KonsultasiAI::where(
            'id_pasien',
            $pasien->id_pasien
        )
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view(
            'pasien.konsultasi.index',
            compact('konsultasis')
        );
    }


    /**
     * Menampilkan form konsultasi baru.
     */
    public function create()
    {
        return view(
            'pasien.konsultasi.create'
        );
    }


    /**
     * Membuat konsultasi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'keluhan' => [
                'required',
                'string',
                'min:3',
                'max:5000',
            ],
        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Ambil pasien
        |--------------------------------------------------------------------------
        */

        $pasien = $this->getPasien();


        /*
        |--------------------------------------------------------------------------
        | Generate ID konsultasi
        |--------------------------------------------------------------------------
        */

        $idKonsultasi =
            $this->generateKonsultasiId();


        /*
        |--------------------------------------------------------------------------
        | Generate session ID
        |--------------------------------------------------------------------------
        */

        $sessionId =
            'SESSION-' .
            strtoupper(
                Str::random(20)
            );


        /*
        |--------------------------------------------------------------------------
        | Simpan konsultasi
        |--------------------------------------------------------------------------
        */

        $konsultasi = KonsultasiAI::create([

            'id_konsultasi_ai' =>
                $idKonsultasi,

            'id_pasien' =>
                $pasien->id_pasien,

            'session_id' =>
                $sessionId,

            'status_konsultasi' =>
                'berlangsung',

            'keluhan_pasien' =>
                $request->keluhan,

            'diagnosa_awal' =>
                null,

            'saran_poli' =>
                null,

            'rekomendasi_dokter' =>
                null,

            'skor_urgensi' =>
                null,

            'respon_ai' =>
                null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan pesan pertama pasien
        |--------------------------------------------------------------------------
        */

        $konsultasi->pesan()->create([

            'pengirim' =>
                'pasien',

            'pesan' =>
                $request->keluhan,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Kirim percakapan ke AI
        |--------------------------------------------------------------------------
        */

        try {

            $responsAI =
                $this->aiService->chat(
                    $konsultasi->fresh('pesan')
                );

        } catch (\Throwable $e) {

            Log::error(
                'AI CONSULTATION ERROR',
                [

                    'user_id' =>
                        $user->id_user,

                    'pasien_id' =>
                        $pasien->id_pasien,

                    'konsultasi_id' =>
                        $konsultasi->id_konsultasi_ai,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Response ketika AI gagal
            |--------------------------------------------------------------------------
            */

            $responsAI = [

                'response' =>
                    'Terima kasih telah menyampaikan keluhan Anda. '
                    . 'Saat ini layanan AI sedang mengalami gangguan. '
                    . 'Silakan coba kirim pesan kembali beberapa saat lagi.',

                'selesai' =>
                    false,

                'diagnosa_awal' =>
                    null,

                'skor_urgensi' =>
                    null,

                'kategori_urgensi' =>
                    null,

                'rekomendasi_poli' =>
                    null,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil response AI
        |--------------------------------------------------------------------------
        */

        $pesanAI =
            $responsAI['response']
            ??
            'Maaf, AI tidak memberikan respons.';


        /*
        |--------------------------------------------------------------------------
        | Ambil rekomendasi poli
        |--------------------------------------------------------------------------
        */

        $rekomendasiPoli =
            $responsAI['rekomendasi_poli']
            ??
            null;


        /*
        |--------------------------------------------------------------------------
        | Cari seluruh dokter berdasarkan poli
        |--------------------------------------------------------------------------
        */

        $rekomendasiDokter =
            $this->getRekomendasiDokter(
                $rekomendasiPoli
            );


        /*
        |--------------------------------------------------------------------------
        | Simpan pesan AI
        |--------------------------------------------------------------------------
        */

        $konsultasi->pesan()->create([

            'pengirim' =>
                'ai',

            'pesan' =>
                $pesanAI,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Update hasil konsultasi
        |--------------------------------------------------------------------------
        */

        $updateData = [

            'respon_ai' =>
                $pesanAI,

        ];


        /*
        |--------------------------------------------------------------------------
        | Diagnosis awal
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $responsAI['diagnosa_awal']
                ?? null
            )
        ) {

            $updateData['diagnosa_awal'] =
                $responsAI['diagnosa_awal'];

        }


        /*
        |--------------------------------------------------------------------------
        | Rekomendasi poli
        |--------------------------------------------------------------------------
        */

        if (
            !empty($rekomendasiPoli)
        ) {

            $updateData['saran_poli'] =
                $rekomendasiPoli;

        }


        /*
        |--------------------------------------------------------------------------
        | Rekomendasi dokter
        |--------------------------------------------------------------------------
        */

        if (
            !empty($rekomendasiDokter)
        ) {

            $updateData['rekomendasi_dokter'] =
                $rekomendasiDokter;

        }


        /*
        |--------------------------------------------------------------------------
        | Skor urgensi
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $responsAI['skor_urgensi']
            )
            &&
            is_numeric(
                $responsAI['skor_urgensi']
            )
        ) {

            $updateData['skor_urgensi'] =
                (int)
                $responsAI['skor_urgensi'];

        }


        $konsultasi->update(
            $updateData
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'pasien.pasien.konsultasi.show',
            [
                'id' =>
                    $konsultasi->id_konsultasi_ai
            ]
        );
    }


    /**
     * Menampilkan detail konsultasi.
     */
    public function show($id)
    {
        $pasien =
            $this->getPasien();


        $konsultasi =
            KonsultasiAI::with([
                'pesan'
            ])
            ->where(
                'id_konsultasi_ai',
                $id
            )
            ->where(
                'id_pasien',
                $pasien->id_pasien
            )
            ->firstOrFail();


        return view(
            'pasien.konsultasi.show',
            compact('konsultasi')
        );
    }


    /**
     * Mengirim pesan lanjutan pasien.
     */
    public function sendMessage(
        Request $request,
        $id
    ) {

        $request->validate([
            'pesan' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);


        $user =
            Auth::user();

        $pasien =
            $this->getPasien();


        /*
        |--------------------------------------------------------------------------
        | Cari konsultasi
        |--------------------------------------------------------------------------
        */

        $konsultasi =
            KonsultasiAI::where(
                'id_konsultasi_ai',
                $id
            )
            ->where(
                'id_pasien',
                $pasien->id_pasien
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Pastikan konsultasi masih berlangsung
        |--------------------------------------------------------------------------
        */

        if (
            $konsultasi->status_konsultasi
            !== 'berlangsung'
        ) {

            return back()->with(
                'error',
                'Konsultasi ini sudah selesai.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan pesan pasien
        |--------------------------------------------------------------------------
        */

        $konsultasi->pesan()->create([

            'pengirim' =>
                'pasien',

            'pesan' =>
                $request->pesan,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Kirim seluruh history ke AI
        |--------------------------------------------------------------------------
        */

        try {

            $responsAI =
                $this->aiService->chat(
                    $konsultasi->fresh('pesan')
                );

        } catch (\Throwable $e) {

            Log::error(
                'AI SEND MESSAGE ERROR',
                [

                    'user_id' =>
                        $user->id_user,

                    'pasien_id' =>
                        $pasien->id_pasien,

                    'konsultasi_id' =>
                        $konsultasi->id_konsultasi_ai,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return back()->with(
                'error',
                'Layanan AI sedang mengalami gangguan. '
                . 'Silakan coba kembali beberapa saat lagi.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil response AI
        |--------------------------------------------------------------------------
        */

        $pesanAI =
            $responsAI['response']
            ??
            'Maaf, AI tidak memberikan respons.';


        /*
        |--------------------------------------------------------------------------
        | Ambil rekomendasi poli terbaru
        |--------------------------------------------------------------------------
        */

        $rekomendasiPoli =
            $responsAI['rekomendasi_poli']
            ??
            null;


        /*
        |--------------------------------------------------------------------------
        | Cari seluruh dokter pada poli
        |--------------------------------------------------------------------------
        */

        $rekomendasiDokter =
            $this->getRekomendasiDokter(
                $rekomendasiPoli
            );


        /*
        |--------------------------------------------------------------------------
        | Simpan jawaban AI
        |--------------------------------------------------------------------------
        */

        $konsultasi->pesan()->create([

            'pengirim' =>
                'ai',

            'pesan' =>
                $pesanAI,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Update data konsultasi
        |--------------------------------------------------------------------------
        */

        $updateData = [

            'respon_ai' =>
                $pesanAI,

        ];


        /*
        |--------------------------------------------------------------------------
        | Update diagnosis
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $responsAI['diagnosa_awal']
                ?? null
            )
        ) {

            $updateData['diagnosa_awal'] =
                $responsAI['diagnosa_awal'];

        }


        /*
        |--------------------------------------------------------------------------
        | Update poli
        |--------------------------------------------------------------------------
        */

        if (
            !empty($rekomendasiPoli)
        ) {

            $updateData['saran_poli'] =
                $rekomendasiPoli;

        }


        /*
        |--------------------------------------------------------------------------
        | Update dokter
        |--------------------------------------------------------------------------
        */

        if (
            !empty($rekomendasiDokter)
        ) {

            $updateData['rekomendasi_dokter'] =
                $rekomendasiDokter;

        }


        /*
        |--------------------------------------------------------------------------
        | Update skor urgensi
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $responsAI['skor_urgensi']
            )
            &&
            is_numeric(
                $responsAI['skor_urgensi']
            )
        ) {

            $updateData['skor_urgensi'] =
                (int)
                $responsAI['skor_urgensi'];

        }


        $konsultasi->update(
            $updateData
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'pasien.pasien.konsultasi.show',
            [
                'id' =>
                    $konsultasi->id_konsultasi_ai
            ]
        );
    }


    public function finish($id)
{
    $pasien = $this->getPasien();

    /*
    |--------------------------------------------------------------------------
    | Cari konsultasi milik pasien
    |--------------------------------------------------------------------------
    */

    $konsultasi = KonsultasiAI::with('pesan')
        ->where(
            'id_konsultasi_ai',
            $id
        )
        ->where(
            'id_pasien',
            $pasien->id_pasien
        )
        ->firstOrFail();


    /*
    |--------------------------------------------------------------------------
    | Pastikan konsultasi masih berlangsung
    |--------------------------------------------------------------------------
    */

    if (
        $konsultasi->status_konsultasi !== 'berlangsung'
    ) {

        return back()->with(
            'error',
            'Konsultasi sudah selesai.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Ambil pesan AI terakhir
    |--------------------------------------------------------------------------
    */

    $pesanTerakhirAI = $konsultasi->pesan
        ->where('pengirim', 'ai')
        ->last();


    /*
    |--------------------------------------------------------------------------
    | Siapkan data yang akan disimpan
    |--------------------------------------------------------------------------
    */

    $updateData = [

        'status_konsultasi' => 'selesai',

    ];


    /*
    |--------------------------------------------------------------------------
    | Simpan response AI terakhir
    |--------------------------------------------------------------------------
    */

    if ($pesanTerakhirAI) {

        $updateData['respon_ai'] =
            $pesanTerakhirAI->pesan;

    }


    /*
    |--------------------------------------------------------------------------
    | Update database
    |--------------------------------------------------------------------------
    */

    $konsultasi->update(
        $updateData
    );


    /*
    |--------------------------------------------------------------------------
    | Refresh data dari database
    |--------------------------------------------------------------------------
    */

    $konsultasi->refresh();


    /*
    |--------------------------------------------------------------------------
    | Log untuk pengecekan
    |--------------------------------------------------------------------------
    */

    Log::info(
        'HASIL KONSULTASI AI DISIMPAN',
        [

            'id_konsultasi_ai' =>
                $konsultasi->id_konsultasi_ai,

            'id_pasien' =>
                $konsultasi->id_pasien,

            'status' =>
                $konsultasi->status_konsultasi,

            'keluhan_pasien' =>
                $konsultasi->keluhan_pasien,

            'diagnosa_awal' =>
                $konsultasi->diagnosa_awal,

            'saran_poli' =>
                $konsultasi->saran_poli,

            'rekomendasi_dokter' =>
                $konsultasi->rekomendasi_dokter,

            'skor_urgensi' =>
                $konsultasi->skor_urgensi,

            'respon_ai' =>
                $konsultasi->respon_ai,

        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Kembali ke halaman konsultasi
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'pasien.pasien.konsultasi.show',
            [
                'id' =>
                    $konsultasi->id_konsultasi_ai
            ]
        )
        ->with(
            'success',
            'Konsultasi berhasil diakhiri dan hasil konsultasi telah disimpan.'
        );
}

    /**
     * Membuat ID konsultasi.
     */
    private function generateKonsultasiId(): string
    {
        do {

            $id =
                'KAI' .
                strtoupper(
                    Str::random(8)
                );

        } while (
            KonsultasiAI::where(
                'id_konsultasi_ai',
                $id
            )->exists()
        );


        return $id;
    }


    /**
     * Mengambil seluruh dokter yang mempunyai
     * jadwal pada poli yang direkomendasikan AI.
     *
     * Contoh:
     *
     * Poli Umum
     *      ↓
     * dr. Ahmad
     * dr. Budi
     * dr. Citra
     */
    private function getRekomendasiDokter(
        ?string $namaPoli
    ): ?string {

        /*
        |--------------------------------------------------------------------------
        | Tidak ada rekomendasi poli
        |--------------------------------------------------------------------------
        */

        if (
            empty($namaPoli)
        ) {

            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Cari poli
        |--------------------------------------------------------------------------
        */

        $poli =
            Poli::where(
                'nama_poli',
                'LIKE',
                '%' .
                trim($namaPoli) .
                '%'
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Poli tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (
            !$poli
        ) {

            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil seluruh dokter yang mempunyai
        | jadwal pada poli tersebut
        |--------------------------------------------------------------------------
        */

        $dokter =
            Dokter::whereHas(
                'jadwalDokter',
                function ($query) use ($poli) {

                    $query->where(
                        'id_poli',
                        $poli->id_poli
                    );

                }
            )
            ->orderBy(
                'nama_dokter'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Tidak ada dokter
        |--------------------------------------------------------------------------
        */

        if (
            $dokter->isEmpty()
        ) {

            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Gabungkan seluruh nama dokter
        |--------------------------------------------------------------------------
        */

        return $dokter
            ->pluck(
                'nama_dokter'
            )
            ->implode(
                ', '
            );
    }
}