<?php

namespace App\Livewire\TahunAjaran;

use App\Models\Kepsek;
use Livewire\Component;
use App\Rules\IsValidYear;
use App\Models\TahunAjaran;
use Livewire\Attributes\Title;
use App\Helpers\FunctionHelper;
use Livewire\Attributes\Locked;
use App\Models\TahunAjaran as TA;

class Edit extends Component
{
    public TA $tahunAjaran;

    public $years = [];

    public $tahunAwal;
    public $tahunAkhir;
    public $semester;
    public $semesterAktif;
    public $confirmModal;
    public $daftarTahunAjaran;
    public $prevTahunAjaran;
    public $tglRapor;
    public $daftarKepsek;
    public $selectedKepsek;

    #[Locked]
    public $validatedData;

    public function mount()
    {
        $this->years = FunctionHelper::getDynamicYear();
        $this->tahunAwal = TA::getTahunAwal($this->tahunAjaran['tahun']);
        $this->tahunAkhir = TA::getTahunAkhir($this->tahunAjaran['tahun']);
        $this->semester = $this->tahunAjaran['semester'];
        $this->semesterAktif = $this->tahunAjaran['aktif'];
        $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')->get()->toArray();
        $this->daftarKepsek = Kepsek::join('tahun_ajaran', 'tahun_ajaran.kepsek_id', 'kepsek.id')
            ->join('users', 'users.id', 'kepsek.user_id')
            ->select('users.name as nama_kepsek', 'kepsek.id')
            ->get();

        $this->selectedKepsek = Kepsek::where('id', $this->tahunAjaran['kepsek_id'])
            ->select('id')
            ->first()?->id;
        $this->prevTahunAjaran = $this->tahunAjaran['prev_tahun_ajaran_id'];
        $this->tglRapor = $this->tahunAjaran['tgl_rapor'];
    }

    public function render()
    {
        return view('livewire.tahun-ajaran.edit');
    }

    public function update($id = null)
    {
        $this->authorize('update', TahunAjaran::class);

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
            'aktif' => $this->validatedData['semesterAktif'],
            'prev_tahun_ajaran_id' => $this->validatedData['prevTahunAjaran'],
            'tgl_rapor' => $this->tglRapor,
            'kepsek_id' => $this->validatedData['selectedKepsek'],
        ]);

        if ($tahunAjaran['aktif'] == 1)
            FunctionHelper::setCacheInfoSekolah();

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
            'semesterAktif' => ['required', 'boolean'],
            'prevTahunAjaran' => ['nullable', 'integer'],
            'tglRapor' => ['nullable', 'date'],
            'selectedKepsek' => ['required']
        ];
    }

    public function edit(TA $tahunAjaran)
    {
        try {
            $validated = $this->validate();
            $this->validatedData = $validated;

            if ($this->tahunAjaran['aktif'] == 1 && $this->validatedData['semesterAktif'] == 0) return;

            if ($validated['semesterAktif'] == 0) {
                $this->validatedData['semesterAktif'] = $validated['semesterAktif'];
                $this->validatedData = $validated;
                $this->update();
                return;
            }

            // jika semester aktif bernilai 1
            $semesterSedangAktif = TA::firstWhere('aktif', 1);

            // jika tidak ditemukan semester yang sedang aktif
            if ($semesterSedangAktif->id == $tahunAjaran->id) {
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
