<?php

namespace App\Livewire\SiswaDetail;

use Livewire\Component;
use App\Models\Prestasi;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Charts\NilaiSiswaPerSemester;
use Illuminate\Database\Query\JoinClause;

class Index extends Component
{
    public Siswa $siswa;

    public function render()
    {
        $layout = session()->has('authenticated_parent')
            ? 'components.layouts.guest' // Layout untuk orang tua
            : 'components.layouts.app'; // Layout untuk user lain

        return view('livewire.siswa-detail.index')->layout($layout);
    }
}
