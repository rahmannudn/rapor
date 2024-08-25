<?php

namespace App\Livewire\NilaiEkskul;

use App\Models\Siswa;
use App\Models\Ekskul;
use App\Models\KelasSiswa;
use App\Models\NilaiEkskul;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Create extends Component
{
    public $tahunAjaranAktif;
    public $daftarSiswa = [];
    public $daftarEkskul = [];
    public $selectedEkskul;
    public $selectedSiswa;
    public $deskripsi;

    public function render()
    {
        return view('livewire.nilai-ekskul.create');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');

        $this->daftarEkskul = Ekskul::select('id', 'nama_ekskul')
            ->get()
            ->toArray();

        $this->daftarSiswa = Siswa::join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->leftJoin('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.kelas_id')
            ->where('wali_kelas.user_id', '=', Auth::id())
            ->select(
                'siswa.nama as nama_siswa',
                'siswa.id',
                'kelas_siswa.id as kelas_siswa_id',
            )
            ->orderBy('siswa.nama', 'ASC')
            ->get()
            ->toArray();
    }

    public function save()
    {
        $validated = $this->validate(
            [
                'selectedEkskul' => 'required',
                'selectedSiswa' => 'required',
                'deskripsi' => 'required|string|min:5|max:150',
            ],
            [
                'selectedEkskul.required' => 'Ekskul field is required.',
                'selectedSiswa.required' => 'Siswa field is required.',
            ]
        );

        NilaiEkskul::create([
            'ekskul_id' => $validated['selectedEkskul'],
            'kelas_siswa_id' => $validated['selectedSiswa'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        $this->redirectRoute('nilaiEkskulIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
