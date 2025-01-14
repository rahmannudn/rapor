<?php

namespace App\Livewire\HomePage;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.homepage.index');
    }
}
