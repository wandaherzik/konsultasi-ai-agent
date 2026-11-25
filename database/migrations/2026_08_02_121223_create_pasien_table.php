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
        Schema::create('pasien', function (Blueprint $table) {

            // Primary Key
            $table->string('id_pasien',20)->primary();

            // Foreign Key
            $table->string('id_user',20);

            // Biodata
            $table->string('nama_pasien',100);

            $table->string('nik',16)->unique();

            $table->string('jenis_kelamin',100);

            $table->date('tanggal_lahir');

            $table->string('no_bpjs',25)->nullable();

            $table->text('alamat');

            $table->string('no_telepon',15);

            $table->timestamps();

            // Foreign Key
            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

        });
    }

    /**
     * Rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};