<?php

namespace App\Livewire\User;

use App\Models\User;
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
        $userData = User::search($this->searchQuery)
            ->orderBy('name', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.user.table', compact('userData'));
    }
}
