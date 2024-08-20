<?php

namespace App\Livewire\Subelemen;

use App\Models\Subelemen;
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
        $subelemenData = Subelemen::joinElemen()
            ->joinDimensi()
            ->search($this->searchQuery)
            ->select(
                'subelemen.id',
                'subelemen.deskripsi',
                'elemen.deskripsi as elemenDeskripsi',
                'dimensi.deskripsi as dimensiDeskripsi'
            )
            ->orderBy('subelemen.created_at', 'DESC')
            ->orderBy('subelemen.elemen_id')
            ->paginate($this->show);

        return view('livewire.subelemen.table', compact('subelemenData'));
    }
}
