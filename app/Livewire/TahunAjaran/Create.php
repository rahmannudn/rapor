<?php

namespace App\Livewire\TahunAjaran;

use Illuminate\Http\Request;
use App\Rules\IsValidYear;
use App\Models\TahunAjaran as TA;
use App\Models\TahunAjaran;
use WireUi\Traits\Actions;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;

class Create extends Component
{
    use Actions;

    public $years = [];

    public $tahunAwal;
    public $tahunAkhir;
    public $semester;
    public $semesterAktif;
    public $confirmModal;

    #[Locked]
    public $validatedData;

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


    public function create($id = null)
    {
        if ($id) {
            $semesterSedangAktif = TahunAjaran::find($id);
            if ($semesterSedangAktif) {
                $semesterSedangAktif['aktif'] = 0;
                $semesterSedangAktif->save();
            }
        }

        TA::create([
            'tahun' => TA::concatTahunAjaran($this->validatedData['tahunAwal'], $this->validatedData['tahunAkhir']),
            'semester' => $this->validatedData['semester'],
            'aktif' => $this->validatedData['semesterAktif']
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('tahunAjaranIndex');
    }

    public function resetData()
    {
        $this->confirmModal = false;
        $this->validatedData = null;
    }

    public function save(Request $request)
    {
        $validated = $this->validate();

        if ($validated['semesterAktif'] === '0') {
            $this->validatedData = $validated;
            $this->create();
            return;
        }

        // jika semester aktif bernilai 1
        $semesterSedangAktif = TahunAjaran::firstWhere('aktif', 1);

        // jika tidak ditemukan semester yang sedang aktif
        if (!$semesterSedangAktif) {
            $this->validatedData = $validated;
            $this->create();
            return;
        }

        // jika semester aktif bernilai 1 dan ditemukan sudah ada semester yang aktif
        session()->flash('confirmDialog', ['message' => "Tahun ajaran aktif saat ini {$semesterSedangAktif['tahun']} {$semesterSedangAktif['semester']}. Perubahan tahun ajaran aktif dapat menimbulkan error pada penginputan nilai", 'id' => $semesterSedangAktif['id']]);
        $this->confirmModal = true;
        $this->validatedData = $validated;
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
