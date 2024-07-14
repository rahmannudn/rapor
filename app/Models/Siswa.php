<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $guarded = ['id', 'created_at'];

    public function scopeSearch($query, $value)
    {
        $query->where('siswa.nama', 'like', "%{$value}%")->orWhere('siswa.nisn', 'like', "%{$value}%");
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun', 'tahun_lulus');
    }
}
