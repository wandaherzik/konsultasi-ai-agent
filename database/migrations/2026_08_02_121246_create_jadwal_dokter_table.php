<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan Migration
     */
    public function up(): void
    {
        Schema::create('jadwal_dokter', function (Blueprint $table) {

            // Primary Key
            $table->string('id_jadwaldokter',11)->primary();

            // Foreign Key
            $table->string('id_poli',11);

            $table->string('id_dokter',11);

            // Hari Praktik
            $table->enum('hari',[
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu'
            ]);

            // Jam Praktik
            $table->time('jam_buka');

            $table->time('jam_tutup');

            // Timestamp
            $table->timestamps();

            // Relasi
            $table->foreign('id_poli')
                ->references('id_poli')
                ->on('poli')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('id_dokter')
                ->references('id_dokter')
                ->on('dokter')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

        });
    }

    /**
     * Rollback Migration
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_dokter');
    }
};