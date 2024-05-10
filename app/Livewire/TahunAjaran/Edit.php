<?php

namespace App\Livewire\TahunAjaran;

use Livewire\Component;
use App\Rules\IsValidYear;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\TahunAjaran as TA;


class Edit extends Component
{
    public TA $tahunAjaran;

    public $years = [];

    public $tahunAwal;
    public $tahunAkhir;
    public $semester;
    public $semesterAktif;

    public function mount()
    {
        $this->years = TA::getYears();
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

    public function rules()
    {
        return [
            'tahunAwal' => ['required', 'min:4', new IsValidYear($this->tahunAkhir)],
            'tahunAkhir' => ['required', 'min:4'],
            'semester' => ['required', 'string'],
            'semesterAktif' => ['required', 'boolean']
        ];
    }

    public function update(TA $tahunAjaran)
    {
        try {
            $validated = $this->validate();
            $tahunAjaran->update([
                'tahun' => TA::concatTahunAjaran($validated['tahunAwal'], $validated['tahunAkhir']),
                'semester' => $validated['semester'],
                'aktif' => $validated['semesterAktif'],
            ]);

            session()->flash('success', 'Data Berhasil Diubah');
            $this->redirectRoute('tahunAjaranIndex');
        } catch (\Throwable $th) {
            $this->dispatch('showNotif', title: 'Gagal', description: 'Terjadi Suatu Kesalahan', icon: 'error');
        }
    }
}
