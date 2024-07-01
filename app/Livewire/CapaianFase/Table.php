<?php

namespace App\Livewire\CapaianFase;

use App\Models\CapaianFase;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;

    #[On('updateData')]
    public function render()
    {
        $capaianFaseData = CapaianFase::joinSubelemen()
            ->joinElemen()
            ->joinDimensi()
            ->select(
                'capaian_fase.id',
                'capaian_fase.deskripsi',
                'capaian_fase.fase',
                'subelemen.deskripsi as subelemenDeskripsi',
                'elemen.deskripsi as elemenDeskripsi',
                'dimensi.deskripsi as dimensiDeskripsi',
            )
            ->search($this->searchQuery)
            ->orderBy('capaian_fase.created_at')
            ->orderBy('capaian_fase.subelemen_id')
            ->paginate($this->show);

        return view('livewire.capaian-fase.table', compact('capaianFaseData'));
    }
}
