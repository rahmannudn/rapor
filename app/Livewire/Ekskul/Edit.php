<?php

namespace App\Livewire\Ekskul;

use App\Models\Ekskul;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public Ekskul $ekskul;
    public $namaEkskul;


    public function mount()
    {
        $this->namaEkskul = $this->ekskul['nama_ekskul'];
    }

    public function render()
    {
        return view('livewire.ekskul.edit');
    }

    public function update(Ekskul $ekskul)
    {
        $this->authorize('update', Ekskul::class);

        if (!$ekskul) session()->flash('gagal', 'Data tidak ditemukan');
        $validated = $this->validate([
            'namaEkskul' => 'required|string|min:3|max:10',
        ]);
        // $this->authorize('updaate',$ekskul);
        $ekskul->update([
            'nama_ekskul' => $validated['namaEkskul'],
        ]);

        session()->flash('success', 'Data Berhasil Diubah');
        $this->redirectRoute('ekskulIndex');
    }
}
