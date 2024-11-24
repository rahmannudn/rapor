<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Ekskul;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Kepsek;
use App\Models\NilaiEkskul;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Cache;

class RaporIntraController extends Controller
{
    public $tahunAjaranAktif = '';
    public $dataSekolah = '';

    public function __construct(Siswa $siswa)
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $this->dataSekolah = Sekolah::find(1)->toArray();
    }

    public function cetakSampul(Siswa $siswa, KelasSiswa $kelasSiswa)
    {
        $results = [];

        $results['kepsek'] = $this->getKepsekData($kelasSiswa);
        $results['siswa'] = $siswa;
        $results['sekolah'] = $this->dataSekolah;

        return view('template-sampul', ['results' => $results]);
    }

    public function cetakRapor(Siswa $siswa, KelasSiswa $kelasSiswa)
    {
        $results = [];

        $data = TahunAjaran::where('tahun_ajaran.id', $kelasSiswa['tahun_ajaran_id'])
            ->join('wali_kelas', function (JoinClause $q) use ($kelasSiswa) {
                $q->on('wali_kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
                    ->where('wali_kelas.kelas_id', '=', $kelasSiswa['kelas_id']);
            })
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->join('users', 'users.id', 'wali_kelas.user_id')
            ->select(
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
                'kelas.nama as nama_kelas',
                'kelas.fase',
                'users.name as nama_wali',
                'users.nip as nip_wali'
            )
            ->first();

        if (!$data) $this->redirectBack('data tidak ditemukan');

        $absensi = Absensi::where('kelas_siswa_id', $kelasSiswa['id'])
            ->select('sakit', 'izin', 'alfa')
            ->first();

        if (!$absensi) $this->redirectBack('Data absensi siswa ini belum disii');


        $ekskul = NilaiEkskul::where('nilai_ekskul.kelas_siswa_id', $kelasSiswa['id'])
            ->join('ekskul', 'ekskul.id', 'nilai_ekskul.ekskul_id')
            ->select('nilai_ekskul.deskripsi', 'ekskul.nama_ekskul')
            ->get();

        if (!$ekskul) $this->redirectBack('Data ekskul siswa ini belum disii');

        $results['kepsek'] = $this->getKepsekData($kelasSiswa);
        $results['nama_siswa'] = $siswa['nama'];
        $results['nisn'] = $siswa['nisn'];
        $results['sekolah'] = $this->dataSekolah;
    }

    public function redirectBack($message)
    {
        session()->flash('gagal', $message);
        $this->redirectRoute('raporIntraIndex');
        return;
    }

    public function getKepsekData(KelasSiswa $kelasSiswa)
    {
        $result = TahunAjaran::where('tahun_ajaran.id', $kelasSiswa['tahun_ajaran_id'])
            ->join('kepsek', 'kepsek.id', 'tahun_ajaran.kepsek_id')
            ->join('users', 'users.id', 'kepsek.user_id')
            ->select('users.name as nama_kepsek', 'users.nip as nip_kepsek', 'tahun_ajaran.tgl_rapor')
            ->first()
            ->toArray();

        return $result;
    }
}
