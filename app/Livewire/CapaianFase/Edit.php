<?php

namespace App\Livewire\CapaianFase;

use App\Models\Elemen;
use App\Models\Dimensi;
use Livewire\Component;
use App\Models\CapaianFase;
use App\Models\Subelemen;

class Edit extends Component
{
    public CapaianFase $capaianFase;
    public $deskripsi;
    public $fase;

    public $selectedDimensi;
    public $daftarDimensi;
    public $originDimensi;

    public $selectedElemen;
    public $daftarElemen;
    public $originElemen;

    public $selectedSubelemen;
    public $daftarSubelemen;
    public $originSubelemen;

    public function render()
    {
        return view('livewire.capaian-fase.edit');
    }

    public function mount()
    {
        $this->deskripsi = $this->capaianFase['deskripsi'];
        $this->fase = $this->capaianFase['fase'];

        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')
            ->orderBy('created_at', 'DESC')
            ->get();

        $data = CapaianFase::joinAndSearchSubelemen($this->capaianFase['subelemen_id'])
            ->joinElemen()
            ->joinDimensi()
            ->select(
                'subelemen.id as subelemen_id',
                'elemen.id as elemen_id',
                'dimensi.id as dimensi_id',
            )
            ->first();

        if ($data) {
            $this->selectedDimensi = $data->dimensi_id;
            $this->originDimensi = $data->dimensi_id;
            $this->selectedElemen = $data->elemen_id;
            $this->originElemen = $data->elemen_id;
            $this->selectedSubelemen = $data->subelemen_id;
            $this->originSubelemen = $data->subelemen_id;

            $this->deskripsi = $this->capaianFase['deskripsi'];

            $this->daftarElemen = Elemen::select('deskripsi', 'id')
                ->where('dimensi_id', $this->selectedDimensi)
                ->orderBy('created_at', 'DESC')
                ->get();

            $this->daftarSubelemen = Subelemen::select('deskripsi', 'id')
                ->where('elemen_id', $this->selectedElemen)
                ->orderBy('created_at', 'DESC')
                ->get();
        }
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

    public function update(CapaianFase $capaianFase)
    {
        $this->authorize('update', CapaianFase::class);
        $validated = $this->validate([
            'deskripsi' => 'required|string|min:5',
            'fase' => 'required',
            'selectedDimensi' => 'required',
            'selectedElemen' => 'required',
            'selectedSubelemen' => 'required',
        ]);

        if (
            $this->capaianFase['deskripsi'] === $validated['deskripsi'] &&
            $this->capaianFase['fase'] === $validated['fase'] &&
            $this->originDimensi === $validated['selectedDimensi'] &&
            $this->originElemen === $validated['selectedElemen'] &&
            $this->originSubelemen === $validated['selectedSubelemen']
        ) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        if (
            $this->originDimensi !== $validated['selectedDimensi']
        ) {
            $elemen = Elemen::find($this->selectedElemen);
            $elemen->dimensi_id = $validated['selectedDimensi'];
            $elemen->save();
        }

        if (
            $this->originElemen !== $validated['selectedElemen']
        ) {
            $subelemen = Subelemen::find($this->selectedElemen);
            $subelemen->elemen_id = $validated['selectedElemen'];
            $subelemen->save();
        }

        $capaianFase->update([
            'subelemen_id' => $validated['selectedSubelemen'],
            'deskripsi' => $validated['deskripsi'],
            'fase' => $validated['fase'],
        ]);

        $this->redirectRoute('capaianFaseIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
