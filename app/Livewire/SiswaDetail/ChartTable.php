<?php

namespace App\Livewire\SiswaDetail;

use App\Models\Siswa;
use Livewire\Component;
use App\Charts\NilaiSiswaPerSemester;

class ChartTable extends Component
{
    public Siswa $siswa;

    public function render(NilaiSiswaPerSemester $chart)
    {
        $chart->getNilaiSiswa($this->siswa);

        return view('livewire.siswa-detail.chart-table', ['nilaiSiswaPersemester' => $chart->build()]);
    }
}
