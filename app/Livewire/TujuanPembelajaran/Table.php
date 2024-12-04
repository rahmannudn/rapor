<?php

namespace App\Livewire\TujuanPembelajaran;

use App\Models\Kelas;
use App\Models\Mapel;
use Livewire\Component;
use App\Models\TahunAjaran;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Helpers\FunctionHelper;
use App\Models\TujuanPembelajaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

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
        $dataTP = '';
        // if (Gate::allows('isSuperAdmin')) {
        $dataTP = TujuanPembelajaran::query()
            ->search($this->searchQuery)
            ->joinDetailGuruMapel()
            ->searchAndJoinMapel($this->selectedMapel)
            ->searchAndJoinKelas($this->selectedKelas)
            ->joinGuruMapel()
            ->searchAndJoinUsers($this->selectedGuru)
            ->searchAndJoinTahunAjaran($this->selectedTahunAjaran)
            ->select(
                'tujuan_pembelajaran.id',
                'tujuan_pembelajaran.deskripsi as tujuan_pembelajaran_deskripsi',
                'mapel.nama_mapel',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester'
            )
            ->orderBy('tujuan_pembelajaran.created_at')
            ->orderBy('tahun_ajaran.tahun')
            ->orderBy('kelas.nama')
            ->orderBy('users.name')
            ->paginate($this->show);
        // }
        return view('livewire.tujuan-pembelajaran.table', compact('dataTP'));
    }

    public function mount()
    {
        $this->selectedTahunAjaran = Cache::get('tahunAjaranAktif');
        $this->daftarTahunAjaran = FunctionHelper::getDaftarTahunAjaranByWaliKelas();

        // $this->daftarKelas = Kelas::select('id', 'kelas', 'nama')->get();
        // $this->daftarMapel = Mapel::select('id', 'nama_mapel')->orderBy('nama_mapel', 'ASC')->get();

        // if (Gate::allows('isSuperAdmin'))
        //     $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')->get();

        if (Gate::allows('isGuru'))
            $this->selectedGuru = Auth::id();
    }
}
