<?php

namespace App\Livewire\SiswaDetail;

use App\Charts\NilaiSiswaPerMapel;
use App\Models\Siswa;
use Livewire\Component;
use App\Charts\NilaiSiswaPerSemester;

class ChartTable extends Component
{
    public Siswa $siswa;
    public array $rataRataSeluruhNilai;

    public function mount() {}

    public function render()
    {
        return view('livewire.siswa-detail.chart-table');
    }
}
