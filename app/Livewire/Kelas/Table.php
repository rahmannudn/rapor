<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
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
        $kelasData = Kelas::search($this->searchQuery)
            ->orderBy('kelas', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.kelas.table', compact('kelasData'));
    }
}
