<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use App\Models\Siswa;
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
        $siswaData = Siswa::search($this->searchQuery)
            ->orderBy('aktif', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.siswa.table', compact('siswaData'));
    }
}
