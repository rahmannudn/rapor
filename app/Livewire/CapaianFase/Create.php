<?php

namespace App\Livewire\CapaianFase;

use App\Models\CapaianFase;
use App\Models\Elemen;
use App\Models\Dimensi;
use App\Models\Subelemen;
use Livewire\Component;

class Create extends Component
{
    public $daftarDimensi;
    public $daftarElemen;
    public $daftarSubelemen;
    public $formCreate = false;

    public $selectedFase;
    public $selectedDimensi;
    public $selectedElemen;
    public $selectedSubelemen;

    public $fase;
    public $deskripsi;

    public function render()
    {
        return view('livewire.capaian-fase.create');
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
            $this->daftarSubelemen = '';
            $this->selectedSubelemen = '';

            $this->daftarElemen = Elemen::select('deskripsi', 'id')
                ->where('dimensi_id', $this->selectedDimensi)
                ->orderBy('created_at')
                ->get();
        }
    }

    public function getSubelemen()
    {
        if ($this->selectedDimensi && $this->selectedElemen) {
            $this->daftarSubelemen = '';
            $this->selectedSubelemen = '';

            $this->daftarSubelemen = Subelemen::select('deskripsi', 'id')
                ->where('elemen_id', $this->selectedElemen)
                ->orderBy('created_at')
                ->get();
        }
    }

    public function showForm()
    {
        $validated = $this->validate([
            'selectedDimensi' => 'required',
            'selectedElemen' => 'required',
            'selectedSubelemen' => 'required',
        ], [
            'selectedDimensi.required' => 'Dimensi field is required.',
            'selectedElemen.required' => 'Elemen field is required.',
            'selectedSublemen.required' => 'Subelemen field is required.',
        ]);

        if (is_null($this->selectedDimensi) && is_null($this->selectedElemen) && is_null($this->selectedSubelemen)) return;
        $this->formCreate = 'true';
    }

    public function save()
    {
        $this->authorize('create', CapaianFase::class);

        $validated = $this->validate([
            'selectedDimensi' => 'required',
            'selectedElemen' => 'required',
            'selectedSubelemen' => 'required',
            'fase' => 'required',
            'deskripsi' => 'required|string|min:5'
        ]);

        CapaianFase::create([
            'subelemen_id' => $validated['selectedSubelemen'],
            'fase' => $validated['fase'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        redirect()->route('capaianFaseIndex');
    }
}
