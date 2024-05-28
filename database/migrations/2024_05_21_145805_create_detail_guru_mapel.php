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
        Schema::create('detail_guru_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_mapel_id')->constrained(table: 'guru_mapel');
            $table->foreignId('mapel_id')->constrained(table: 'mapel');
            $table->foreignId('kelas_id')->constrained(table: 'kelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_guru_mapel');
    }
};
