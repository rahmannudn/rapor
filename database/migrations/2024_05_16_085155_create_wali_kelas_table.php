<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wali_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained(table: 'kelas');
            $table->foreignId('user_id')->constrained(table: 'users');
            $table->foreignId('tahun_ajaran_id')->constrained(table: 'tahun_ajaran')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wali_kelas', function (Blueprint $table) {
            $table->dropSoftDeletes();
            Schema::dropIfExists('wali_kelas');
        });
    }
};
