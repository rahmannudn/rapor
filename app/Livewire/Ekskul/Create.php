<?php

namespace App\Livewire\Ekskul;

use Livewire\Component;
use App\Models\Ekskul;

class Create extends Component
{
    public $namaEkskul;

    public function render()
    {
        return view('livewire.ekskul.create');
    }

    public function save()
    {
        $this->authorize('create', Ekskul::class);

        $validated = $this->validate([
            'namaEkskul' => 'required|string|min:4|max:50',
        ]);
        Ekskul::create([
            'nama_ekskul' => $validated['namaEkskul'],
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('ekskulIndex');
    }
}
