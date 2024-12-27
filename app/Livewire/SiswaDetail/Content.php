<?php

namespace App\Livewire\SiswaDetail;

use App\Charts\NilaiSiswaPerSemester;
use Livewire\Component;
use App\Models\Prestasi;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Content extends Component
{
    public Siswa $siswa;
    public $riwayatKelasProyek;
    public $riwayatKelasSiswa;
    public $dataPrestasi;
    public $dataNilai;
    public $rataRataSeluruhNilai;

    public function mount()
    {
        $this->getRiwayatProyek();
        $this->getNilaiSiswa();
        $this->rataRataSeluruhNilai = $this->getNilaiSiswa();

        $this->dataPrestasi = Prestasi::where('siswa_id', $this->siswa['id'])->get();
    }

    public function render()
    {
        return view('livewire.siswa-detail.content');
    }

    public function getRiwayatProyek()
    {
        if (Gate::allows('isKepsek')) {
            $proyekData = KelasSiswa::where('kelas_siswa.siswa_id', $this->siswa['id'])
                ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
                ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas.id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', 'kelas_siswa.tahun_ajaran_id')
                ->join('users', 'users.id', 'wali_kelas.user_id')
                ->join('proyek', 'proyek.wali_kelas_id', 'wali_kelas.id')
                ->leftJoin('catatan_proyek', function (JoinClause $q) {
                    $q->on('catatan_proyek.proyek_id', '=', 'proyek.id')
                        ->on('catatan_proyek.siswa_id', '=', 'kelas_siswa.siswa_id');
                })
                ->select(
                    'kelas_siswa.siswa_id as siswa_id',
                    'kelas_siswa.id as kelas_siswa_id',
                    'kelas.nama as nama_kelas',
                    'users.name as nama_wali_kelas',
                    'tahun_ajaran.id as tahun_ajaran_id',
                    'tahun_ajaran.tahun',
                    'tahun_ajaran.semester',
                    'proyek.id as proyek_id',
                    'proyek.judul_proyek',
                    'proyek.deskripsi as deskripsi_proyek',
                    'catatan_proyek.id as catatan_proyek_id',
                    'catatan_proyek.catatan',
                )
                ->orderBy('kelas.nama')
                ->orderBy('tahun_ajaran.id')
                ->get()
                ->toArray();
        }

        if (Gate::allows('isGuru')) {
            $proyekData = KelasSiswa::where('kelas_siswa.siswa_id', $this->siswa['id'])
                ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
                ->join('wali_kelas', function (JoinClause $q) {
                    $q->on('wali_kelas.kelas_id', '=', 'kelas.id')
                        ->where('wali_kelas.user_id', '=', Auth::id());
                })
                ->join('tahun_ajaran', 'tahun_ajaran.id', 'kelas_siswa.tahun_ajaran_id')
                ->join('users', 'users.id', 'wali_kelas.user_id')
                ->join('proyek', 'proyek.wali_kelas_id', 'wali_kelas.id')
                ->leftJoin('catatan_proyek', function (JoinClause $q) {
                    $q->on('catatan_proyek.proyek_id', '=', 'proyek.id')
                        ->on('catatan_proyek.siswa_id', '=', 'kelas_siswa.siswa_id');
                })
                ->select(
                    'kelas_siswa.siswa_id as siswa_id',
                    'kelas_siswa.id as kelas_siswa_id',
                    'kelas.nama as nama_kelas',
                    'users.name as nama_wali_kelas',
                    'tahun_ajaran.id as tahun_ajaran_id',
                    'tahun_ajaran.tahun',
                    'tahun_ajaran.semester',
                    'proyek.id as proyek_id',
                    'proyek.judul_proyek',
                    'proyek.deskripsi as deskripsi_proyek',
                    'catatan_proyek.id as catatan_proyek_id',
                    'catatan_proyek.catatan',
                )
                ->orderBy('kelas.nama')
                ->orderBy('tahun_ajaran.id')
                ->get()
                ->toArray();
        }

        return $this->formatRiwayatData($proyekData);
    }

    function formatRiwayatData($data)
    {
        $riwayatProyek = [];
        $groupedData = [];
        $kelasSiswa = [];

        // Group data by tahun_ajaran_id
        foreach ($data as $item) {
            $tahunAjaranId = $item['tahun_ajaran_id'];
            if (!isset($groupedData[$tahunAjaranId])) {
                $groupedData[$tahunAjaranId] = [
                    'kelas_siswa_id' => $item['kelas_siswa_id'],
                    'nama_kelas' => $item['nama_kelas'],
                    'nama_wali_kelas' => $item['nama_wali_kelas'],
                    'tahun_ajaran_id' => $item['tahun_ajaran_id'],
                    'tahun' => $item['tahun'],
                    'semester' => $item['semester'],
                    'proyekData' => []
                ];

                $kelasSiswa[$tahunAjaranId] = [
                    'id' => $item['kelas_siswa_id'],
                    'nama_kelas' => $item['nama_kelas'],
                    'tahun' => $item['tahun'],
                    'semester' => $item['semester'],
                    'tahun_ajaran_id' => $item['tahun_ajaran_id'],
                ];
            }

            // Add project data to the group
            $groupedData[$tahunAjaranId]['proyekData'][] = [
                'proyek_id' => $item['proyek_id'],
                'judul_proyek' => $item['judul_proyek'],
                'deskripsi_proyek' => $item['deskripsi_proyek'] ?? '',
                'catatan_proyek_id' => $item['catatan_proyek_id'] ?? '',
                'catatan' => $item['catatan'] ?? '',
            ];
        }

        // Convert grouped data to the desired output format
        foreach ($groupedData as $group) {
            $riwayatProyek[] = $group;
        }

        $this->riwayatKelasProyek = $riwayatProyek;
        $this->riwayatKelasSiswa = $kelasSiswa;
    }

    public function getNilaiSiswa()
    {
        $data = KelasSiswa::where('kelas_siswa.siswa_id', $this->siswa['id'])
            ->join('nilai_sumatif', 'nilai_sumatif.kelas_siswa_id', 'kelas_siswa.id')
            ->join('detail_guru_mapel', 'detail_guru_mapel.id', 'nilai_sumatif.detail_guru_mapel_id')
            ->leftJoin('nilai_sumatif_akhir', function (JoinClause $q) {
                $q->on('nilai_sumatif_akhir.kelas_siswa_id', '=', 'kelas_siswa.id')
                    ->on('nilai_sumatif_akhir.detail_guru_mapel_id', '=', 'detail_guru_mapel.id');
            })
            ->join('mapel', 'mapel.id', 'detail_guru_mapel.mapel_id')
            ->join('kelas',  function (JoinClause $q) {
                $q->on('kelas.id', '=', 'detail_guru_mapel.kelas_id')
                    ->on('kelas.id', '=', 'kelas_siswa.kelas_id');
            })
            ->join('tahun_ajaran', 'tahun_ajaran.id',  'kelas_siswa.tahun_ajaran_id')
            ->select(
                'kelas_siswa.id as kelas_siswa_id',
                'kelas_siswa.tahun_ajaran_id as tahun_ajaran_id',
                'kelas.kelas as tingkat_kelas',
                'nilai_sumatif.id as nilai_sumatif_id',
                'nilai_sumatif.nilai',
                'nilai_sumatif_akhir.nilai_tes',
                'nilai_sumatif_akhir.nilai_nontes',
                'mapel.id as mapel_id',
                'mapel.nama_mapel',
                'tahun_ajaran.semester',
            )
            ->get()
            ->groupBy('kelas_siswa_id')
            ->toArray();

        return array_values($this->formatNilaiSiswa($data));
    }

    public function formatNilaiSiswa($data)
    {
        $result = [];

        foreach ($data as $kelasSiswaId => $items) {
            $tahunAjaranData = [
                "kelas_siswa_id" => $kelasSiswaId,
                "tahun_ajaran_id" => $items[0]['tahun_ajaran_id'],
                "tingkat_kelas" => $items[0]['tingkat_kelas'] . " " . $items[0]['semester'],
                "total_nilai" => 0,
                "jumlah_nilai" => 0,
                "rata_nilai" => 0,
                "mapel" => [],
            ];

            $groupedByMapel = [];

            foreach ($items as $item) {
                $mapelId = $item['mapel_id'];
                $namaMapel = $item['nama_mapel'];

                if (!isset($groupedByMapel[$mapelId])) {
                    $groupedByMapel[$mapelId] = [
                        "mapel_id" => $mapelId,
                        "nama_mapel" => $namaMapel,
                        "total_nilai" => 0,
                        "jumlah_nilai" => 0,
                        "nilai_tes" => null,
                        "nilai_nontes" => null,
                        "rata_nilai" => 0,
                    ];
                }

                // Tambahkan nilai sumatif ke total_nilai
                $groupedByMapel[$mapelId]['total_nilai'] += (int) $item['nilai'];
                $groupedByMapel[$mapelId]['jumlah_nilai']++;

                // Tambahkan nilai tes dan nontes (jika belum ada)
                if ($item['nilai_tes'] !== null && $groupedByMapel[$mapelId]['nilai_tes'] === null) {
                    $groupedByMapel[$mapelId]['total_nilai'] += (int) $item['nilai_tes'];
                    $groupedByMapel[$mapelId]['jumlah_nilai']++;
                    $groupedByMapel[$mapelId]['nilai_tes'] = $item['nilai_tes'];
                }

                if ($item['nilai_nontes'] !== null && $groupedByMapel[$mapelId]['nilai_nontes'] === null) {
                    $groupedByMapel[$mapelId]['total_nilai'] += (int) $item['nilai_nontes'];
                    $groupedByMapel[$mapelId]['jumlah_nilai']++;
                    $groupedByMapel[$mapelId]['nilai_nontes'] = $item['nilai_nontes'];
                }
            }

            // Hitung rata-rata setiap mapel
            foreach ($groupedByMapel as $mapelId => &$mapelData) {
                $mapelData['rata_nilai'] = round($mapelData['total_nilai'] / $mapelData['jumlah_nilai'], 1);

                // Tambahkan nilai mapel ke tahun ajaran
                $tahunAjaranData['total_nilai'] += $mapelData['total_nilai'];
                $tahunAjaranData['jumlah_nilai'] += $mapelData['jumlah_nilai'];
                $tahunAjaranData['mapel'][] = $mapelData;
            }

            // Hitung rata-rata keseluruhan untuk tahun ajaran
            $tahunAjaranData['rata_nilai'] = round($tahunAjaranData['total_nilai'] / $tahunAjaranData['jumlah_nilai'], 1);

            $result[] = $tahunAjaranData;
        }
        return $result;
    }
}
