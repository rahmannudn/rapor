<?php

namespace App\Exports;

use App\Models\Proyek;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DaftarProyekExport implements FromQuery, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $selectedTahunAjaran;

    public function __construct($selectedTahunAjaran)
    {
        $this->selectedTahunAjaran = $selectedTahunAjaran;
    }

    public function query()
    {
        return Proyek::query()
            ->joinWaliKelas()
            ->when(Gate::allows('isWaliKelas'), function ($query) {
                $query->where('wali_kelas.user_id', Auth::id());
            })
            ->joinKelasByWaliKelas()
            ->joinUsers()
            ->filterTahunAjaran($this->selectedTahunAjaran)
            ->select(
                'proyek.id',
                'proyek.judul_proyek',
                'proyek.deskripsi',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester'
            )
            ->orderBy('proyek.created_at', 'DESC');
    }

    public function headings(): array
    {
        return ['NO', 'Judul Proyek', 'Deskripsi', 'Nama Kelas', 'Nama Guru', 'Tahun Ajaran', 'Semester'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
