<?php

namespace App\Livewire\Proyek;

use App\Models\Proyek;
use Livewire\Component;

class Detail extends Component
{
    public Proyek $proyek;

    public function render()
    {
        return view('livewire.proyek.detail');
    }
}
