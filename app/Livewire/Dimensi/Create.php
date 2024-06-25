<?php

namespace App\Livewire\Dimensi;

use App\Models\Dimensi;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Create extends Component
{
    public $deskripsi;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.dimensi.create');
    }

    public function save()
    {
        $this->authorize('create', Dimensi::class);
        $validated = $this->validate(['deskripsi' => 'required|string|min:5|max:100']);
        Dimensi::create(['deskripsi' => $validated['deskripsi']]);

        $this->redirectRoute('dimensiIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
