<?php

namespace App\Livewire\Dimensi;

use App\Models\Dimensi;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Edit extends Component
{
    public Dimensi $dimensi;

    public $deskripsi;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.dimensi.edit');
    }

    public function mount()
    {
        $this->deskripsi = $this->dimensi['deskripsi'];
    }

    public function update(Dimensi $dimensi)
    {
        $this->authorize('update', Dimensi::class);
        $validated = $this->validate(['deskripsi' => 'required|string|min:5|max:250']);

        if ($this->dimensi['deskripsi'] === $validated['deskripsi']) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        $dimensi->update([
            'deskripsi' => $validated['deskripsi']
        ]);

        $this->redirectRoute('dimensiIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
