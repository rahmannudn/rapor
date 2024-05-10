<?php

namespace App\Livewire\TahunAjaran;

use Illuminate\Http\Request;
use App\Rules\IsValidYear;
use App\Models\TahunAjaran as TA;

use WireUi\Traits\Actions;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Title;

class Create extends Component
{
    use Actions;

    public $years = [];

    public $tahunAwal;
    public $tahunAkhir;
    public $semester;
    public $semesterAktif;


    #[Title('Tambah Tahun Ajaran')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tahun-ajaran.create');
    }

    public function rules()
    {
        return [
            'tahunAwal' => ['required', 'min:4', new IsValidYear($this->tahunAkhir)],
            'tahunAkhir' => ['required', 'min:4'],
            'semester' => ['required', 'string'],
            'semesterAktif' => ['required', 'boolean']
        ];
    }

    public function save(Request $request)
    {
        $validated = $this->validate();
        TA::create([
            'tahun' => TA::concatTahunAjaran($validated['tahunAwal'], $validated['tahunAkhir']),
            'semester' => $validated['semester'],
            'aktif' => $validated['semesterAktif']
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('tahunAjaranIndex');
    }

    public function mount()
    {
        $this->reset();

        // mengambil data tahun sekarang
        $currentYear = date('Y');

        // nilai variabel $currentYear akan ditambah nilai index kemudian dikurang 1
        // expression di loop sebanyak 3 kali, hasilnya dimasukkan ke array $years
        // contoh : $currentYear = 2024, $years = [2023,2024,2025]
        for ($i = 0; $i <= 3; $i++) {
            $this->years[] = ($currentYear + $i) - 1;
        }
    }
}
