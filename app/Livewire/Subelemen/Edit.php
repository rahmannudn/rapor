<?php

namespace App\Livewire\Subelemen;

use App\Models\Subelemen;
use Livewire\Component;

class Edit extends Component
{
    public Subelemen $subelemen;
    public $deskripsi;
    public $dimensiDeskripsi;
    public $elemenDeskripsi;

    public function render()
    {
        return view('livewire.subelemen.edit');
    }

    public function mount()
    {
        $this->deskripsi = $this->subelemen['deskripsi'];
        $data = Subelemen::joinElemen()
            ->joinDimensi()
            ->select(
                'elemen.deskripsi as elemenDeskripsi',
                'dimensi.deskripsi as dimensiDeskripsi'
            )->first();
        $this->dimensiDeskripsi = $data['dimensiDeskripsi'];
        $this->elemenDeskripsi = $data['elemenDeskripsi'];
    }

    public function update(Subelemen $subelemen)
    {
        $this->authorize('update', Subelemen::class);
        $validated = $this->validate(['deskripsi' => 'required|string|min:5|max:250']);

        if ($this->subelemen['deskripsi'] === $validated['deskripsi']) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        $subelemen->update([
            'deskripsi' => $validated['deskripsi']
        ]);

        $this->redirectRoute('subelemenIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
