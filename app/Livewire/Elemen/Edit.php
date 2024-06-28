<?php

namespace App\Livewire\Elemen;

use App\Models\Dimensi;
use App\Models\Elemen;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Edit extends Component
{
    public Elemen $elemen;

    public $dimensiDeskripsi;
    public $deskripsi;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.elemen.edit');
    }

    public function mount()
    {
        $dimensi = Dimensi::firstWhere('id', $this->elemen['dimensi_id'])->select('deskripsi')->first();
        $this->dimensiDeskripsi = $dimensi['deskripsi'];
        $this->deskripsi = $this->elemen['deskripsi'];
    }

    public function update(Elemen $elemen)
    {
        $this->authorize('update', Elemen::class);
        $validated = $this->validate(['deskripsi' => 'required|string|min:5|max:250']);

        if ($this->elemen['deskripsi'] === $validated['deskripsi']) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        $elemen->update([
            'deskripsi' => $validated['deskripsi']
        ]);

        $this->redirectRoute('elemenIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
