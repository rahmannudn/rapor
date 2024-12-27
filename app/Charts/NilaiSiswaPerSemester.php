<?php

namespace App\Charts;

use App\Models\KelasSiswa;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Database\Query\JoinClause;

class NilaiSiswaPerSemester
{
    protected $chart;
    protected $dataNilai;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Ambil data rata-rata nilai dan tingkat kelas
        $labels = array_map(fn($item) => $item['tingkat_kelas'], $this->dataNilai);
        $series = array_map(fn($item) => $item['rata_nilai'], $this->dataNilai);

        return $this->chart->barChart()
            ->setTitle('Rata-rata Nilai Persemester')
            ->setXAxis($labels)
            ->setDataset([
                [
                    'name' => 'Rata-rata Nilai',
                    'data' => $series,
                ]
            ])
            ->setGrid(true)
            ->setHeight(400);
    }

    public function getNilaiSiswa($siswa)
    {
        $data = KelasSiswa::where('kelas_siswa.siswa_id', $siswa['id'])
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

        $this->dataNilai = array_values($this->formatNilaiSiswa($data));
    }

    public function formatNilaiSiswa($data)
    {
        $result = [];

        foreach ($data as $kelasSiswaId => $items) {
            $tahunAjaranData = [
                "kelas_siswa_id" => $kelasSiswaId,
                "tahun_ajaran_id" => $items[0]['tahun_ajaran_id'],
                "tingkat_kelas" => "kelas " . $items[0]['tingkat_kelas'] . " " . $items[0]['semester'],
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
