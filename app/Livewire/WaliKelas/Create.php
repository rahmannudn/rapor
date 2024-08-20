<?php

namespace App\Livewire\WaliKelas;

use App\Models\User;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Helpers\FunctionHelper;
use Livewire\Attributes\Locked;

class Create extends Component
{
    public $daftarKelas;
    public $daftarGuru;

    #[Locked]
    public $tahunAjaranAktif;

    public $kelas;
    public $guru;

    public function render()
    {
        return view('livewire.wali-kelas.create');
    }

    public function mount()
    {
        $this->daftarKelas = Kelas::select('kelas.id', 'kelas.nama')->leftJoin('wali_kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->whereNull('wali_kelas.kelas_id')->get();

        $this->daftarGuru = User::select('users.id', 'users.name')
            ->leftJoin('wali_kelas', 'wali_kelas.user_id', 'users.id')
            ->where('role', 'guru')
            ->whereNull('wali_kelas.user_id')->get();

        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();


        if (!$this->tahunAjaranAktif) {
            $this->redirectRoute('waliKelasIndex');
            session()->flash('gagal', 'Harus ada Tahun Ajaran yang aktif!!');
        }
    }

    public function save()
    {
        if (!$this->tahunAjaranAktif) {
            session()->flash('gagal', 'Harus ada Tahun Ajaran yang aktif!!');
        }

        $validated = $this->validate([
            'kelas' => 'required',
            'guru' => 'required',
        ]);

        WaliKelas::create([
            'kelas_id' => $validated['kelas'],
            'user_id' => $validated['guru'],
            'tahun_ajaran_id' => $this->tahunAjaranAktif['id'],
        ]);

        $this->redirectRoute('waliKelasIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
