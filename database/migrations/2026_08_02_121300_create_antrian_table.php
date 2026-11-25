<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrian', function (Blueprint $table) {

            $table->string('id_antrian',11)->primary();

            $table->string('id_pasien',11);

            $table->string('id_konsultasi_ai',11);

            $table->string('id_poli',11);

            $table->string('no_antrian',10);

            $table->string('diagnosa_awal',255);

            $table->integer('skor_urgensi');

            $table->enum('status_antrian',[
                'menunggu',
                'dipanggil',
                'selesai',
                'batal'
            ])->default('menunggu');

            $table->date('tanggal_kunjungan');

            $table->timestamps();

            $table->foreign('id_pasien')
                    ->references('id_pasien')
                    ->on('pasien')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

            $table->foreign('id_konsultasi_ai')
                    ->references('id_konsultasi_ai')
                    ->on('konsultasi_ai')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

            $table->foreign('id_poli')
                    ->references('id_poli')
                    ->on('poli')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrian');
    }
};