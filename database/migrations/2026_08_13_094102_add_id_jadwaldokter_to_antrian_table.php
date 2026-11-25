<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antrian', function (Blueprint $table) {

            $table->string('id_jadwaldokter', 20)
                ->nullable()
                ->after('id_konsultasi_ai');

            $table->foreign('id_jadwaldokter')
                ->references('id_jadwaldokter')
                ->on('jadwal_dokter')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('antrian', function (Blueprint $table) {

            $table->dropForeign([
                'id_jadwaldokter'
            ]);

            $table->dropColumn(
                'id_jadwaldokter'
            );

        });
    }
};