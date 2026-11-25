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
        Schema::create('dokter', function (Blueprint $table) {

            // Primary Key
            $table->string('id_dokter', 11)->primary();

            // Foreign Key ke tabel users
            $table->string('id_user', 20);

            // Data Dokter
            $table->string('nama_dokter', 100);

            $table->string('spesialisasi_dokter', 100);

            // Timestamp
            $table->timestamps();

            // Relasi Foreign Key
            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Membatalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};