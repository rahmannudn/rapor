<?php

namespace App\Livewire\LingkupMateri;

use App\Models\LingkupMateri;
use Livewire\Component;
use App\Models\TahunAjaran;
use Illuminate\Database\Query\JoinClause;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Create extends Component
{
    public $daftarGuruMapel;
    public $daftarKelas;
    public $daftarMapel;
    public $formCreate;

    public $deskripsi;
    public $tahunAjaranAktif;

    public $selectedGuru;
    public $selectedKelas;
    public $selectedDetailGuruMapel;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.lingkup-materi.create');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first()['id'];
        if (Gate::allows('isSuperAdmin')) {
            // menampilkan kelas yang diajar, menampilkan mata pelajaran yang diajar
            $this->daftarGuruMapel = DB::table('users')
                ->join('guru_mapel', 'users.id', '=', 'guru_mapel.user_id')
                ->where('guru_mapel.tahun_ajaran_id', '=', $this->tahunAjaranAktif)
                ->select('users.name as nama_guru', 'guru_mapel.id')
                ->distinct()
                ->get();
        }

        if (Gate::allows('guru')) {
            $this->selectedGuru = Auth::id();
        }
    }

    public function getKelas()
    {
        $this->daftarKelas = '';
        $this->daftarMapel = '';
        $this->selectedDetailGuruMapel = '';
        $this->selectedKelas = '';

        if ($this->selectedGuru) {
            $this->daftarKelas = DB::table('detail_guru_mapel')
                ->join('guru_mapel', 'detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id')
                ->where('guru_mapel.id', '=', $this->selectedGuru)
                ->join('kelas', 'detail_guru_mapel.kelas_id', '=', 'kelas.id')
                ->select('kelas.id', 'kelas.nama')
                ->distinct()
                ->get();
        }
    }

    public function getMapel()
    {
        if ($this->selectedGuru && $this->selectedKelas) {
            $this->daftarMapel = DB::table('mapel')
                ->join('detail_guru_mapel', function (JoinClause $q) {
                    $q->on('detail_guru_mapel.mapel_id', '=', 'mapel.id')
                        ->where('detail_guru_mapel.kelas_id', '=', (int)$this->selectedKelas);
                })
                ->join('guru_mapel', function (JoinClause $q) {
                    $q->on('guru_mapel.id', '=', 'detail_guru_mapel.guru_mapel_id')
                        ->where('guru_mapel.id', '=', $this->selectedGuru);
                })
                ->select('mapel.nama_mapel', 'detail_guru_mapel.id as detail_guru_mapel_id')
                ->get();
        }
    }

    public function showForm()
    {
        $validated = $this->validate([
            'selectedGuru' => 'required',
            'selectedKelas' => 'required',
            'selectedDetailGuruMapel' => 'required',
        ], [
            'selectedGuru.required' => 'Guru field is required.',
            'selectedKelas.required' => 'Kelas field is required.',
            'selectedDetailGuruMapel.required' => 'Mapel field is required.',
        ]);

        if (is_null($this->selectedGuru) && is_null($this->selectedKelas) && is_null($this->selectedDetailGuruMapel)) return;
        $this->formCreate = 'true';
    }

    public function save()
    {
        $this->authorize('create', LingkupMateri::class);

        $validated = $this->validate([
            'selectedGuru' => 'required',
            'selectedKelas' => 'required',
            'selectedDetailGuruMapel' => 'required',
            'deskripsi' => 'required|string|min:3',
        ], [
            'selectedGuru.required' => 'Guru field is required.',
            'selectedKelas.required' => 'Kelas field is required.',
            'selectedDetailGuruMapel.required' => 'Mapel field is required.',
        ]);

        LingkupMateri::create(
            [
                'detail_guru_mapel_id' => $validated['selectedDetailGuruMapel'],
                'deskripsi' => $validated['deskripsi']
            ]
        );

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('lingkupMateriIndex');
    }
}
