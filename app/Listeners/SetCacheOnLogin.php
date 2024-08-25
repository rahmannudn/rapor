<?php

namespace App\Listeners;

use App\Models\Kepsek;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetCacheOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $this->setAllCaches();
    }

    public static function setAllCaches()
    {
        self::setCacheInfoSekolah();
        self::setCacheInfoSekolah();
    }

    public static function setCacheTahunAjaran()
    {
        Cache::forget('tahunAjaranAktif');
        Cache::remember('tahunAjaranAktif', now()->addHours(2), function () {
            return TahunAjaran::where('aktif', 1)->first()['id'];
        });
    }

    public static function setCacheInfoSekolah()
    {
        Cache::forget('logo_sekolah');
        Cache::forget('nama_sekolah');
        Cache::forget('semester');

        $sekolah = Sekolah::select('logo_sekolah', 'nama_sekolah')->get()->toArray()[0];
        Cache::put('logo_sekolah', $sekolah['logo_sekolah'], now()->addHours(2));
        Cache::put('nama_sekolah', $sekolah['nama_sekolah'], now()->addHours(2));

        $semester = TahunAjaran::where('aktif', '=', 1)->select('tahun', 'semester')->first();
        Cache::put('semester', $semester['tahun'] . ' - ' . ucfirst($semester['semester']), now()->addHours(2));
    }
}
