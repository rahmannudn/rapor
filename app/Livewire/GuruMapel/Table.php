<?php

namespace App\Livewire\GuruMapel;

use App\Helpers\FunctionHelper;
use App\Models\GuruMapel;
use App\Models\WaliKelas;
use Livewire\Component;

class Table extends Component
{
    public $show = 10;
    public $searchQuery;

    public function render()
    {
        $tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();

        $guruMapelData = GuruMapel::join('users', 'users.id', 'guru_mapel.user_id')
            ->where('guru_mapel.tahun_ajaran_id', $tahunAjaranAktif)
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'guru_mapel.tahun_ajaran_id')
            ->join('detail_guru_mapel', 'detail_guru_mapel.guru_mapel_id', 'guru_mapel.id')
            ->join('mapel', 'detail_guru_mapel.mapel_id', 'mapel.id')
            ->join('kelas', 'kelas.id', 'detail_guru_mapel.kelas_id')
            ->orderBy('users.name', 'DESC')
            ->select(
                'guru_mapel.id',
                'users.name as nama_guru',
                'mapel.nama_mapel',
                'kelas.nama as nama_kelas',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
            ) // Pastikan memilih kolom dari wali_kelas
            ->paginate($this->show);

        return view('livewire.guru-mapel.table', compact('guruMapelData'));
    }
}
