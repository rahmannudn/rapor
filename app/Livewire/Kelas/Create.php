<?php

namespace App\Livewire\Kelas;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Kelas;

class Create extends Component
{
    public $kelas;
    public $nama;
    public $fase;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.kelas.create');
    }

    public function save()
    {
        $validated = $this->validate([
            'nama' => 'required|string|min:3|max:10',
            'kelas' => 'required',
            'fase' => 'required',
        ]);
        Kelas::create($validated);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('kelasIndex');
    }
}
