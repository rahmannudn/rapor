<?php

namespace App\Helpers;

use App\Models\Kelas;
use App\Models\Proyek;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Cache;

class FunctionHelper
{
    public static function getDynamicYear()
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

    public static function getTahunAjaranAktif()
    {
        return TahunAjaran::select('id')->where('aktif', 1)->first();
    }

    public static function getDaftarKelasHasProyek($taid)
    {
        return Kelas::query()
            ->joinWaliKelas($taid)
            ->joinProyek()
            ->select('kelas.id', 'kelas.nama')
            ->distinct()
            ->get();
    }

    public static function getKelasInfo($waliKelasId)
    {
        return Proyek::joinWaliKelas()
            ->where('wali_kelas.id', '=', $waliKelasId)
            ->joinKelasByWaliKelas()
            ->joinTahunByWaliKelas()
            ->select(
                'kelas.fase',
                'kelas.nama as nama_kelas',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
            )
            ->first();
    }

    public static function setCacheTahunAjaran()
    {
        Cache::forget('tahunAjaranAktif');
        Cache::remember('tahunAjaranAktif', 60 * 10, function () {
            return TahunAjaran::where('aktif', 1)->first()['id'];
        });
    }
}
