<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {

            $table->string('id_konsultasi_ai')
                ->nullable()
                ->after('id_antrian');

        });
    }

    public function down(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {

            $table->dropColumn('id_konsultasi_ai');

        });
    }
};