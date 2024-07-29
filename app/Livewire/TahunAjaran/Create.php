<?php

namespace App\Livewire\TahunAjaran;

use Illuminate\Http\Request;
use App\Rules\IsValidYear;
use App\Models\TahunAjaran as TA;
use App\Models\TahunAjaran;
use WireUi\Traits\Actions;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use App\Helpers\FunctionHelper;

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

    public function render()
    {
        return view('livewire.tahun-ajaran.create');
    }

    public function rules()
    {
        return [
            'tahunAwal' => ['required', new IsValidYear($this->tahunAkhir)],
            'tahunAkhir' => ['required',],
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
        $this->years = FunctionHelper::getDynamicYear();
    }
}
