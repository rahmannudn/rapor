<?php

namespace App\Exports;

use App\Models\TujuanPembelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TujuanPembelajaranExport implements FromQuery, WithHeadings, WithStyles
{
    use Exportable;

    protected $selectedTahunAjaran;
    protected $selectedMapel;
    protected $selectedKelas;
    protected $selectedGuru;

    public function __construct(int $tahunAjaran, int $mapel = null, int $kelas = null, int $guru)
    {
        $this->selectedTahunAjaran = $tahunAjaran;
        $this->selectedMapel = $mapel;
        $this->selectedKelas = $kelas;
        $this->selectedGuru = $guru;
    }

    public function query()
    {
        return TujuanPembelajaran::query()
            ->joinDetailGuruMapel()
            ->searchAndJoinMapel($this->selectedMapel)
            ->searchAndJoinKelas($this->selectedKelas)
            ->joinGuruMapel()
            ->searchAndJoinUsers($this->selectedGuru)
            ->searchAndJoinTahunAjaran($this->selectedTahunAjaran)
            ->select(
                'tujuan_pembelajaran.id',
                'tujuan_pembelajaran.deskripsi as tujuan_pembelajaran_deskripsi',
                'mapel.nama_mapel',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester'
            )
            ->orderBy('tujuan_pembelajaran.created_at')
            ->orderBy('tahun_ajaran.tahun')
            ->orderBy('kelas.nama')
            ->orderBy('users.name');
    }

    public function headings(): array
    {
        return ['NO', 'Deskripsi Tujuan Pembelajaran', 'Nama Mapel', 'Nama Kelas', 'Nama Guru', 'Tahun Ajaran', 'Semester'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
