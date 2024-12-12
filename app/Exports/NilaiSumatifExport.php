<?php

namespace App\Exports;

use App\Models\NilaiSumatif;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class NilaiSumatifExport implements FromArray, WithStrictNullComparison, WithHeadings
{
    use Exportable;

    protected $nilai = [];
    protected $lingkupMateri = [];

    public function __construct(array $nilai, array $lingkupMateri)
    {
        $this->nilai = $nilai;
        $this->lingkupMateri = $lingkupMateri;
    }

    public function array(): array
    {
        $result = [];
        foreach ($this->nilai as $index => $item) {
            $row = [
                'No' => $index + 1,
                'nama_siswa' => $item['nama_siswa'],
            ];

            foreach ($item['nilai'] as $i => $nilai) {
                $row["nilai_sumatif_" . ($i + 1)] = $nilai['nilai_sumatif'];
            }

            $row['nilai_tes'] = $item['nilai_sumatif_akhir']['nilai_tes'] ?? '-';
            $row['nilai_nontes'] = $item['nilai_sumatif_akhir']['nilai_nontes'] ?? '-';
            $row['nilai_akhir'] = $item['rata_nilai'];

            $result[] = $row;
        }

        return $result;
    }

    public function headings(): array
    {
        $heading = [
            'No',
            'Nama Siswa',
        ];

        foreach ($this->lingkupMateri as $i => $lingkup) {
            $heading['Lingkup Materi - ' . ($i + 1)] = $lingkup['deskripsi'];
        }

        return array_merge($heading, [
            'Nilai Tes',
            'Nilai NonTes',
            'Nilai Akhir',
        ]);
    }
}
