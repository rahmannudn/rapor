<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
use Livewire\Component;
use App\Models\TahunAjaran;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Helpers\FunctionHelper;
use Illuminate\Database\Query\JoinClause;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;
    public $tahunAjaranAktif;

    #[On('updateData')]
    public function render()
    {
        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();
        $kelasData = Kelas::search($this->searchQuery)
            ->leftJoin('wali_kelas', function (JoinClause $join) {
                $join->on('wali_kelas.kelas_id', '=', 'kelas.id')
                    ->where('wali_kelas.tahun_ajaran_id', '=', $this->tahunAjaranAktif['id']);
            })
            ->leftJoin('users', 'users.id', 'wali_kelas.user_id')
            ->select('kelas.id as id', 'kelas.nama as nama', 'kelas.fase as fase', 'users.name as nama_guru')
            ->orderBy('kelas.nama', 'ASC')
            ->orderBy('kelas.created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.kelas.table', compact('kelasData'));
    }
}
