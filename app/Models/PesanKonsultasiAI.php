<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanKonsultasiAI extends Model
{
    use HasFactory;

    protected $table = 'pesan_konsultasi_ai';

    protected $fillable = [
        'id_konsultasi_ai',
        'pengirim',
        'pesan',
    ];

    public function konsultasiAI()
    {
        return $this->belongsTo(
            KonsultasiAI::class,
            'id_konsultasi_ai',
            'id_konsultasi_ai'
        );
    }
}