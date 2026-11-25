<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = 'poli';

    protected $primaryKey = 'id_poli';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_poli',
        'nama_poli',
        'deskripsi',
        'kapasitas_harian',
    ];

    public function jadwalDokter()
{
    return $this->hasMany(
        JadwalDokter::class,
        'id_poli',
        'id_poli'
    );
}
}