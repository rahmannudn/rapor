<?php

namespace App\Exports;

use App\Models\NilaiSumatif;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class LaporanSumatifPerkelasExport implements FromArray, WithStrictNullComparison, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $dataSiswa = [];
    protected $daftarMapel = [];

    use Exportable;

    public function __construct(array $dataSiswa, array $daftarMapel)
    {
        $this->dataSiswa = $dataSiswa;
        $this->daftarMapel = $daftarMapel;
    }
    public function array(): array
    {
        $result = [];
        foreach ($this->dataSiswa as $index => $siswa) {
            $row = [
                "NO" => $index + 1,
                "nama_siswa" => $siswa['nama_siswa']
            ];

            foreach ($siswa['mapel'] as $key => $mapel) {
                $row[$mapel['nama_mapel']] = $mapel['rata_nilai'];
            }

            $result[] = $row;
        }

        return $result;
    }
    public function headings(): array
    {
        $heading = ['NO', "Nama Siswa"];
        if (!empty($this->dataSiswa[0]))
            foreach ($this->dataSiswa[0]['mapel'] as $mapel) {
                array_push($heading, $mapel['nama_mapel']);
            }

        return $heading;
    }
}
