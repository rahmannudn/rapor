<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\KelasSiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanAbsensiExcel implements FromArray, WithHeadings, WithStyles
{
    use Exportable;

    protected $formattedData;
    protected $tahunAjaran;
    protected $kelas;

    public $bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    public function __construct(int $tahunAjaran, ?int $kelas = null)
    {
        $this->tahunAjaran = $tahunAjaran;
        $this->kelas = $kelas;

        $rawData = $this->getData(); // ambil data langsung dari sini
        $this->formattedData = $this->formatKehadiranSiswa($rawData->groupBy('siswa_id'))->toArray();
    }

    protected function getData(): Collection
    {
        return KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaran)
            ->when($this->kelas !== null, fn($q) => $q->where('kelas_id', $this->kelas))
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'kelas_siswa.tahun_ajaran_id')
            ->leftJoin('absensi', 'absensi.kelas_siswa_id', 'kelas_siswa.id')
            ->leftJoin('kehadiran_bulanan', 'kehadiran_bulanan.tahun_ajaran_id', 'kelas_siswa.tahun_ajaran_id')
            ->join('siswa', 'siswa.id', 'kelas_siswa.siswa_id')
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->select(
                'siswa.id as siswa_id',
                'siswa.nama as nama_siswa',
                'kelas.nama as nama_kelas',
                'absensi.id as absensi_id',
                'absensi.alfa',
                'absensi.sakit',
                'absensi.izin',
                'kehadiran_bulanan.id as kehadiran_bulanan_id',
                'kehadiran_bulanan.bulan',
                'kehadiran_bulanan.jumlah_hari_efektif',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
            )
            ->orderBy('kelas.id')
            ->get();
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->formattedData as $siswa) {
            foreach ($siswa['kehadiran_bulanan'] as $bulan) {
                $rows[] = [
                    $siswa['no'],
                    $siswa['nama_siswa'],
                    $siswa['nama_kelas'],
                    $siswa['tahun_ajaran'],
                    $bulan['bulan'],
                    $bulan['sakit'],
                    $bulan['izin'],
                    $bulan['alfa'],
                    $bulan['jumlah_kehadiran'],
                ];
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Kelas',
            'Tahun Ajaran',
            'Bulan',
            'Total Sakit',
            'Total Izin',
            'Total Alfa',
            'Jumlah Kehadiran',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    protected function formatKehadiranSiswa(Collection $data)
    {
        return $data->map(function ($items, $siswaId) {
            $siswa = $items->first();
            static $no = 1;

            $rekap = [
                'no' => $no++,
                'nama_siswa' => $siswa['nama_siswa'],
                'nama_kelas' => $siswa['nama_kelas'],
                'tahun_ajaran' => $siswa['tahun'] . ' ' . $siswa['semester'],
                'kehadiran_bulanan' => [],
            ];

            foreach ($items as $item) {
                $alfa = (int) ($item['alfa'] ?? 0);
                $sakit = (int) ($item['sakit'] ?? 0);
                $izin = (int) ($item['izin'] ?? 0);
                $hariEfektif = (int) ($item['jumlah_hari_efektif'] ?? 0);

                $rekap['kehadiran_bulanan'][] = [
                    'bulan' => $this->bulan[$item['bulan'] - 1],
                    'jumlah_hari_efektif' => $hariEfektif,
                    'alfa' => $alfa,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'jumlah_kehadiran' => $hariEfektif - ($alfa + $izin + $sakit),
                ];
            }

            return $rekap;
        })->values();
    }
}
