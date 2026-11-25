<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konsultasi_ai', function (Blueprint $table) {

            $table->string('rekomendasi_dokter')
                ->nullable()
                ->after('saran_poli');

        });
    }

    public function down(): void
    {
        Schema::table('konsultasi_ai', function (Blueprint $table) {

            $table->dropColumn('rekomendasi_dokter');

        });
    }
};

