<?php

namespace App\Livewire\WaliKelas;

use App\Helpers\FunctionHelper;
use App\Models\TahunAjaran;
use App\Models\WaliKelas;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;
    public $daftarTahunAjaran;
    public $selectedTahunAjaran;

    #[On('updateData')]
    public function render()
    {
        $waliKelasData = WaliKelas::join('users', 'users.id', 'wali_kelas.user_id')
            ->search($this->searchQuery)
            ->orderBy('users.name', 'DESC')
            ->select('wali_kelas.*') // Pastikan memilih kolom dari wali_kelas
            ->paginate($this->show);

        return view('livewire.wali-kelas.table', compact('waliKelasData'));
    }

    public function mount()
    {
        $this->daftarTahunAjaran = TahunAjaran::all(['id', 'tahun', 'semester']);
        // $this->selectedTahunAjaran = FunctionHelper::getTahunAjaranAktif();
    }
}
