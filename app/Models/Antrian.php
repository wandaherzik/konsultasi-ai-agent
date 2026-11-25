<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RekamMedis;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';

    protected $primaryKey = 'id_antrian';

    protected $keyType = 'string';

    public $incrementing = false;

  protected $fillable = [
    'id_antrian',
    'id_pasien',
    'id_konsultasi_ai',
    'id_jadwaldokter',
    'id_poli',
    'no_antrian',
    'diagnosa_awal',
    'skor_urgensi',
    'status_antrian',
    'tanggal_kunjungan',
];

public function jadwalDokter()
{
    return $this->belongsTo(
        JadwalDokter::class,
        'id_jadwaldokter',
        'id_jadwaldokter'
    );
}

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function konsultasiAI()
    {
        return $this->belongsTo(KonsultasiAI::class, 'id_konsultasi_ai', 'id_konsultasi_ai');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli', 'id_poli');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'id_antrian', 'id_antrian');
    }
}