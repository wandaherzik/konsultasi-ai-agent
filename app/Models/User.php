<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Dokter;
use App\Models\Pasien;

class User extends Authenticatable
{
    
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Nama tabel
     */
    protected $table = 'users';

    /**
     * Primary Key
     */
    protected $primaryKey = 'id_user';

    /**
     * Primary Key bertipe String
     */
    protected $keyType = 'string';

    /**
     * Tidak menggunakan Auto Increment
     */
    public $incrementing = false;

    /**
     * Field yang dapat diisi
     */
    protected $fillable = [
        'id_user',
        'nama',
        'username',
        'password',
        'role',
    ];

    /**
     * Field yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /*Relasi*/

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'id_user', 'id_user');
    }

public function dokter(): HasOne
{
    return $this->hasOne(
        Dokter::class,
        'id_user',
        'id_user'
    );
}
}