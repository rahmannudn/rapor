<?php

namespace App\Livewire\Proyek;

use App\Models\Kelas;
use App\Models\Proyek;
use App\Models\TahunAjaran;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\Gate;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Create extends Component
{
    #[Locked]
    public $tahunAjaranAktif;

    public $createForm;
    public $selectedWaliKelas;

    public $judulProyek;
    public $deskripsi;
    public $daftarTahunAjaran;

    #[Layout('layouts.app')]
    public function render()
    {
        $this->tahunAjaranAktif = TahunAjaran::select('id')->where('aktif', 1)->first()['id'];

        $daftarWaliKelas = '';
        if (Gate::allows('isSuperAdmin')) {
            $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')->orderBy('created_at')->get();
            $daftarWaliKelas = WaliKelas::where('tahun_ajaran_id', '=', $this->tahunAjaranAktif)
                ->joinUser()
                ->joinKelas()
                ->select('wali_kelas.id as wali_kelas_id', 'users.name as nama', 'kelas.nama as nama_kelas')
                ->get();
        }

        return view('livewire.proyek.create', compact('daftarWaliKelas'));
    }

    public function showForm()
    {
        $this->validate([
            'selectedWaliKelas' => 'required'
        ], ['selectedWaliKelas.required' => 'Wali Kelas field is required.']);

        if (Gate::allows('isSuperAdmin')) {
            $this->validate(
                ['tahunAjaranAktif' => 'required'],
                ['tahunAjaranAktif.required' => 'Tahun Ajaran field is required.']
            );
        }

        $this->createForm = true;
    }

    public function save()
    {
        $this->authorize('create', Proyek::class);
        $validated = $this->validate([
            'judulProyek' => 'required|string',
            'deskripsi' => 'required'
        ]);

        Proyek::create([
            'wali_kelas_id' => $this->selectedWaliKelas,
            'judul_proyek' => $validated['judulProyek'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        $this->redirectRoute('proyekIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
