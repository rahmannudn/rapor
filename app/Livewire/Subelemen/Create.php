<?php

namespace App\Livewire\Subelemen;

use App\Models\Elemen;
use App\Models\Dimensi;
use App\Models\Subelemen;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Create extends Component
{
    public $daftarDimensi;
    public $selectedDimensi;

    public $daftarElemen;
    public $selectedElemen;
    public $formCreate;

    public $deskripsi;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.subelemen.create');
    }

    public function mount()
    {
        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();
    }

    public function getElemen()
    {
        if ($this->selectedDimensi) {

            $this->daftarElemen = '';
            $this->selectedElemen = '';

            $this->daftarElemen = Elemen::select('deskripsi', 'id')
                ->where('dimensi_id', $this->selectedDimensi)
                ->orderBy('created_at')
                ->get();
        }
    }

    public function showForm()
    {
        $validated = $this->validate([
            'selectedDimensi' => 'required',
            'selectedElemen' => 'required',
        ], [
            'selectedDimensi.required' => 'Dimensi field is required.',
            'selectedElemen.required' => 'Elemen field is required.',
        ]);

        if (is_null($this->selectedDimensi) && is_null($this->selectedElemen)) return;
        $this->formCreate = 'true';
    }

    public function save()
    {
        $this->authorize('create', Subelemen::class);
        $validated = $this->validate([
            'selectedDimensi' => 'required',
            'selectedElemen' => 'required',
            'deskripsi' => 'required|string|min:3|max:250'
        ]);

        Subelemen::create([
            'elemen_id' => $validated['selectedElemen'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        redirect()->route('subelemenIndex');
    }
}
