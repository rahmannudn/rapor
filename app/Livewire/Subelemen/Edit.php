<?php

namespace App\Livewire\Subelemen;

use App\Models\Dimensi;
use App\Models\Elemen;
use Livewire\Component;
use App\Models\Subelemen;

class Edit extends Component
{
    public Subelemen $subelemen;

    public $daftarDimensi;
    public $selectedDimensi;
    public $originDimensi;

    public $daftarElemen;
    public $selectedElemen;
    public $originElemen;

    public $deskripsi;

    public function render()
    {
        return view('livewire.subelemen.edit');
    }

    public function mount()
    {
        $data = Subelemen::joinElemen()
            ->joinDimensi()
            ->select(
                'elemen.deskripsi as elemenDeskripsi',
                'dimensi.deskripsi as dimensiDeskripsi',
                'elemen.dimensi_id as dimensi_id',
                'elemen.id as elemen_id',
            )->first()
            ->toArray();

        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at', 'DESC')->get();
        $this->selectedDimensi = $data['dimensi_id'];
        $this->originDimensi = $data['dimensi_id'];

        $this->daftarElemen = Elemen::select('deskripsi', 'id')->orderBy('created_at', 'DESC')->get();
        $this->selectedElemen = $data['elemen_id'];
        $this->originElemen = $data['elemen_id'];

        $this->deskripsi = $this->subelemen['deskripsi'];
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

    public function update(Subelemen $subelemen)
    {
        $this->authorize('update', Subelemen::class);
        $validated = $this->validate([
            'deskripsi' => 'required|string|min:5|max:250',
            'selectedElemen' => 'required',
            'selectedDimensi' => 'required'
        ], [
            'selectedDimensi' => 'The dimensi field is required.',
            'selectedElemen' => 'The elemen field is required.',
        ]);

        if (
            $this->subelemen['deskripsi'] === $validated['deskripsi'] &&
            $this->originDimensi === $validated['selectedDimensi'] &&
            $this->originElemen === $validated['selectedElemen']
        ) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        if ($this->originDimensi !== $validated['selectedDimensi']) {
            $elemen = Elemen::find($this->originElemen);
            $elemen->dimensi_id = $validated['selectedDimensi'];
            $elemen->save();
        }

        $subelemen->update([
            'elemen_id' => $validated['selectedElemen'],
            'deskripsi' => $validated['deskripsi']
        ]);


        $this->redirectRoute('subelemenIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
