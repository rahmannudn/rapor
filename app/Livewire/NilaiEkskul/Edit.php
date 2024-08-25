<?php

namespace App\Livewire\NilaiEkskul;

use App\Models\Siswa;
use App\Models\Ekskul;
use Livewire\Component;
use App\Models\NilaiEkskul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    public NilaiEkskul $data;
    #[Locked]
    public $kelas;

    public $daftarSiswa = [];
    public $daftarEkskul = [];
    public $selectedEkskul;
    public $deskripsi;
    public $tahunAjaranAktif;
    public $namaSiswa;
    public $selectedSiswa;

    public function render()
    {
        return view('livewire.nilai-ekskul.edit');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');

        $this->kelas = NilaiEkskul::where('nilai_ekskul.id', $this->data['id'])
            ->join('kelas_siswa', 'kelas_siswa.id', 'nilai_ekskul.kelas_siswa_id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->join('siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->select(
                'kelas_siswa.kelas_id as id',
                'siswa.nama as nama_siswa',
                'siswa.id as id_siswa',
                'kelas_siswa.id as kelas_siswa_id'
            )
            ->first()
            ->toArray();

        $this->selectedSiswa = $this->kelas['kelas_siswa_id'];
        $this->selectedEkskul = $this->data['ekskul_id'];
        $this->deskripsi = $this->data['deskripsi'];

        $this->namaSiswa = $this->kelas['nama_siswa'];

        $this->daftarEkskul = Ekskul::select('id', 'nama_ekskul')
            ->get()
            ->toArray();

        $this->daftarSiswa = Siswa::join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->leftJoin('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.kelas_id')
            ->where('wali_kelas.user_id', '=', Auth::id())
            ->select(
                'siswa.nama as nama_siswa',
                'siswa.id as siswa_id',
                'kelas_siswa.id as kelas_siswa_id',
            )
            ->orderBy('siswa.nama', 'ASC')
            ->get()
            ->toArray();
    }

    public function update(NilaiEkskul $data)
    {
        $validated = $this->validate(
            [
                'selectedEkskul' => 'required',
                'selectedSiswa' => 'required',
                'deskripsi' => 'required|string|min:4|max:150',
            ],
            [
                'selectedEkskul.required' => 'Ekskul field is required.',
                'selectedSiswa.required' => 'Siswa field is required.',
            ]
        );

        $this->authorize('update', [NilaiEkskul::class, $data]);
        $data->update([
            'ekskul_id' => $validated['selectedEkskul'],
            'kelas_siswa_id' => $validated['selectedSiswa'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        $this->redirectRoute('nilaiEkskulIndex');
        session()->flash('success', 'Data Berhasil diubah');
    }
}
