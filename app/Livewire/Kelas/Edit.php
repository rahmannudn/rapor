<?php

namespace App\Livewire\Kelas;

use App\Models\User;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\WaliKelas;
use Livewire\Attributes\On;

class Edit extends Component
{
    public Kelas $kelasData;
    public $nama;
    public $kelas;
    public $fase;

    public function mount()
    {
        $this->nama = $this->kelasData['nama'];
        $this->kelas = $this->kelasData['kelas'];
        $this->fase = $this->kelasData['fase'];
    }

    public function render()
    {
        return view('livewire.kelas.edit');
    }

    public function update(Kelas $kelasData)
    {
        $this->authorize('update', Kelas::class);

        $validated = $this->validate([
            'nama' => 'required|string|min:3|max:10',
            'kelas' => 'required',
            'fase' => 'required',
        ]);
        $kelasData->update($validated);

        session()->flash('success', 'Data Berhasil Diubah');
        $this->redirectRoute('kelasIndex');
    }
}
