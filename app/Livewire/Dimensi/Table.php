<?php

namespace App\Livewire\Dimensi;

use App\Models\Dimensi;
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
        $dimensiData = Dimensi::select('deskripsi', 'id')
            ->search($this->searchQuery)
            ->orderBy('created_at')
            ->paginate($this->show);
        return view('livewire.dimensi.table', compact('dimensiData'));
    }
}
