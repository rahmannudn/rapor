<?php

namespace App\Livewire\GuruMapel;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use Livewire\Component;
use App\Models\GuruMapel;
use App\Models\TahunAjaran;
use App\Helpers\FunctionHelper;
use App\Models\DetailGuruMapel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class Create extends Component
{
    public $tahunAjaranAktif;
    public $daftarKelas;
    public $dataMapelDanPengajar;
    public $originalMapelDanPengajar;
    public $daftarGuru;

    public $savedMapelDanPengajar = [];
    public $kelas;
    public $selectedMapel;
    public $tempPengajar;

    public function render()
    {
        return view('livewire.guru-mapel.create');
    }

    public function mount()
    {
        $this->daftarKelas = Kelas::all();
        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();
    }

    public function showDaftarMapel()
    {
        $this->validate(['kelas' => 'required']);

        $data = DB::table('mapel')
            ->leftJoin('detail_guru_mapel', function (JoinClause $join) {
                $join->on('detail_guru_mapel.mapel_id', '=', 'mapel.id')
                    ->where('detail_guru_mapel.kelas_id', '=', $this->kelas);
            })
            ->leftJoin('guru_mapel', 'detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id')
            ->leftJoin('tahun_ajaran', function (JoinClause $join) {
                $join->on('tahun_ajaran.id', '=', 'guru_mapel.tahun_ajaran_id')
                    ->where('tahun_ajaran.id', '=', $this->tahunAjaranAktif);
            })
            ->leftJoin('users', 'guru_mapel.user_id', '=', 'users.id')
            ->leftJoin('kelas', 'detail_guru_mapel.kelas_id', '=', 'kelas.id')
            ->where(function ($query) {
                $query->where('kelas.id', '=', $this->kelas)
                    ->orWhereNull('kelas.id');
            })
            ->select(
                'users.id as id_user',
                'users.name as nama_user',
                'mapel.id as id_mapel',
                'mapel.nama_mapel as nama_mapel',
                'detail_guru_mapel.id as id_detail',
                'tahun_ajaran.id as id_tahun_ajaran'
            )
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })
            ->toArray();

        $this->dataMapelDanPengajar = array_map(function ($item) {
            return [
                'id_detail' => $item['id_detail'],
                'id_user' => $item['id_user'] ?? null,
                'nama_user' => $item['nama_user'] ?? '',
                'id_mapel' => $item['id_mapel'],
                'nama_mapel' => $item['nama_mapel'],
            ];
        }, $data);

        $this->originalMapelDanPengajar = $this->dataMapelDanPengajar;
        $this->daftarGuru = User::select('id', 'name')->where('role', 'guru')->get();
    }

    public function updated($property)
    {
        if ($property === 'kelas') return;

        $idUserIndex = explode('.', $property)[2];
        $idUser = (int)explode('.', $property)[1];

        $mapelPengajarChanged = (int) $this->dataMapelDanPengajar[$idUser][$idUserIndex];
        $originalMapelPengajar = $this->originalMapelDanPengajar[$idUser][$idUserIndex];

        if (!is_null($mapelPengajarChanged) && $mapelPengajarChanged === $originalMapelPengajar) return;
        $this->tempPengajar = $mapelPengajarChanged;
    }

    public function setMapel($idMapel)
    {
        $arr = ['id_mapel' => $idMapel, 'id_user' => $this->tempPengajar];
        array_push($this->savedMapelDanPengajar, $arr);
    }

    public function save()
    {
        if (count($this->savedMapelDanPengajar) === 0) {
            session()->flash('gagal', 'Tidak Ditemukan Perubahan Data');
            return;
        }

        foreach ($this->savedMapelDanPengajar as $data) {
            // mencari id guru mapel yang sesuai
            $guruMapel = GuruMapel::firstOrCreate([
                'user_id' => $data['id_user'],
                'tahun_ajaran_id' => $this->tahunAjaranAktif
            ]);
            // GuruMapel::select('id')->where('user_id', $data['id_user'])->first()
            // jika id_kelas dan id_mapel yang sesuai ditemukan, guru_mapel_id pada tabel detailGuruMapel akan diupdate
            // jika tidak ditemukan maka akan membuat data baru pada tabel detail

            DetailGuruMapel::updateOrCreate(
                [
                    'kelas_id' => $this->kelas,
                    'mapel_id' => $data['id_mapel']
                ],
                [
                    'guru_mapel_id' => $guruMapel['id']
                ]
            );
        }

        session()->flash('success', 'Data Berhasil Diubah');
        $this->redirectRoute('guruMapelCreate');
    }
}
