<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;
    protected $table = 'prestasi';
    protected $guarded = ['id'];

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('prestasi.nama_prestasi', 'like', "%{$value}%")
                ->orWhere('prestasi.penyelenggara', 'like', "%{$value}%")
                ->orWhere('prestasi.deskripsi', 'like', "%{$value}%")
                ->orWhereHas('siswa', function ($q) use ($value) {
                    $q->where('nama', 'like', "%{$value}%")
                        ->orWhere('nisn', 'like', "%{$value}%");
                });
        });
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
