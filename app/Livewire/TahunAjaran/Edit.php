<?php

namespace App\Livewire\TahunAjaran;

use Livewire\Component;
use App\Rules\IsValidYear;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\TahunAjaran as TA;
use Livewire\Attributes\Locked;
use App\Helpers\FunctionHelper;

class Edit extends Component
{
    public TA $tahunAjaran;

    public $years = [];

    public $tahunAwal;
    public $tahunAkhir;
    public $semester;
    public $semesterAktif;
    public $confirmModal;

    #[Locked]
    public $validatedData;

    public function mount()
    {
        $this->years = FunctionHelper::getDynamicYear();
        $this->tahunAwal = TA::getTahunAwal($this->tahunAjaran['tahun']);
        $this->tahunAkhir = TA::getTahunAkhir($this->tahunAjaran['tahun']);
        $this->semester = $this->tahunAjaran['semester'];
        $this->semesterAktif = $this->tahunAjaran['aktif'];
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tahun-ajaran.edit');
    }

    public function update($id = null)
    {
        if ($id) {
            $semesterSedangAktif = TA::find($id);
            if ($semesterSedangAktif) {
                $semesterSedangAktif['aktif'] = 0;
                $semesterSedangAktif->save();
            }
        }

        $tahunAjaran = $this->tahunAjaran;
        $tahunAjaran->update([
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

    public function rules()
    {
        return [
            'tahunAwal' => ['required', new IsValidYear($this->tahunAkhir)],
            'tahunAkhir' => ['required',],
            'semester' => ['required', 'string'],
            'semesterAktif' => ['required', 'boolean']
        ];
    }

    public function edit(TA $tahunAjaran)
    {
        try {
            $validated = $this->validate();
            $this->validatedData = $validated;

            if ($validated['semesterAktif'] === '0') {
                $this->validatedData['semesterAktif'] = $validated['semesterAktif'];
                $this->validatedData = $validated;
                $this->update();
                return;
            }

            // jika semester aktif bernilai 1
            $semesterSedangAktif = TA::firstWhere('aktif', 1);

            // jika tidak ditemukan semester yang sedang aktif
            if (!$semesterSedangAktif) {
                $this->update();
                return;
            }

            // jika semester aktif bernilai 1 dan ditemukan sudah ada semester yang aktif
            session()->flash('confirmDialog', ['message' => "Tahun ajaran aktif saat ini {$semesterSedangAktif['tahun']} {$semesterSedangAktif['semester']}. Perubahan tahun ajaran aktif dapat menimbulkan error pada penginputan nilai", 'id' => $semesterSedangAktif['id']]);
            $this->confirmModal = true;
        } catch (\Throwable $th) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
