<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\DetailGuruMapel;
use App\Models\Ekskul;
use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Kepsek;
use App\Models\NilaiEkskul;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RaporIntraController extends Controller
{
    public $tahunAjaranAktif = '';
    public $dataSekolah = '';

    public function __construct(Siswa $siswa)
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $this->dataSekolah = Sekolah::find(1);
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
        try {
            $results = [
                'kepsek' => $this->getKepsekData($kelasSiswa),
                'nama_siswa' => $siswa['nama'],
                'nisn' => $siswa['nisn'],
                'sekolah' => $this->dataSekolah,
            ];

            $dataNilai = $this->getNilaiData($kelasSiswa);

            $results['tahun_ajaran'] = $this->getTahunAjaranData($kelasSiswa);
            $results['ekskul'] = $this->getEkskulData($kelasSiswa['id']);
            $results['absensi'] = $this->getAbsensiData($kelasSiswa['id']);
            $results['nilai_mapel'] = $this->processNilaiData($dataNilai, $siswa['nama']);

            return view('template-rapor-intra', ['results' => $results]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('gagal', 'Data tidak ditemukan');
        }
    }

    public function redirectBack($message)
    {
        return redirect()->back()->with('gagal', $message);
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

    private function getTahunAjaranData($kelasSiswa)
    {
        return TahunAjaran::where('tahun_ajaran.id', $kelasSiswa['tahun_ajaran_id'])
            ->join('wali_kelas', function ($q) use ($kelasSiswa) {
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
            ->firstOrFail();
    }

    private function getAbsensiData($kelasSiswaId)
    {
        return Absensi::where('kelas_siswa_id', $kelasSiswaId)
            ->select('sakit', 'izin', 'alfa')
            ->firstOrFail();
    }

    private function getEkskulData($kelasSiswaId)
    {
        return NilaiEkskul::where('nilai_ekskul.kelas_siswa_id', $kelasSiswaId)
            ->join('ekskul', 'ekskul.id', 'nilai_ekskul.ekskul_id')
            ->select('nilai_ekskul.deskripsi', 'ekskul.nama_ekskul')
            ->get();
    }

    private function getNilaiData($kelasSiswa)
    {
        return GuruMapel::where('guru_mapel.tahun_ajaran_id', $kelasSiswa['tahun_ajaran_id'])
            ->join('detail_guru_mapel', function ($q) use ($kelasSiswa) {
                $q->on('detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id')
                    ->where('detail_guru_mapel.kelas_id', '=', $kelasSiswa['kelas_id']);
            })
            ->join('mapel', 'mapel.id', 'detail_guru_mapel.mapel_id')
            ->join('nilai_sumatif', function ($q) use ($kelasSiswa) {
                $q->on('nilai_sumatif.detail_guru_mapel_id', '=', 'detail_guru_mapel.id')
                    ->where('nilai_sumatif.kelas_siswa_id', '=', $kelasSiswa['id']);
            })
            ->join('nilai_sumatif_akhir', function ($q) use ($kelasSiswa) {
                $q->on('nilai_sumatif_akhir.detail_guru_mapel_id', 'detail_guru_mapel.id')
                    ->where('nilai_sumatif_akhir.kelas_siswa_id', '=', $kelasSiswa['id']);
            })
            ->join('nilai_formatif', function ($q) use ($kelasSiswa) {
                $q->on('nilai_formatif.detail_guru_mapel_id', 'detail_guru_mapel.id')
                    ->where('nilai_formatif.kelas_siswa_id', '=', $kelasSiswa['id']);
            })
            ->join('tujuan_pembelajaran', 'tujuan_pembelajaran.id', 'nilai_formatif.tujuan_pembelajaran_id')
            ->select(
                'mapel.id as mapel_id',
                'mapel.nama_mapel',
                'nilai_sumatif.id as nilai_sumatif_id',
                'nilai_sumatif.nilai as nilai_sumatif',
                'nilai_sumatif_akhir.nilai_nontes',
                'nilai_sumatif_akhir.nilai_tes',
                'nilai_formatif.id as nilai_formatif_id',
                'nilai_formatif.kktp',
                'nilai_formatif.tampil',
                'tujuan_pembelajaran.deskripsi as tp_deskripsi'
            )
            ->get();
    }

    private function processNilaiData($dataNilai, $namaSiswa)
    {
        return $dataNilai->groupBy('mapel_id')->map(function ($nilai, $mapelId) use ($namaSiswa) {
            $sumatif = [
                'mapel_id' => $nilai->first()['mapel_id'],
                'nama_mapel' => $nilai->first()['nama_mapel'],
                'total_nilai' => 0,
                'jumlah_sumatif' => 0,
            ];

            $deskripsiTertinggi = [];
            $deskripsiTerendah = [];

            $nilai->each(function ($mapel) use (&$sumatif, &$deskripsiTertinggi, &$deskripsiTerendah) {
                if (!isset($sumatifIds[$mapel['nilai_sumatif_id']])) {
                    $sumatifIds[$mapel['nilai_sumatif_id']] = true;
                    $sumatif['total_nilai'] += $mapel['nilai_sumatif'];
                    $sumatif['jumlah_sumatif']++;
                }

                if ($mapel['tampil'] === 1) {
                    if ($mapel['kktp'] === 1) $deskripsiTertinggi[] = $mapel['tp_deskripsi'];
                    if ($mapel['kktp'] === 0) $deskripsiTerendah[] = $mapel['tp_deskripsi'];
                }
            });

            $lastMapel = $nilai->last();
            if ((int)$lastMapel['nilai_tes'] !== 0) {
                $sumatif['total_nilai'] += (int)$lastMapel['nilai_tes'];
                $sumatif['jumlah_sumatif']++;
            }
            if ((int)$lastMapel['nilai_nontes'] !== 0) {
                $sumatif['total_nilai'] += (int)$lastMapel['nilai_nontes'];
                $sumatif['jumlah_sumatif']++;
            }

            $sumatif['rata_nilai'] = $sumatif['jumlah_sumatif'] > 0 ? $sumatif['total_nilai'] / $sumatif['jumlah_sumatif'] : 0;
            $sumatif['deskripsi_tertinggi'] = "{$namaSiswa} menunjukkan pemahaman dalam " . implode(', ', $deskripsiTertinggi) . '.';
            $sumatif['deskripsi_terendah'] = "{$namaSiswa} membutuhkan bimbingan dalam " . implode(', ', $deskripsiTerendah) . '.';

            return $sumatif;
        });
    }
}
