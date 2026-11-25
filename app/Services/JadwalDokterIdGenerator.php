<?php

namespace App\Services;

use App\Models\JadwalDokter;
use Illuminate\Support\Str;

class JadwalDokterIdGenerator
{
    public function generate(): string
    {
        do {
            $id = 'JD-' . strtoupper(
                Str::random(8)
            );

        } while (
            JadwalDokter::where(
                'id_jadwaldokter',
                $id
            )->exists()
        );

        return $id;
    }
}