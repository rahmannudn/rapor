<?php

namespace App\Livewire\WaliKelas;

use App\Models\User;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    public WaliKelas $wali_kelas;
    public $kelas;
    public $guru;
    public $tahunAjaranAktif;


    public $daftarKelas;
    public $daftarGuru;


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.wali-kelas.edit');
    }

    public function mount()
    {
        $this->kelas = $this->wali_kelas['kelas_id'];
        $this->guru = $this->wali_kelas['user_id'];

        $this->daftarKelas = Kelas::all();
        $this->daftarGuru = User::select('users.id', 'users.name')
            ->leftJoin('wali_kelas', 'wali_kelas.user_id', 'users.id')
            ->where('role', 'guru')
            ->whereNull('wali_kelas.user_id')
            ->orWhere('wali_kelas.user_id', $this->wali_kelas['user_id'])->get();

        $this->tahunAjaranAktif = TahunAjaran::select('id')->where('aktif', 1)->first();
    }

    public function update(WaliKelas $wali_kelas)
    {
    }
}
