<?php

namespace App\Livewire\LingkupMateri;

use App\Models\Kelas;
use App\Models\LingkupMateri;
use App\Models\Mapel;
use Livewire\Component;
use App\Models\TahunAjaran;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;
    public $selectedTahunAjaran;
    public $selectedKelas;
    public $selectedGuru;
    public $selectedMapel;

    public $daftarMapel;
    public $daftarTahunAjaran;
    public $daftarKelas;

    #[On('updateData')]
    public function render()
    {
        $dataLM = '';
        if (Gate::allows('isSuperAdmin')) {
            $dataLM = LingkupMateri::query()
                ->search($this->searchQuery)
                ->joinDetailGuruMapel()
                ->searchAndJoinMapel($this->selectedMapel)
                ->searchAndJoinKelas($this->selectedKelas)
                ->joinGuruMapel()
                ->searchAndJoinUsers($this->selectedGuru)
                ->searchAndJoinTahunAjaran($this->selectedTahunAjaran)
                ->select(
                    'lingkup_materi.id',
                    'lingkup_materi.deskripsi as lingkup_materi_deskripsi',
                    'mapel.nama_mapel',
                    'kelas.nama as nama_kelas',
                    'users.name as nama_guru',
                    'tahun_ajaran.tahun',
                    'tahun_ajaran.semester'
                )
                ->orderBy('lingkup_materi.created_at')
                ->orderBy('tahun_ajaran.tahun')
                ->orderBy('kelas.nama')
                ->orderBy('users.name')
                ->paginate($this->show);
        }

        return view('livewire.lingkup-materi.table', compact('dataLM'));
    }

    public function mount()
    {
        $this->selectedTahunAjaran = TahunAjaran::where('aktif', '1')->select('id')->first()['id'];
        $this->daftarKelas = Kelas::select('id', 'kelas', 'nama')->get();
        $this->daftarMapel = Mapel::select('id', 'nama_mapel')->orderBy('nama_mapel', 'ASC')->get();

        if (Gate::allows('isSuperAdmin'))
            $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')->get();

        if (Gate::allows('isGuru'))
            $this->selectedGuru = Auth::id();
    }
}
