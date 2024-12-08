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
    public $tahunAjaranAktif;
    public $daftarTahunAjaran;

    public function mount()
    {
        $this->daftarTahunAjaran = TahunAjaran::all('id', 'semester', 'tahun');
        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();
    }

    #[On('updateData')]
    public function render()
    {
        $kelasData = Kelas::search($this->searchQuery)
            ->leftJoin('wali_kelas', function (JoinClause $join) {
                $join->on('wali_kelas.kelas_id', '=', 'kelas.id')
                    ->where('wali_kelas.tahun_ajaran_id', '=', $this->tahunAjaranAktif);
            })
            ->leftJoin('users', 'users.id', 'wali_kelas.user_id')
            ->where('kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->select('kelas.id as id', 'kelas.nama as nama', 'kelas.fase as fase', 'users.name as nama_guru')
            ->orderBy('kelas.nama', 'ASC')
            ->orderBy('kelas.created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.kelas.table', compact('kelasData'));
    }
}
