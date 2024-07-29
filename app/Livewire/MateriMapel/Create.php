<?php

namespace App\Livewire\MateriMapel;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\MateriMapel;
use Livewire\Component;
use App\Models\TahunAjaran;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Query\JoinClause;

class Create extends Component
{
    public $daftarGuru;
    public $daftarKelas;
    public $daftarMapel;
    public $formCreate;

    public $lingkupMateri;
    public $tujuanPembelajaran;

    public $tahunAjaranAktif;

    public $selectedGuru;
    public $selectedKelas;
    public $selectedMapel;

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

        if (Gate::allows('guru')) {
            $this->selectedGuru = Auth::id();
        }
    }

    public function getKelas()
    {
        $this->daftarKelas = '';
        $this->daftarMapel = '';
        $this->selectedMapel = '';
        $this->selectedKelas = '';

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
                ->select('mapel.id', 'mapel.nama_mapel', 'detail_guru_mapel.id as detail_guru_mapel_id')->get();
        }
    }

    public function extractId($value)
    {
        list($mapelId, $detailGuruMapelId) = explode('/', $value);
        return ['mapel_id' => $mapelId, 'detail_guru_mapel_id' => $detailGuruMapelId];
    }

    public function showForm()
    {
        $validated = $this->validate([
            'selectedGuru' => 'required',
            'selectedKelas' => 'required',
            'selectedMapel' => 'required',
        ], [
            'selectedGuru.required' => 'Guru field is required.',
            'selectedKelas.required' => 'Kelas field is required.',
            'selectedMapel.required' => 'Mapel field is required.',
        ]);

        if (is_null($this->selectedGuru) && is_null($this->selectedKelas) && is_null($this->selectedMapel)) return;
        $this->formCreate = 'true';
    }

    public function save()
    {
        $this->authorize('create', MateriMapel::class);
        $dataId = $this->extractId($this->selectedMapel);

        $validated = $this->validate([
            'lingkupMateri' => 'required|string|min:3|max:224',
            'tujuanPembelajaran' => 'required|string|min:3',
        ]);

        MateriMapel::create([
            'detail_guru_mapel_id' => $dataId['detail_guru_mapel_id'],
            'tujuan_pembelajaran' => $validated['tujuanPembelajaran'],
            'lingkup_materi' => $validated['lingkupMateri'],
        ]);

        $this->tujuanPembelajaran = '';
        $this->lingkupMateri = '';

        session()->flash('success', 'Data Berhasil Ditambahkan');
        redirect()->route('materiMapelIndex');
    }
}
