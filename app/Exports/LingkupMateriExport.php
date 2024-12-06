<?php

namespace App\Exports;

use App\Models\LingkupMateri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LingkupMateriExport implements FromQuery, WithHeadings, WithStyles
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
        return LingkupMateri::query()
            ->joinDetailGuruMapel()
            ->searchAndJoinMapel($this->selectedMapel)
            ->searchAndJoinKelas($this->selectedKelas)
            ->joinGuruMapel()
            ->searchAndJoinUsers($this->selectedGuru)
            ->searchAndJoinTahunAjaran($this->selectedTahunAjaran)
            ->select(
                'lingkup_materi.id',
                'lingkup_materi.deskripsi as lingkup_materi_deskripsi',
                'mapel.nama_mapel',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester'
            )
            ->orderBy('lingkup_materi.created_at')
            ->orderBy('tahun_ajaran.tahun')
            ->orderBy('users.name');
    }

    public function headings(): array
    {
        return ['NO', 'Deskripsi Lingkup Materi', 'Nama Mapel', 'Nama Kelas', 'Nama Guru', 'Tahun Ajaran', 'Semester'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
