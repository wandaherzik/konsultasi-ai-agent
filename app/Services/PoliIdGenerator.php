<?php

namespace App\Services;

use App\Models\Poli;

class PoliIdGenerator
{
    public function generate(): string
    {
        $lastPoli = Poli::orderByDesc('id_poli')->first();

        if (! $lastPoli) {
            return 'POL-000001';
        }

        $lastNumber = (int) substr($lastPoli->id_poli, 4);

        $nextNumber = $lastNumber + 1;

        return 'POL-' . str_pad(
            $nextNumber,
            6,
            '0',
            STR_PAD_LEFT
        );
    }
}