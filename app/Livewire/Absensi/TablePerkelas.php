<?php

namespace App\Livewire\Absensi;

use App\Models\KelasSiswa;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\On;

class TablePerkelas extends Component
{
    public $absensiKelas;

    public function render()
    {
        return view('livewire.absensi.table-perkelas');
    }

    #[On('absensiKelasUpdated')]
    public function updateAbsensiKelas($data)
    {
        $this->absensiKelas = $data;
    }

    public function mount() {}

    public function warnaKehadiran(float $persen): string
    {
        return match (true) {
            $persen < 60 => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            $persen < 80 => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            default => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        };
    }
}
