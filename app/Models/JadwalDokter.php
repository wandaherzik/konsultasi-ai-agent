<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $table = 'jadwal_dokter';

    protected $primaryKey = 'id_jadwaldokter';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_jadwaldokter',
        'id_poli',
        'id_dokter',
        'hari',
        'jam_buka',
        'jam_tutup',
    ];

    public function dokter()
    {
        return $this->belongsTo(
            Dokter::class,
            'id_dokter',
            'id_dokter'
        );
    }

    public function poli()
    {
        return $this->belongsTo(
            Poli::class,
            'id_poli',
            'id_poli'
        );
    }
}