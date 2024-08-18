<?php

namespace App\Livewire\Mapel;

use Livewire\Component;
use App\Models\Mapel;

class Create extends Component
{
    public $namaMapel;

    public function render()
    {
        return view('livewire.mapel.create');
    }

    public function save()
    {
        $this->authorize('create', Mapel::class);

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
