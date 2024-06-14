<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';
    protected $guarded = ['id', 'created_at'];
    protected $primaryKey = 'id';

    public function scopeSearch($query, $value)
    {
        $query->where('tahun', 'like', "%{$value}%")->orWhere('semester', 'like', "%{$value}%");
    }

    public static function concatTahunAjaran($tahunAwal, $tahunAkhir)
    {
        return "$tahunAwal / $tahunAkhir";
    }

    public static function getTahunAwal($data)
    {
        // mendapatkan 4 karater pertama dari tahun (2024)
        return substr($data, 0, 4);
    }

    public static function getTahunAkhir($data)
    {
        // mendapatkan 4 karater pertama dari tahun (2025)
        return substr($data, 7);
    }

    public function waliKelas()
    {
        return $this->hasMany(WaliKelas::class);
    }

    public function kepsek()
    {
        return $this->hasMany(Kepsek::class);
    }
}
