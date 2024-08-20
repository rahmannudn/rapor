<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use App\Models\Siswa;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;

    #[On('updateData')]
    public function render()
    {
        $siswaData = Siswa::search($this->searchQuery)
            ->join('kelas_siswa', 'siswa.id', '=', 'kelas_siswa.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'kelas_siswa.kelas_id')
            ->orderBy('nama', 'ASC')
            ->select('siswa.id', 'siswa.nisn', 'siswa.nama', 'siswa.jk', 'siswa.agama', 'siswa.foto', 'kelas.nama as nama_kelas')
            ->paginate($this->show);

        return view('livewire.siswa.table', compact('siswaData'));
    }
}
