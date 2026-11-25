<?php

namespace App\Exports;

use App\Models\RekamMedis;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanKunjunganExport implements
    FromCollection,
    WithHeadings,
    WithMapping
{
    protected $tanggalMulai;
    protected $tanggalSelesai;
    protected $idPoli;

public function __construct(
    $tanggalMulai = null,
    $tanggalSelesai = null,
    $idPoli = null
) {
    $this->tanggalMulai = $tanggalMulai;
    $this->tanggalSelesai = $tanggalSelesai;
    $this->idPoli = $idPoli;
}


    /**
     * Mengambil data laporan.
     */
    public function collection(): Collection
    {
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

        if ($this->tanggalMulai) {

            $query->whereHas('antrian', function ($q) {

                $q->whereDate(
                    'tanggal_kunjungan',
                    '>=',
                    $this->tanggalMulai
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Filter tanggal selesai
        |--------------------------------------------------------------------------
        */

        if ($this->tanggalSelesai) {

            $query->whereHas('antrian', function ($q) {

                $q->whereDate(
                    'tanggal_kunjungan',
                    '<=',
                    $this->tanggalSelesai
                );

            });

        }

        if ($this->idPoli) {

    $query->whereHas('antrian', function ($q) {

        $q->where(
            'id_poli',
            $this->idPoli
        );

    });

}


        return $query
            ->latest()
            ->get();
    }


    /**
     * Header Excel.
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal Kunjungan',
            'Nama Pasien',
            'Poli',
            'Dokter',
            'Diagnosa Awal',
            'Diagnosa Akhir',
            'Tindakan',
            'Catatan',
        ];
    }


    /**
     * Mapping data ke Excel.
     */
    public function map($rekamMedis): array
    {
        return [

            $rekamMedis->id_rekammedis,

            optional(
                $rekamMedis->antrian
            )->tanggal_kunjungan,

            $rekamMedis->pasien->nama_pasien
                ?? $rekamMedis->nama_pasien
                ?? '-',

            optional(
                optional(
                    $rekamMedis->antrian
                )->poli
            )->nama_poli
                ?? '-',

            $rekamMedis->dokter->nama_dokter
                ?? '-',

            $rekamMedis->diagnosa_awal
                ?? '-',

            $rekamMedis->diagnosa_akhir
                ?? '-',

            $rekamMedis->tindakan
                ?? '-',

            $rekamMedis->catatan
                ?? '-',
        ];
    }
}