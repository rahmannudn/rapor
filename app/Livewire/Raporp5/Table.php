<?php

namespace App\Livewire\Raporp5;

use App\Models\KelasSiswa;
use App\Models\Siswa;
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
            ->select('wali_kelas.id')
            ->join('kelas_siswa', 'kelas_siswa.kelas_id', 'wali_kelas.kelas_id')
            ->where('kelas_siswa.tahun_ajaran_id', $tahunAjaranAktif)
            ->join('siswa', 'siswa.id', 'kelas_siswa.siswa_id')
            ->orderBy('siswa.nama', 'ASC')
            ->select('siswa.id', 'siswa.nama')
            ->paginate($this->show);

        return view('livewire.raporp5.table', compact('dataSiswa'));
    }
    public function mount() {}
}
