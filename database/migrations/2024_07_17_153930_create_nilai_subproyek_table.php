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
        Schema::create('nilai_subproyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subproyek_id')->constrained('subproyek');
            $table->foreignId('kelas_siswa_id')->constrained('kelas_siswa');
            $table->enum('nilai', ['bb', 'mb', 'bsh', 'sb']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_subproyek');
    }
};
