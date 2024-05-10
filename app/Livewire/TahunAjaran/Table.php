<?php

namespace App\Livewire\TahunAjaran;

use App\Models\TahunAjaran;
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
        $tahunAjaranData = TahunAjaran::search($this->searchQuery)
            ->orderBy('aktif', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.tahun-ajaran.table', compact('tahunAjaranData'));
    }
}
