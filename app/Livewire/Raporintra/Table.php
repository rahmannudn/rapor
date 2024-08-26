<?php

namespace App\Livewire\Raporintra;

use Livewire\Component;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\Cache;

class Table extends Component
{
    public $searchQuery;
    public $show = 10;

    public function render()
    {
        $tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $dataSiswa = WaliKelas::search($this->searchQuery)
            ->where('user_id', auth()->id())
            ->where('wali_kelas.tahun_ajaran_id', $tahunAjaranAktif)
            ->join('kelas_siswa', 'kelas_siswa.kelas_id', 'wali_kelas.kelas_id')
            ->where('kelas_siswa.tahun_ajaran_id', $tahunAjaranAktif)
            ->join('siswa', 'siswa.id', 'kelas_siswa.siswa_id')
            ->orderBy('siswa.nama', 'ASC')
            ->select('siswa.id', 'siswa.nama', 'kelas_siswa.id as kelas_siswa_id')
            ->paginate($this->show);

        return view('livewire.raporintra.table', compact('dataSiswa'));
    }
}
