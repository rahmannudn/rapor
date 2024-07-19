<?php

namespace App\Livewire\NilaiProyek;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.nilai-proyek.index');
    }
}
