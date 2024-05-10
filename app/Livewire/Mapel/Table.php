<?php

namespace App\Livewire\Mapel;

use App\Models\Mapel;
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
        $mapelData = Mapel::search($this->searchQuery)
            ->orderBy('created_at', 'DESC')
            ->orderBy('nama_mapel', 'ASC')
            ->paginate($this->show);

        return view('livewire.mapel.table', compact('mapelData'));
    }
}
