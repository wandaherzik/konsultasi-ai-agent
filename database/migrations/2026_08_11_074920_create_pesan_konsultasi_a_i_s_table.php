<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesan_konsultasi_ai', function (Blueprint $table) {

            $table->id();

            $table->string('id_konsultasi_ai', 20);

            $table->enum('pengirim', [
                'pasien',
                'ai',
            ]);

            $table->longText('pesan');

            $table->timestamps();

            $table->foreign('id_konsultasi_ai')
                ->references('id_konsultasi_ai')
                ->on('konsultasi_ai')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_konsultasi_ai');
    }
};