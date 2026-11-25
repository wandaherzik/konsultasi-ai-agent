<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NomorReferensi;

class NomorReferensiSeeder extends Seeder
{
    public function run(): void
    {
        $kode = [
            'USR',
            'PSN',
            'DKT',
            'POL',
            'JDL',
            'KAI',
            'ANT',
            'RKM',
            'LPK'
        ];

        foreach ($kode as $item) {

            NomorReferensi::firstOrCreate([
                'kode' => $item
            ],[
                'nomor_terakhir' => 0
            ]);

        }
    }
}