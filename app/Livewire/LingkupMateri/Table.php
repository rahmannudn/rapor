<?php

namespace App\Livewire\LingkupMateri;

use App\Models\Kelas;
use App\Models\Mapel;
use Livewire\Component;
use App\Models\GuruMapel;
use App\Models\TahunAjaran;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Maatwebsite\Excel\Excel;
use App\Models\LingkupMateri;
use App\Helpers\FunctionHelper;
use App\Exports\LingkupMateriExport;
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

    // public $daftarMapel;
    public $daftarTahunAjaran;
    // public $daftarKelas;

    #[On('updateData')]
    public function render()
    {
        $dataLM = '';
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
            // ->orderBy('kelas.nama')
            ->orderBy('users.name')
            ->paginate($this->show);

        return view('livewire.lingkup-materi.table', compact('dataLM'));
    }

    public function mount()
    {
        $this->selectedTahunAjaran = Cache::get('tahunAjaranAktif');
        // $this->daftarKelas = Kelas::select('id', 'kelas', 'nama')->get();
        // $this->daftarMapel = Mapel::select('id', 'nama_mapel')->orderBy('nama_mapel', 'ASC')->get();

        $this->daftarTahunAjaran = FunctionHelper::getDaftarTahunAjaranByWaliKelas();

        if (Gate::allows('isGuru'))
            $this->selectedGuru = Auth::id();
    }

    public function exportExcel()
    {
        return (new LingkupMateriExport(
            tahunAjaran: $this->selectedTahunAjaran,
            mapel: $this->selectedMapel,
            kelas: $this->selectedKelas,
            guru: $this->selectedGuru
        ))->download('daftar_lingkup_materi.xlsx', Excel::XLSX);
    }
}
