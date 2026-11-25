<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokter extends Model
{
    protected $table = 'dokter';

    protected $primaryKey = 'id_dokter';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_dokter',
        'id_user',
        'nama_dokter',
        'spesialisasi_dokter',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

public function jadwalDokter()
{
    return $this->hasMany(
        JadwalDokter::class,
        'id_dokter',
        'id_dokter'
    );
}

public function poli()
{
    return $this->hasManyThrough(
        Poli::class,
        JadwalDokter::class,
        'id_dokter',
        'id_poli',
        'id_dokter',
        'id_poli'
    );
}

}