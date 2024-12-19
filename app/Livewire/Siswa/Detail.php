<?php

namespace App\Livewire\Siswa;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Detail extends Component
{
    public Siswa $siswa;

    public function mount() {}

    public function render()
    {
        return view('livewire.siswa.detail');
    }
}
