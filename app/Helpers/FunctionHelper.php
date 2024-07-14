<?php

namespace App\Helpers;

use App\Models\TahunAjaran;

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
}
