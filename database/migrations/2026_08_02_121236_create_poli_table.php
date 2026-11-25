<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration.
     */
    public function up(): void
    {
        Schema::create('poli', function (Blueprint $table) {

            // Primary Key
            $table->string('id_poli', 11)->primary();

            // Nama Poli
            $table->string('nama_poli',100);

            // Deskripsi
            $table->text('deskripsi');

            // Kapasitas Harian
            $table->integer('kapasitas_harian');

            // Timestamp
            $table->timestamps();

        });
    }

    /**
     * Membatalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('poli');
    }
};