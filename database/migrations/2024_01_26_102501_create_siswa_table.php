<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 10)->unique();
            $table->string('nidn', 10)->unique();
            $table->string('nama', 80);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jk', ['l', 'p']);
            $table->enum('agama', ['islam', 'kristen protestan', 'kristen katolik', 'hindu', 'buddha', 'konghucu']);
            $table->text('alamat');
            $table->string('kelurahan', 80);
            $table->string('kecamatan', 80);
            $table->string('kota', 80);
            $table->string('provinsi', 80);
            $table->string('nama_ayah', 80)->nullable();
            $table->string('pekerjaan_ayah', 80)->nullable();
            $table->string('nama_ibu', 80);
            $table->string('pekerjaan_ibu', 80)->nullable();
            $table->string('hp_ortu', 13);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
