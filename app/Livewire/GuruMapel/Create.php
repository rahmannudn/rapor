<?php

namespace App\Livewire\GuruMapel;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use Livewire\Component;
use App\Models\GuruMapel;
use App\Models\TahunAjaran;
use App\Models\DetailGuruMapel;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class Create extends Component
{
    public $tahunAjaranAktif;
    public $daftarKelas;
    public $dataMapelDanPengajar;
    public $daftarGuru;

    public $guru;
    public $selectedKelas;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.guru-mapel.create');
    }

    public function mount()
    {
        $this->daftarKelas = Kelas::all();
        $this->tahunAjaranAktif = TahunAjaran::select('id', 'tahun', 'semester', 'aktif')->where('aktif', '1')->first();
    }

    public function showDaftarMapel()
    {
        $this->validate(['selectedKelas' => 'required']);
        // mencari daftar pengajar mapel pada kelas yang ditentukan
        $this->dataMapelDanPengajar = DB::table('mapel')
            ->leftJoin('detail_guru_mapel', function (JoinClause $join) {
                $join->on('detail_guru_mapel.mapel_id', '=', 'mapel.id')
                    ->where('detail_guru_mapel.kelas_id', '=', $this->selectedKelas);
            })
            ->leftJoin('guru_mapel', 'detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id')
            ->leftJoin('users', 'guru_mapel.user_id', '=', 'users.id')
            ->leftJoin('kelas', 'detail_guru_mapel.kelas_id', '=', 'kelas.id')
            ->where(function ($query) {
                $query->where('kelas.id', '=', $this->selectedKelas)
                    ->orWhereNull('kelas.id');
            })
            ->select(
                'users.id as id_user',
                'mapel.id as id_mapel',
                'mapel.nama_mapel as nama_mapel',
                'detail_guru_mapel.id as id_detail'
            )
            ->get();
        $this->daftarGuru = User::select('id', 'name')->where('role', 'guru')->get();

        // DetailGuruMapel::select(
        //     'users.id as id_user',
        //     'users.name as nama_user',
        //     'mapel.id as id_mapel',
        //     'mapel.nama_mapel as nama_mapel'
        // )
        //     ->join('guru_mapel', 'guru_mapel.id', 'detail_guru_mapel.guru_mapel_id')
        //     ->join('mapel', 'mapel.id', 'detail_guru_mapel.mapel_id')
        //     ->join('kelas', 'kelas.id', 'detail_guru_mapel.kelas_id')
        //     ->join('users', 'users.id', 'guru_mapel.user_id')
        //     ->where('detail_guru_mapel.kelas_id', $this->selectedKelas)
        //     ->where('guru_mapel.tahun_ajaran_id', $this->tahunAjaranAktif['id'])->get();


    }
}
