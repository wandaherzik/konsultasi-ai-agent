<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {

            $table->string('id_rekammedis',11)->primary();

            $table->string('id_pasien',11);

            $table->string('id_dokter',11);

            $table->string('id_antrian',11);

            $table->string('nama_pasien',100);

            $table->text('keluhan_pasien');

            $table->string('diagnosa_awal',255);

            $table->string('diagnosa_akhir',255);

            $table->text('tindakan');

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->foreign('id_pasien')
                ->references('id_pasien')
                ->on('pasien')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('id_dokter')
                ->references('id_dokter')
                ->on('dokter')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('id_antrian')
                ->references('id_antrian')
                ->on('antrian')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};