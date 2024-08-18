<?php

namespace App\Livewire\Mapel;

use App\Models\Mapel;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public Mapel $mapel;
    public $namaMapel;

    public function mount()
    {
        $this->namaMapel = $this->mapel['nama_mapel'];
    }

    public function render()
    {
        return view('livewire.mapel.edit');
    }

    public function update(Mapel $mapel)
    {
        $this->authorize('update', Mapel::class);

        if (!$mapel) session()->flash('gagal', 'Data tidak ditemukan');
        $validated = $this->validate([
            'namaMapel' => 'required|string|min:3',
        ]);
        // $this->authorize('updaate',$mapel);
        $mapel->update([
            'nama_mapel' => $validated['namaMapel'],
        ]);

        session()->flash('success', 'Data Berhasil Diubah');
        $this->redirectRoute('mapelIndex');
    }
}
