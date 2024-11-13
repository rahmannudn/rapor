<?php

namespace App\Http\Controllers;

use App\Models\KelasSiswa;
use App\Models\Kepsek;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RaporIntraController extends Controller
{
    public function cetakSampul(Siswa $siswa, KelasSiswa $kelasSiswa)
    {
        $results = [];

        $kepsek = TahunAjaran::where('tahun_ajaran.id', $kelasSiswa['tahun_ajaran_id'])
            ->join('kepsek', 'kepsek.id', 'tahun_ajaran.kepsek_id')
            ->join('users', 'users.id', 'kepsek.user_id')
            ->select('users.name as nama_kepsek', 'users.nip as nip_kepsek', 'tahun_ajaran.tgl_rapor')
            ->first()->toArray();

        $dataSekolah = Sekolah::find(1)->toArray();

        $results['kepsek'] = $kepsek;
        $results['siswa'] = $siswa;
        $results['sekolah'] = $dataSekolah;

        return view('template-sampul', ['results' => $results]);
    }

    public function cetakRapor(Siswa $siswa, KelasSiswa $kelasSiswa) {}
}
