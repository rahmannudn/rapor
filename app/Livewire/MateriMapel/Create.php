<?php

namespace App\Livewire\MateriMapel;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use Livewire\Component;
use App\Models\TahunAjaran;
use Livewire\Attributes\Layout;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Query\JoinClause;

class Create extends Component
{
    public $daftarGuru;
    public $daftarKelas;
    public $daftarMapel;

    public $tahunAjaranAktif;
    public $selectedGuru;
    public $selectedKelas;
    public $selectedMapel;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.materi-mapel.create');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first()['id'];
        if (Gate::allows('isSuperAdmin')) {
            $this->daftarGuru = User::where('role', 'guru')->leftJoin('guru_mapel', function (JoinClause $join) {
                $join->on('guru_mapel.user_id', '=', 'users.id')
                    ->where('guru_mapel.tahun_ajaran_id', '=', (int)$this->tahunAjaranAktif);
            })->select('users.name', 'users.id')->get();
        }
    }

    public function updated($property)
    {
        dump($property);
    }

    public function getKelas()
    {
        if ($this->selectedGuru) {
            $this->daftarKelas = Kelas::join('detail_guru_mapel', 'detail_guru_mapel.kelas_id', '=', 'kelas.id')
                ->join('guru_mapel', function (JoinClause $join) {
                    $join->on('guru_mapel.id', '=', 'detail_guru_mapel.guru_mapel_id')
                        ->where('guru_mapel.user_id', '=', (int)$this->selectedGuru)
                        ->where('guru_mapel.tahun_ajaran_id', '=', (int)$this->tahunAjaranAktif);
                })->select('kelas.id', 'kelas.nama')->distinct()->get();
        }
    }

    public function getMapel()
    {
        if ($this->selectedGuru && $this->selectedKelas) {
            $this->daftarMapel = Mapel::join('detail_guru_mapel', function (JoinClause $join) {
                $join->on('detail_guru_mapel.mapel_id', '=', 'mapel.id')
                    ->where('detail_guru_mapel.kelas_id', '=', (int)$this->selectedKelas);
            })
                ->join('guru_mapel', function (JoinClause $join) {
                    $join->on('guru_mapel.id', '=', 'detail_guru_mapel.guru_mapel_id')
                        ->where('guru_mapel.user_id', '=', (int)$this->selectedGuru);
                })
                ->join('tahun_ajaran', function (JoinClause $join) {
                    $join->on('tahun_ajaran.id', 'guru_mapel.tahun_ajaran_id')
                        ->where('guru_mapel.tahun_ajaran_id', '=', (int)$this->tahunAjaranAktif);
                })
                ->select('mapel.id as mapel_id', 'mapel.nama_mapel')->get();
        }
    }


    public function save()
    {
    }
}
