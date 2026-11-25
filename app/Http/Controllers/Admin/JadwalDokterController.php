<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JadwalDokterRequest;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Poli;
use App\Services\JadwalDokterIdGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JadwalDokterController extends Controller
{
    /**
     * Menampilkan daftar jadwal dokter.
     */
    public function index()
    {
        $jadwalDokters = JadwalDokter::with([
            'dokter',
            'poli',
        ])
        ->orderByRaw("
            FIELD(
                hari,
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu'
            )
        ")
        ->orderBy('jam_buka')
        ->paginate(10);

        return view(
            'admin.jadwal-dokter.index',
            compact('jadwalDokters')
        );
    }


    /**
     * Form tambah jadwal.
     */
    public function create()
    {
        $dokters = Dokter::orderBy(
            'nama_dokter'
        )->get();

        $polis = Poli::orderBy(
            'nama_poli'
        )->get();

        return view(
            'admin.jadwal-dokter.create',
            compact(
                'dokters',
                'polis'
            )
        );
    }


    /**
     * Menyimpan jadwal baru.
     */
    public function store(
        JadwalDokterRequest $request,
        JadwalDokterIdGenerator $idGenerator
    ): RedirectResponse {

        $data = $request->validated();

        /*
         * Cek apakah dokter sudah memiliki
         * jadwal yang bentrok.
         */
        $bentrok = JadwalDokter::where(
            'id_dokter',
            $data['id_dokter']
        )
        ->where(
            'hari',
            $data['hari']
        )
        ->where(function ($query) use ($data) {

            $query
                ->where(
                    'jam_buka',
                    '<',
                    $data['jam_tutup']
                )
                ->where(
                    'jam_tutup',
                    '>',
                    $data['jam_buka']
                );
        })
        ->exists();


        if ($bentrok) {

            throw ValidationException::withMessages([
                'jam_buka' =>
                    'Dokter tersebut sudah memiliki jadwal yang bentrok pada hari dan jam tersebut.',
            ]);
        }


        JadwalDokter::create([

            'id_jadwaldokter' =>
                $idGenerator->generate(),

            'id_dokter' =>
                $data['id_dokter'],

            'id_poli' =>
                $data['id_poli'],

            'hari' =>
                $data['hari'],

            'jam_buka' =>
                $data['jam_buka'],

            'jam_tutup' =>
                $data['jam_tutup'],

        ]);


        return redirect()
            ->route('admin.jadwal-dokter.index')
            ->with(
                'success',
                'Jadwal dokter berhasil ditambahkan.'
            );
    }


    /**
     * Form edit jadwal.
     */
    public function edit(string $id)
    {
        $jadwalDokter =
            JadwalDokter::findOrFail($id);

        $dokters = Dokter::orderBy(
            'nama_dokter'
        )->get();

        $polis = Poli::orderBy(
            'nama_poli'
        )->get();

        return view(
            'admin.jadwal-dokter.edit',
            compact(
                'jadwalDokter',
                'dokters',
                'polis'
            )
        );
    }


    /**
     * Update jadwal.
     */
    public function update(
        JadwalDokterRequest $request,
        string $id
    ): RedirectResponse {

        $jadwalDokter =
            JadwalDokter::findOrFail($id);

        $data = $request->validated();


        /*
         * Cek bentrok.
         *
         * Jadwal yang sedang diedit
         * dikecualikan dari pengecekan.
         */
        $bentrok = JadwalDokter::where(
            'id_dokter',
            $data['id_dokter']
        )
        ->where(
            'hari',
            $data['hari']
        )
        ->where(
            'id_jadwaldokter',
            '!=',
            $jadwalDokter->id_jadwaldokter
        )
        ->where(function ($query) use ($data) {

            $query
                ->where(
                    'jam_buka',
                    '<',
                    $data['jam_tutup']
                )
                ->where(
                    'jam_tutup',
                    '>',
                    $data['jam_buka']
                );
        })
        ->exists();


        if ($bentrok) {

            throw ValidationException::withMessages([
                'jam_buka' =>
                    'Dokter tersebut sudah memiliki jadwal yang bentrok pada hari dan jam tersebut.',
            ]);
        }


        $jadwalDokter->update([

            'id_dokter' =>
                $data['id_dokter'],

            'id_poli' =>
                $data['id_poli'],

            'hari' =>
                $data['hari'],

            'jam_buka' =>
                $data['jam_buka'],

            'jam_tutup' =>
                $data['jam_tutup'],

        ]);


        return redirect()
            ->route('admin.jadwal-dokter.index')
            ->with(
                'success',
                'Jadwal dokter berhasil diperbarui.'
            );
    }


    /**
     * Menghapus jadwal.
     */
    public function destroy(
        string $id
    ): RedirectResponse {

        $jadwalDokter =
            JadwalDokter::findOrFail($id);

        $jadwalDokter->delete();


        return redirect()
            ->route('admin.jadwal-dokter.index')
            ->with(
                'success',
                'Jadwal dokter berhasil dihapus.'
            );
    }

    /**
 * Menampilkan jadwal dokter untuk pasien.
 */
public function pasienIndex(Request $request)
{
    $jadwalDokters = JadwalDokter::with([
        'dokter',
        'poli',
    ])
    ->when(
        $request->filled('id_poli'),
        function ($query) use ($request) {

            $query->where(
                'id_poli',
                $request->id_poli
            );

        }
    )
    ->when(
        $request->filled('hari'),
        function ($query) use ($request) {

            $query->where(
                'hari',
                $request->hari
            );

        }
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
    ->orderBy('jam_buka')
    ->paginate(10)
    ->withQueryString();


    $polis = Poli::orderBy(
        'nama_poli'
    )->get();


    $hari = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu',
    ];


    return view(
        'pasien.jadwal.index',
        compact(
            'jadwalDokters',
            'polis',
            'hari'
        )
    );
}

/**
 * Menampilkan halaman pendaftaran antrean pasien.
 */
public function daftar(string $id)
{
    $jadwalDokter = JadwalDokter::with([
        'dokter',
        'poli',
    ])->findOrFail($id);

    return view(
        'pasien.jadwal.daftar',
        compact('jadwalDokter')
    );
}
}