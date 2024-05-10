<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';
    protected $guarded = ['id', 'created_at'];

    public function scopeSearch($query, $value)
    {
        $query->where('tahun', 'like', "%{$value}%")->orWhere('semester', 'like', "%{$value}%");
    }

    public static function concatTahunAjaran($tahunAwal, $tahunAkhir)
    {
        return "$tahunAwal / $tahunAkhir";
    }

    public static function getYears()
    {
        $years = [];
        // mengambil data tahun sekarang
        $currentYear = date('Y');

        // nilai variabel $currentYear akan ditambah nilai index kemudian dikurang 1
        // expression di loop sebanyak 3 kali, hasilnya dimasukkan ke array $years
        // contoh : $currentYear = 2024, $years = [2023,2024,2025]
        for ($i = 0; $i <= 3; $i++) {
            $years[] = ($currentYear + $i) - 1;
        }

        return $years;
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
}
