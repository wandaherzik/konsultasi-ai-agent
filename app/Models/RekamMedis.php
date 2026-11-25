<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\KonsultasiAI;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';

    protected $primaryKey = 'id_rekammedis';

    public $incrementing = false;

    protected $keyType = 'string';

protected $fillable = [
    'id_rekammedis',
    'id_pasien',
    'id_dokter',
    'id_antrian',
    'id_konsultasi_ai',
    'nama_pasien',
    'keluhan_pasien',
    'diagnosa_awal',
    'diagnosa_akhir',
    'tindakan',
    'catatan',
];

    /**
     * Relasi ke pasien
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(
            Pasien::class,
            'id_pasien',
            'id_pasien'
        );
    }

    /**
     * Relasi ke dokter
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(
            Dokter::class,
            'id_dokter',
            'id_dokter'
        );
    }

    /**
     * Relasi ke antrean
     */
    public function antrian(): BelongsTo
    {
        return $this->belongsTo(
            Antrian::class,
            'id_antrian',
            'id_antrian'
        );
    }

    public function konsultasiAI()
{
    return $this->belongsTo(
        KonsultasiAI::class,
        'id_konsultasi_ai',
        'id_konsultasi_ai'
    );
}
}