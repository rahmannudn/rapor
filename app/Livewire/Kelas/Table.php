<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Database\Query\JoinClause;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;
    public $tahunAjaranAktif;

    #[On('updateData')]
    public function render()
    {
        $this->tahunAjaranAktif = TahunAjaran::select('id')->where('aktif', 1)->first();
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
