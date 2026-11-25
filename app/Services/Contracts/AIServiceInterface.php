<?php

namespace App\Services\Contracts;

use App\Models\KonsultasiAI;

interface AIServiceInterface
{
    public function chat(
        KonsultasiAI $konsultasi
    ): array;
}