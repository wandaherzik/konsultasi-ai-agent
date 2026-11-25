<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE konsultasi_ai
            MODIFY status_konsultasi
            ENUM('berlangsung', 'selesai', 'batal')
            NOT NULL
            DEFAULT 'berlangsung'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE konsultasi_ai
            MODIFY status_konsultasi
            ENUM('selesai', 'batal')
            NOT NULL
            DEFAULT 'selesai'
        ");
    }
};