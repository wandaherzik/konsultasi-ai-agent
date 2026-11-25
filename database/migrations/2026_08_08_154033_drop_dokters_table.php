<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('dokters');
    }

    public function down(): void
    {
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};