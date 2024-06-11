<?php

namespace App\Livewire\MateriMapel;

use App\Models\Kelas;
use App\Models\Mapel;
use Livewire\Component;
use App\Models\MateriMapel;
use App\Models\TahunAjaran;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Query\JoinClause;

class Table extends Component
{
    public $show = 10;
    public $searchQuery;
    public $selectedTahunAjaran;
    public $selectedKelas;
    public $selectedGuru;
    public $selectedMapel;

    public $daftarMapel;
    public $daftarTahunAjaran;
    public $daftarKelas;

    #[Layout('layouts.app')]
    public function render()
    {
        $dataMateriMapel = '';
        if (Gate::allows('isSuperAdmin')) {
            $dataMateriMapel = MateriMapel::query()
                ->search($this->searchQuery)
                ->joinDetailGuruMapel()
                ->joinGuruMapel()
                ->searchAndJoinKelas($this->selectedKelas)
                ->searchAndJoinMapel($this->selectedMapel)
                ->searchAndJoinTahunAjaran($this->selectedTahunAjaran)
                ->joinUsers()
                ->select(
                    'mapel.id as mapel_id',
                    'mapel.nama_mapel',
                    'materi_mapel.id as materi_mapel_id',
                    'materi_mapel.tujuan_pembelajaran',
                    'materi_mapel.lingkup_materi',
                    'kelas.nama as nama_rombel',
                    'kelas.kelas as tingkat_kelas',
                    'tahun_ajaran.tahun as tahun_ajaran',
                    'tahun_ajaran.semester as semester',
                    'users.name as nama_guru'
                )
                ->orderBy('materi_mapel.created_at', 'DESC')
                ->orderBy('tahun_ajaran.tahun', 'ASC')
                ->orderBy('kelas.kelas', 'ASC')
                ->paginate($this->show);
        }

        return view('livewire.materi-mapel.table', compact('dataMateriMapel'));
    }

    public function mount()
    {
        $this->selectedTahunAjaran = TahunAjaran::where('aktif', '1')->select('id')->first()['id'];
        $this->daftarKelas = Kelas::select('id', 'kelas', 'nama')->get();
        $this->daftarMapel = Mapel::select('id', 'nama_mapel')->orderBy('nama_mapel', 'ASC')->get();

        if (Gate::allows('isSuperAdmin'))
            $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')->get();
    }
}
