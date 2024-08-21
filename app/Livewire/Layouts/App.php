<?php

namespace App\Livewire\Layouts;

use App\Models\Sekolah;
use Livewire\Component;
use App\Helpers\FunctionHelper;

class App extends Component
{
    public function mount()
    {
        FunctionHelper::setCacheTahunAjaran();
        FunctionHelper::setCacheInfoSekolah();
    }
    public function render()
    {
        return view('livewire.layouts.app');
    }
}
