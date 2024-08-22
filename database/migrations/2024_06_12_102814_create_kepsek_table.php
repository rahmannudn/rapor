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
        Schema::create('kepsek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('awal_menjabat')->nullable()->constrained(table: 'tahun_ajaran');
            $table->foreignId('akhir_menjabat')->nullable()->constrained(table: 'tahun_ajaran');
            $table->foreignId('user_id')->constrained(table: 'users');
            $table->boolean('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepsek');
    }
};
