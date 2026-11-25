<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RekamMedis;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $primaryKey = 'id_pasien';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id_pasien',
        'id_user',
        'nama_pasien',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'jenis_pasien',
        'alamat',
        'no_telepon',
    ];
        protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }

    /**
     * Relasi ke Konsultasi AI
     */
    public function konsultasiAI()
    {
        return $this->hasMany(KonsultasiAI::class,'id_pasien','id_pasien');
    }

    /**
     * Relasi ke Antrian
     */
    public function antrian()
    {
        return $this->hasMany(Antrian::class,'id_pasien','id_pasien');
    }

    /**
     * Relasi ke Rekam Medis
     */
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class,'id_pasien','id_pasien');
    }

    /**
     * Relasi ke Laporan
     */
    public function laporanKunjungan()
    {
        return $this->hasMany(LaporanKunjungan::class,'id_pasien','id_pasien');
    }
}