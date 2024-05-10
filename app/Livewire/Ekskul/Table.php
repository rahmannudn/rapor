<?php

namespace App\Livewire\Ekskul;

use App\Models\Ekskul;
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
        $ekskulData = Ekskul::search($this->searchQuery)
            ->orderBy('created_at', 'DESC')
            ->orderBy('nama_ekskul', 'ASC')
            ->paginate($this->show);

        return view('livewire.ekskul.table', compact('ekskulData'));
    }
}
