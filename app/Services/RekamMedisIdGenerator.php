<?php

namespace App\Services;

use App\Models\RekamMedis;
use Illuminate\Support\Str;

class RekamMedisIdGenerator
{
    public function generate(): string
    {
        do {
            $id = 'RM-' . strtoupper(Str::random(8));
        } while (
            RekamMedis::where(
                'id_rekammedis',
                $id
            )->exists()
        );

        return $id;
    }
}