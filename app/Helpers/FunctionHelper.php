<?php

namespace App\Helpers;

use App\Models\Kelas;
use App\Models\Kepsek;
use App\Models\Proyek;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;
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
        return Cache::get('tahunAjaranAktif');
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
        Cache::remember('tahunAjaranAktif', now()->addMinutes(15), function () {
            return TahunAjaran::where('aktif', 1)->first()['id'];
        });
    }

    public static function setCacheKepsekAktif()
    {
        // $kepsekAktif = Kepsek::where('aktif', 1)->select('user_id')->first()->toArray();
        // return auth()->id() === $kepsekAktif['user_id'];
        Cache::forget('kepsekAktif');
        $kepsekAktif = Kepsek::where('aktif', 1)->select('user_id')->first()->toArray();
        Cache::put('kepsekAktif', $kepsekAktif['user_id'], now()->addDays(1));
    }

    public static function setCacheInfoSekolah()
    {
        Cache::forget('logo_sekolah');
        Cache::forget('nama_sekolah');
        Cache::forget('semester');

        $sekolah = Sekolah::select('logo_sekolah', 'nama_sekolah')->get()->toArray()[0];
        Cache::put('logo_sekolah', $sekolah['logo_sekolah'], now()->addDays(1));
        Cache::put('nama_sekolah', $sekolah['nama_sekolah'], now()->addDays(1));

        $semester = TahunAjaran::where('aktif', '=', 1)->select('tahun', 'semester')->first();
        Cache::put('semester', $semester['tahun'] . ' - ' . ucfirst($semester['semester']), now()->addDays(1));
    }
}
