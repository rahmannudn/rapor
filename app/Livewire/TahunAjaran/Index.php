<?php

namespace App\Livewire\TahunAjaran;

use App\Models\TahunAjaran as TA;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public $createModal;
    public $years = [];

    #[Validate('required|string')]
    public $tahun;

    #[Validate('required|string')]
    public $semester;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tahun-ajaran.index');
    }

    public function mount()
    {
        $year = date('Y');

        for ($i = 0; $i <= 2; $i++) {
            $this->years[] = $year + $i - 1 . ' / ' . $year + $i;
        }
    }

    public function updatedSemester()
    {
        $this->semester = strtolower($this->semester);
    }

    public function save(Request $request)
    {
        // dd($this->tahun, $this->semester);
        dd($request->tahun, $request->semester);
        $validated = $this->validate();
        TA::create($validated);

        $this->notification()->success(
            $title = 'Success',
            $description = 'Data Berhasil Tersimpan'
        );
    }
}
