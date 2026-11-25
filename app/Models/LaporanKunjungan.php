<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKunjungan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kunjungan';

    protected $primaryKey = 'id_laporankunjungan';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id_laporankunjungan',
        'id_pasien',
        'id_dokter',
        'id_antrian',
        'nama_pasien',
        'keluhan_pasien',
        'diagnosa_awal',
        'diagnosa_akhir',
        'tindakan',
        'catatan',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function antrian()
    {
        return $this->belongsTo(Antrian::class, 'id_antrian', 'id_antrian');
    }
}