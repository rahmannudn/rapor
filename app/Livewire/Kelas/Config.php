<?php

namespace App\Livewire\Kelas;

use App\Models\User;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\GuruMapel;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Models\DetailGuruMapel;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;

use function PHPUnit\Framework\isNull;

class Config extends Component
{
    public Kelas $kelasData;
    public $daftarGuru;
    public $tahunAjaranAktif;

    // menyimpan id_user dari wali kelas tabel
    #[Locked]
    public $originWaliKelas;

    // menyimpan id_wali_kelas
    #[Locked]
    public $waliKelasId;

    // menyimpan id_user dari wali kelas tabel
    public $waliKelasAktif;

    public $dataMapelDanPengajar;
    public $originalMapelDanPengajar;

    public $savedMapelDanPengajar = [];
    public $selectedMapel;
    public $tempPengajar;
    public $daftarGuruMapel;

    public function render()
    {
        return view('livewire.kelas.config');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = TahunAjaran::select('id')->where('aktif', 1)->first()->toArray();

        $waliKelas = WaliKelas::where('kelas_id', $this->kelasData['id'])
            ->where('tahun_ajaran_id', $this->tahunAjaranAktif['id'])
            ->select('wali_kelas.id', 'wali_kelas.user_id')
            ->first();

        if ($waliKelas) {
            $waliKelas = $waliKelas->toArray();
            $this->waliKelasAktif = $waliKelas['user_id'];
            $this->originWaliKelas = $waliKelas['user_id'];
            $this->waliKelasId = $waliKelas['id'];
        }

        $this->daftarGuru = User::select('users.id', 'users.name')
            ->leftJoin('wali_kelas', 'wali_kelas.user_id', 'users.id')
            ->where('role', 'guru')
            ->whereNull('wali_kelas.user_id')
            ->when($this->originWaliKelas, function ($q) use ($waliKelas) {
                $q->orWhere('wali_kelas.user_id', $waliKelas['user_id']);
            })
            ->get()
            ->toArray();

        $this->showDaftarMapel();
    }

    public function showDaftarMapel()
    {
        $data = DB::table('mapel')
            ->leftJoin('detail_guru_mapel', function (JoinClause $join) {
                $join->on('detail_guru_mapel.mapel_id', '=', 'mapel.id')
                    ->where('detail_guru_mapel.kelas_id', '=', $this->kelasData['id']);
            })
            ->leftJoin('guru_mapel', 'detail_guru_mapel.guru_mapel_id', '=', 'guru_mapel.id')
            ->leftJoin('tahun_ajaran', function (JoinClause $join) {
                $join->on('tahun_ajaran.id', '=', 'guru_mapel.tahun_ajaran_id')
                    ->where('tahun_ajaran.id', '=', $this->tahunAjaranAktif['id']);
            })
            ->leftJoin('users', 'guru_mapel.user_id', '=', 'users.id')
            ->leftJoin('kelas', 'detail_guru_mapel.kelas_id', '=', 'kelas.id')
            ->where(function ($query) {
                $query->where('kelas.id', '=', $this->kelasData['id'])
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
        $this->daftarGuruMapel = User::select('id', 'name')->where('role', 'guru')->get();
    }

    public function updated($property)
    {
        if ($property === 'waliKelasAktif') return;

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
        if (count($this->savedMapelDanPengajar) === 0 && ($this->originWaliKelas === $this->waliKelasAktif)) {
            session()->flash('gagal', 'Tidak Ditemukan Perubahan Data');
            $this->redirectRoute('kelasConfig', ['kelasData' => $this->kelasData['id']]);
            return;
        }

        $waliKelasData = [
            'kelas_id' => $this->kelasData['id'],
            'user_id' => $this->waliKelasAktif,
            'tahun_ajaran_id' => $this->tahunAjaranAktif['id']
        ];

        if ($this->originWaliKelas)
            $waliKelasData['id'] = $this->waliKelasId; // Jika ada data lama, gunakan ID yang lama


        if ($this->originWaliKelas && !$this->waliKelasAktif) {
            $waliKelas = WaliKelas::find($this->waliKelasId);
            $waliKelas->user_id = null;
            $waliKelas->save();
        } else WaliKelas::updateOrCreate(['id' => $this->waliKelasId ?? 0], $waliKelasData);


        if (count($this->savedMapelDanPengajar) > 0) {
            foreach ($this->savedMapelDanPengajar as $data) {
                // mencari id guru mapel yang sesuai
                if (!$data['id_user']) {
                    $detail = DetailGuruMapel::where('kelas_id', '=', $this->kelasData['id'])->where('mapel_id', '=', $data['id_mapel'])->first();
                    $detail->delete();
                }

                if ($data['id_user']) {
                    $guruMapel = GuruMapel::firstOrCreate([
                        'user_id' => $data['id_user'],
                        'tahun_ajaran_id' => $this->tahunAjaranAktif['id']
                    ]);
                    // jika id_kelas dan id_mapel yang sesuai ditemukan, guru_mapel_id pada tabel detailGuruMapel akan diupdate
                    // jika tidak ditemukan maka akan membuat data baru pada tabel detail

                    DetailGuruMapel::updateOrCreate(
                        [
                            'kelas_id' => $this->kelasData['id'],
                            'mapel_id' => $data['id_mapel']
                        ],
                        [
                            'guru_mapel_id' => $guruMapel['id']
                        ]
                    );
                }
            }
        }

        $this->refreshAndSendMessage();
    }

    public function refreshAndSendMessage()
    {
        session()->flash('success', 'Data Berhasil Diubah');
        $this->redirectRoute('kelasConfig', ['kelasData' => $this->kelasData['id']]);
    }
}
