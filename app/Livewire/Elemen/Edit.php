<?php

namespace App\Livewire\Elemen;

use App\Models\Dimensi;
use App\Models\Elemen;
use Livewire\Component;

class Edit extends Component
{
    public Elemen $elemen;

    public $dimensiDeskripsi;
    public $selectedDimensi;
    public $originDimensi;
    public $deskripsi;
    public $daftarDimensi;

    public function render()
    {
        return view('livewire.elemen.edit');
    }

    public function mount()
    {
        $dimensi = Dimensi::firstWhere('id', $this->elemen['dimensi_id'])->select('id', 'deskripsi')->first()->toArray();
        $this->selectedDimensi = $dimensi['id'];
        $this->originDimensi = $dimensi['id'];

        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();
        $this->dimensiDeskripsi = $dimensi['deskripsi'];
        $this->deskripsi = $this->elemen['deskripsi'];
    }

    public function update(Elemen $elemen)
    {
        $this->authorize('update', Elemen::class);
        $validated = $this->validate([
            'deskripsi' => 'required|string|min:5|max:250',
            'selectedDimensi' => 'required'
        ], ['selectedDimensi' => 'The dimensi field is required.']);

        if (
            $this->elemen['deskripsi'] === $validated['deskripsi'] &&
            $this->originDimensi === $validated['selectedDimensi']
        ) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        $elemen->update([
            'dimensi_id' => $validated['selectedDimensi'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        $this->redirectRoute('elemenIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
