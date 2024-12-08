<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;
use App\Models\TahunAjaran;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Helpers\FunctionHelper;
use App\Models\Sekolah;
use App\Models\WaliKelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Query\JoinClause;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;
    public $selectedTahunAjaran;
    public $tahunAjaranAktif;
    public $daftarTahunAjaran;

    public function mount()
    {
        $this->daftarTahunAjaran = TahunAjaran::all('id', 'semester', 'tahun');
        $this->selectedTahunAjaran = FunctionHelper::getTahunAjaranAktif();
        $this->tahunAjaranAktif = $this->selectedTahunAjaran;
    }

    #[On('updateData')]
    public function render()
    {
        $kelasData = Kelas::search($this->searchQuery)
            ->leftJoin('wali_kelas', function (JoinClause $join) {
                $join->on('wali_kelas.kelas_id', '=', 'kelas.id')
                    ->where('wali_kelas.tahun_ajaran_id', '=', $this->selectedTahunAjaran);
            })
            ->leftJoin('users', 'users.id', 'wali_kelas.user_id')
            ->where('kelas.tahun_ajaran_id', '=', $this->selectedTahunAjaran)
            ->select('kelas.id as id', 'kelas.nama as nama', 'kelas.fase as fase', 'kelas.tahun_ajaran_id', 'users.name as nama_guru')
            ->orderBy('kelas.nama', 'ASC')
            ->orderBy('kelas.created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.kelas.table', compact('kelasData'));
    }
}
