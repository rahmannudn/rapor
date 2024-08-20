<?php

namespace App\Livewire\Proyek;

use App\Models\Proyek;
use App\Models\Dimensi;
use Livewire\Component;

use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Helpers\FunctionHelper;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Create extends Component
{
    // #[Locked]
    // public $tahunAjaranAktifId;
    #[Locked]
    public $capaianFaseId;
    #[Locked]
    public $kelasId;

    public $tahunAjaranAktif;
    public $daftarDimensi;
    public $daftarElemen;
    public $daftarSubelemen;
    public $capaianFase = '';

    public $selectedWaliKelas;
    public $selectedDimensi;
    public $selectedElemen;
    public $selectedSubelemen;

    public $judulProyek;
    public $deskripsi;

    // public $createForm;
    public function render()
    {
        $tahunAjaranAktifId = FunctionHelper::getTahunAjaranAktif();
        // $this->tahunAjaranAktif = TahunAjaran::find($tahunAjaranAktifId);
        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();
        $this->selectedWaliKelas = WaliKelas::where('tahun_ajaran_id', $tahunAjaranAktifId)
            ->where('user_id', Auth::id())
            ->select('id')
            ->first()
            ->toArray()['id'];

        // $daftarWaliKelas = '';
        // if (Gate::allows('isSuperAdmin')) {
        //     $daftarWaliKelas = WaliKelas::where('tahun_ajaran_id', '=', $this->tahunAjaranAktifId)
        //         ->joinUser()
        //         ->joinKelas()
        //         ->select('wali_kelas.id as wali_kelas_id', 'kelas.id as kelas_id', 'users.name as nama', 'kelas.nama as nama_kelas')
        //         ->get();
        // }

        return view('livewire.proyek.create');
    }

    // public function showForm()
    // {
    //     $validated = $this->validate([
    //         'selectedWaliKelas' => 'required'
    //     ], ['selectedWaliKelas.required' => 'Wali Kelas field is required.']);

    //     $this->validate(
    //         ['tahunAjaranAktif' => 'required'],
    //         ['tahunAjaranAktif.required' => 'Tahun Ajaran field is required.']
    //     );

    //     $this->createForm = true;
    // }

    public function save()
    {
        $this->authorize('create', Proyek::class);
        $validated = $this->validate([
            'judulProyek' => 'required|string',
            'deskripsi' => 'required',
            'selectedWaliKelas' => 'required',
        ]);

        Proyek::create([
            'wali_kelas_id' => $validated['selectedWaliKelas'],
            'judul_proyek' => $validated['judulProyek'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        $this->redirectRoute('proyekIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
