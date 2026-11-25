<?php

namespace App\Services;

use App\Models\Pasien;
use Illuminate\Support\Str;

class PasienIdGenerator
{
    public function generate(): string
    {
        do {
            $id = 'PS-' . strtoupper(
                Str::random(8)
            );
        } while (
            Pasien::where(
                'id_pasien',
                $id
            )->exists()
        );

        return $id;
    }
}
