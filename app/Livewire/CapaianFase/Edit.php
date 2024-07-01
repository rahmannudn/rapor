<?php

namespace App\Livewire\CapaianFase;

use App\Models\CapaianFase;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public CapaianFase $capaianFase;
    public $deskripsi;
    public $fase;

    public $dimensiDeskripsi;
    public $elemenDeskripsi;
    public $subelemenDeskripsi;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.capaian-fase.edit');
    }

    public function mount()
    {
        $this->deskripsi = $this->capaianFase['deskripsi'];
        $this->fase = $this->capaianFase['fase'];

        $data = CapaianFase::joinAndSearchSubelemen($this->capaianFase['subelemen_id'])
            ->joinElemen()
            ->joinDimensi()
            ->select(
                'capaian_fase.id',
                'capaian_fase.deskripsi',
                'subelemen.deskripsi as subelemenDeskripsi',
                'elemen.deskripsi as elemenDeskripsi',
                'dimensi.deskripsi as dimensiDeskripsi'
            )
            ->first();

        if ($data) {
            $this->dimensiDeskripsi = $data->dimensiDeskripsi;
            $this->elemenDeskripsi = $data->elemenDeskripsi;
            $this->subelemenDeskripsi = $data->subelemenDeskripsi;
        }
    }

    public function update(CapaianFase $capaianFase)
    {
        $this->authorize('update', CapaianFase::class);
        $validated = $this->validate([
            'deskripsi' => 'required|string|min:5',
            'fase' => 'required',
        ]);

        if (
            $this->capaianFase['deskripsi'] === $validated['deskripsi'] &&
            $this->capaianFase['fase'] === $validated['fase']
        ) {
            session()->flash('gagal', 'Tidak ada perubahan data');
            return;
        }

        $capaianFase->update([
            'deskripsi' => $validated['deskripsi'],
            'fase' => $validated['fase'],
        ]);

        $this->redirectRoute('capaianFaseIndex');
        session()->flash('success', 'Data Berhasil Dirubah');
    }
}
