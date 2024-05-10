<?php

namespace App\Livewire\Mapel;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Mapel;

class Create extends Component
{
    public $namaMapel;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.mapel.create');
    }

    public function save()
    {
        $validated = $this->validate([
            'namaMapel' => 'required|string|min:4|max:50',
        ]);
        Mapel::create([
            'nama_mapel' => $validated['namaMapel'],
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('mapelIndex');
    }
}
