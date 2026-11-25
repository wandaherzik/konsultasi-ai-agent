<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiAI extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_ai';

    protected $primaryKey = 'id_konsultasi_ai';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id_konsultasi_ai',
        'id_pasien',
        'session_id',
        'keluhan_pasien',
        'diagnosa_awal',
        'saran_poli',
        'rekomendasi_dokter',
        'skor_urgensi',
        'respon_ai',
        'status_konsultasi',
    ];

    /**
     * Relasi ke pasien
     */
    public function pasien()
    {
        return $this->belongsTo(
            Pasien::class,
            'id_pasien',
            'id_pasien'
        );
    }

public function pesan()
{
    return $this->hasMany(
        PesanKonsultasiAI::class,
        'id_konsultasi_ai',
        'id_konsultasi_ai'
    )->orderBy('created_at', 'asc');
}
}