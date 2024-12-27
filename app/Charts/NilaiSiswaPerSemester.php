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
            ->setTitle('Rata-Rata Keseluruhan Nilai Persemester')
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

    public function getRataRataSeluruhNilai($rataRataNilai)
    {
        $this->dataNilai = $rataRataNilai;
        dump($this->dataNilai);
    }
}
