<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konsultasi_ai', function (Blueprint $table) {

            $table->string('diagnosa_awal')
                ->nullable()
                ->change();

            $table->string('saran_poli')
                ->nullable()
                ->change();

            $table->integer('skor_urgensi')
                ->nullable()
                ->change();

            $table->text('respon_ai')
                ->nullable()
                ->change();

        });
    }

    public function down(): void
    {
        Schema::table('konsultasi_ai', function (Blueprint $table) {

            $table->string('diagnosa_awal')
                ->nullable(false)
                ->change();

            $table->string('saran_poli')
                ->nullable(false)
                ->change();

            $table->integer('skor_urgensi')
                ->nullable(false)
                ->change();

            $table->text('respon_ai')
                ->nullable(false)
                ->change();

        });
    }
};