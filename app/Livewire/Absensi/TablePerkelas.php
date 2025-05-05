<?php

namespace App\Livewire\Absensi;

use App\Models\KelasSiswa;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Livewire\Component;

class TablePerkelas extends Component
{
    public $absensiKelas;
    public function render()
    {
        return view('livewire.absensi.table-perkelas');
    }

    public function mount() {}
}
