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

class RaporIntraController extends Controller
{
    public $tahunAjaranAktif = '';
    public $dataSekolah = '';

    public function __construct(Siswa $siswa)
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $this->dataSekolah = Sekolah::find(1)->makeHidden(['created_at', 'updated_at', 'id'])->toArray();
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

        if (is_null($data))
            return redirect()->route('raporIntraIndex')->with('gagal', 'Data tidak ditemukan');

        $absensi = Absensi::where('kelas_siswa_id', $kelasSiswa['id'])
            ->select('sakit', 'izin', 'alfa')
            ->first();

        if (is_null($absensi))
            return redirect()->route('raporIntraIndex')->with('gagal', 'Data absensi siswa ini belum disii');

        $ekskul = NilaiEkskul::where('nilai_ekskul.kelas_siswa_id', $kelasSiswa['id'])
            ->join('ekskul', 'ekskul.id', 'nilai_ekskul.ekskul_id')
            ->select('nilai_ekskul.deskripsi', 'ekskul.nama_ekskul')
            ->get();

        if (is_null($ekskul))
            return redirect()->route('raporIntraIndex')->with('gagal', 'Data ekskul siswa ini belum disii');

        $dataNilai = GuruMapel::where('guru_mapel.tahun_ajaran_id', $kelasSiswa['tahun_ajaran_id'])
            ->join('detail_guru_mapel', function (JoinClause $q) use ($kelasSiswa) {
                $q->on('detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id')
                    ->where('detail_guru_mapel.kelas_id', '=', $kelasSiswa['kelas_id']);
            })
            ->join('mapel', 'mapel.id', 'detail_guru_mapel.mapel_id')
            ->join('nilai_sumatif', function (JoinClause $q) use ($kelasSiswa) {
                $q->on('nilai_sumatif.detail_guru_mapel_id', '=', 'detail_guru_mapel.id')
                    ->where('nilai_sumatif.kelas_siswa_id', '=', $kelasSiswa['id']);
            })
            ->join('nilai_sumatif_akhir', function (JoinClause $q) use ($kelasSiswa) {
                $q->on('nilai_sumatif_akhir.detail_guru_mapel_id', 'detail_guru_mapel.id')
                    ->where('nilai_sumatif_akhir.kelas_siswa_id', '=', $kelasSiswa['id']);
            })
            ->join('nilai_formatif', function (JoinClause $q) use ($kelasSiswa) {
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
                'tujuan_pembelajaran.deskripsi as tp_deskripsi',
            )
            ->get();

        $groupedNilai = $dataNilai->groupBy('mapel_id')->toArray();
        $result  = [];
        foreach ($groupedNilai as $i => $nilai) {
            $dataMapel  = [];
            $sumatif = [];
            $formatif = [];
            $deskripsiTertinggi = [];
            $deskripsiTerendah = [];
            // menyimpan id data yang sudah di input
            $sumatifIds = [];
            $formatifIds = [];
            foreach ($nilai as $mapelIndex => $mapel) {
                $sumatif[$mapelIndex] = [
                    'mapel_id' => $mapel['mapel_id'],
                    'nama_mapel' => $mapel['nama_mapel'],
                ];

                if (!isset($sumatif[$mapelIndex]['total_nilai'])) $sumatif[$mapelIndex]['total_nilai'] = 0;
                if (!isset($sumatif[$mapelIndex]['rata_nilai'])) $sumatif[$mapelIndex]['rata_nilai'] = 0;
                if (!isset($sumatif[$mapelIndex]['jumlah_sumatif'])) $sumatif[$mapelIndex]['jumlah_sumatif'] = 0;

                $sumatifId = $mapel['nilai_sumatif_id'];
                $formatifId = $mapel['nilai_formatif_id'];

                // mengecek apakah id sudah ada di array tersebut, jika ada maka nilai ditambahkan ke property total nilai
                if (!isset($sumatifIds[$mapelIndex][$sumatifId])) {
                    $sumatifIds[$mapelIndex][$sumatifId][] = $sumatifId;
                    $sumatif[$mapelIndex]['total_nilai'] += $mapel['nilai_sumatif'];
                    $sumatif[$mapelIndex]['jumlah_sumatif']++;
                }

                if (!isset($formatifIds[$mapelIndex][$formatifId])) {
                    $formatifIds[$mapelIndex][$formatifId][] = $formatifId;
                    if ($mapel['tampil'] === 1) {
                        if ($mapel['kktp'] === 1) array_push($deskripsiTertinggi, $mapel['tp_deskripsi']);
                        if ($mapel['kktp'] === 0) array_push($deskripsiTerendah, $mapel['tp_deskripsi']);
                    }
                }

                // jika loop sudah di index terakhir atau loop terakhir
                if ($mapelIndex === count($nilai) - 1) {
                    if ((int)$mapel['nilai_tes'] !== 0) {
                        $sumatif[$mapelIndex]['total_nilai'] += (int)$mapel['nilai_tes'];
                        $sumatif[$mapelIndex]['jumlah_sumatif']++;
                    }
                    if ((int)$mapel['nilai_nontes'] !== 0) {
                        $sumatif[$mapelIndex]['total_nilai'] += (int)$mapel['nilai_nontes'];
                        $sumatif[$mapelIndex]['jumlah_sumatif']++;
                    }
                    $sumatif[$mapelIndex]['rata_nilai'] = (int)$sumatif[$mapelIndex]['total_nilai'] / $sumatif[$mapelIndex]['jumlah_sumatif'];

                    $dataMapel[$i] = $sumatif[$mapelIndex];

                    $dataMapel[$i]['deskripsi_tertinggi'] = "{$siswa['nama']} menunjukkan pemahaman dalam " . implode(', ', $deskripsiTertinggi) . '.';
                    $dataMapel[$i]['deskripsi_terendah'] = "{$siswa['nama']} membutuhkan bimbingan dalam " . implode(', ', $deskripsiTerendah) . '.';
                    $dataMapel[$i]['total_nilai'] = $sumatif[$mapelIndex]['total_nilai'];
                    $dataMapel[$i]['rata_nilai'] = $sumatif[$mapelIndex]['rata_nilai'];
                    $dataMapel[$i]['jumlah_sumatif'] = $sumatif[$mapelIndex]['jumlah_sumatif'];
                    $result[$i] = $dataMapel[$i];
                }
            }
        }

        $results['kepsek'] = $this->getKepsekData($kelasSiswa);
        $results['nama_siswa'] = $siswa['nama'];
        $results['nisn'] = $siswa['nisn'];
        $results['sekolah'] = $this->dataSekolah;
        $results['nilai_mapel'] = $result;
        dd($results);
    }

    public function redirectBack($message)
    {
        return redirect()->route('raporIntraIndex')->with('gagal', $message);
        // redirect()->route('raporIntraIndex')->with('gagal', $message);
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
