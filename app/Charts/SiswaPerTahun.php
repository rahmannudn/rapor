<?php

namespace App\Charts;

use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SiswaPerTahun
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $data = $this->grafikDataSiswa();

        return $this->chart->barChart()
            ->setTitle('Grafik Data Murid')
            ->setSubtitle('Rentang Waktu ' . $data['label'][0] . ' - ' . end($data['label']))
            ->addData('Laki-Laki', $data['data_laki_laki'])
            ->addData('Perempuan', $data['data_perempuan'])
            ->addData('Total', $data['dataTotal'])
            ->setXAxis($data['label']);
    }

    public function grafikDataSiswa()
    {
        // Ambil data tahun ajaran dan jumlah siswa
        $tahunAjaranData = TahunAjaran::with(['kelasSiswa.siswa'])->get();

        $labels = [];
        $dataPerempuan = [];
        $dataLakiLaki = [];
        $dataTotal = [];

        foreach ($tahunAjaranData as $tahunAjaran) {
            $labels[] = $tahunAjaran->tahun . ' - ' . $tahunAjaran->semester;

            // Hitung jumlah siswa berdasarkan jenis kelamin
            $jumlahPerempuan = KelasSiswa::where('tahun_ajaran_id', $tahunAjaran->id)
                ->whereHas('siswa', function ($query) {
                    $query->where('jk', 'p'); // 'p' untuk perempuan
                })
                ->count();

            $jumlahLakiLaki = KelasSiswa::where('tahun_ajaran_id', $tahunAjaran->id)
                ->whereHas('siswa', function ($query) {
                    $query->where('jk', 'l'); // 'l' untuk laki-laki
                })
                ->count();

            $dataPerempuan[] = $jumlahPerempuan;
            $dataLakiLaki[] = $jumlahLakiLaki;
            $dataTotal[] = $jumlahPerempuan + $jumlahLakiLaki;
        }

        return [
            'data_perempuan' => $dataPerempuan,
            'data_laki_laki' => $dataLakiLaki,
            'dataTotal' => $dataTotal,
            'label' => $labels,
        ];
    }
}
