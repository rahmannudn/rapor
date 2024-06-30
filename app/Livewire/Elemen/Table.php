<?php

namespace App\Livewire\Elemen;

use App\Models\Elemen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;

    #[On('updateData')]
    public function render()
    {
        $elemenData = Elemen::joinDimensi()
            ->search($this->searchQuery)
            ->select(
                'elemen.id',
                'elemen.deskripsi',
                'dimensi.deskripsi as dimensiDeskripsi'
            )
            ->orderBy('elemen.created_at')
            ->orderBy('elemen.dimensi_id')
            ->paginate($this->show);

        return view('livewire.elemen.table', compact('elemenData'));
    }
}
