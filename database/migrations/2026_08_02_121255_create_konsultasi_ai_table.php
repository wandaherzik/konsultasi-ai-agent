<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasi_ai', function (Blueprint $table) {

            $table->string('id_konsultasi_ai',20)->primary();

            $table->string('id_pasien',20);

            $table->uuid('session_id')->unique();

            $table->longText('keluhan_pasien');

            $table->string('diagnosa_awal',255)->nullable();

            $table->string('saran_poli',100)->nullable();

            $table->integer('skor_urgensi')->nullable();

            $table->longText('respon_ai')->nullable();

            $table->enum('status_konsultasi',[
                'selesai',
                'batal'
            ])->default('selesai');

            $table->timestamps();

            $table->foreign('id_pasien')
                    ->references('id_pasien')
                    ->on('pasien')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi_ai');
    }
};