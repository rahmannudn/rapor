<?php

namespace App\Livewire\Siswa;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Helpers\FunctionHelper;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;
    public $tahunAjaranAktif;

    public function mount()
    {
        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();
    }

    #[On('updateData')]
    public function render()
    {
        $siswaData = Siswa::search($this->searchQuery)
            ->joinAndSearchKelasSiswa($this->tahunAjaranAktif)
            ->leftjoin('kelas', 'kelas.id', '=', 'kelas_siswa.kelas_id')
            ->orderBy('nama', 'ASC')
            ->select('siswa.id', 'siswa.nisn', 'siswa.nama', 'siswa.jk', 'siswa.agama', 'siswa.foto', 'kelas.nama as nama_kelas')
            ->paginate($this->show);

        return view('livewire.siswa.table', compact('siswaData'));
    }
}
