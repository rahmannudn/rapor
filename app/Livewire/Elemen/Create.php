<?php

namespace App\Livewire\Elemen;

use App\Models\Dimensi;
use App\Models\Elemen;
use Livewire\Component;


class Create extends Component
{
    public $daftarDimensi;
    public $deskripsi;
    public $selectedDimensi;

    // public $formCreate;

    public function render()
    {
        return view('livewire.elemen.create');
    }

    public function mount()
    {
        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();
    }

    // public function showForm()
    // {
    //     $this->validate(
    //         ['selectedDimensi' => 'required'],
    //         ['selectedDimensi.required' => 'Dimensi field is required.']
    //     );

    //     $this->formCreate = true;
    // }

    public function save()
    {
        $this->authorize('create', Elemen::class);

        $validated = $this->validate([
            'deskripsi' => 'required|string|min:5|max:100',
            'selectedDimensi' => 'required'
        ], ['selectedDimensi' => 'The dimensi field is required.']);

        Elemen::create([
            'dimensi_id' => $validated['selectedDimensi'],
            'deskripsi' => $validated['deskripsi']
        ]);

        $this->redirectRoute('elemenIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
