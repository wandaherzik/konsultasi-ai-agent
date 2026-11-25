<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorReferensi extends Model
{
    protected $table = 'nomor_referensi';

    protected $primaryKey = 'kode';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'kode',
        'nomor_terakhir'
    ];
}