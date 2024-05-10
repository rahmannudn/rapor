<?php

namespace App\Livewire\Sekolah;

use App\Models\Sekolah;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Index extends Component
{
    public $dataSekolah;

    public function mount()
    {
        $this->dataSekolah = Sekolah::all()[0];
    }

    #[Title('Sekolah')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.sekolah.index');
    }
}
