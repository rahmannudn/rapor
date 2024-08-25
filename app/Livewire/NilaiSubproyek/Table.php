<?php

namespace App\Livewire\NilaiSubproyek;

use App\Models\Kelas;
use App\Models\Proyek;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\NilaiProyek;
use App\Models\TahunAjaran;
use App\Models\CatatanProyek;
use App\Models\NilaiSubproyek;
use App\Helpers\FunctionHelper;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;

class Table extends Component
{
    #[Locked]
    public $waliKelasId;
    #[Locked]
    public Proyek $proyek;

    public $waliKelas;
    public $daftarKelas;
    public $daftarTahunAjaran;
    public $tahunAjaranAktif;
    public $selectedKelas;
    public $selectedProyek;

    public $nilaiData;
    public $showTable;
    public $proyekData = [];
    public $kelasInfo;
    public $daftarProyek;

    public function render()
    {
        return view('livewire.nilai-subproyek.table');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();
        $this->waliKelas = WaliKelas::where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('wali_kelas.user_id', auth()->id())
            ->select(
                'wali_kelas.id',
                'wali_kelas.kelas_id',
            )
            ->first();
        $this->waliKelasId = $this->waliKelas['id'];
        $this->selectedKelas = $this->waliKelas['kelas_id'];
        $this->getDaftarProyek();

        // $dataKelas = WaliKelas::searchAndJoinKelas($this->proyek['wali_kelas_id'])
        //     ->join('users', 'wali_kelas.user_id', '=', 'users.id')
        //     ->select('kelas.nama as nama_kelas', 'users.name as nama_guru')
        //     ->first();

        // if (Gate::allows('viewAny', NilaiSubproyek::class)) {
        // $this->daftarKelas = FunctionHelper::getDaftarKelasHasProyek($this->tahunAjaranAktif);

        // $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')
        //     ->orderBy('created_at')
        //     ->get();
    }

    public function showForm()
    {
        $this->showTable = true;
        // if (count($this->proyekData) == 0) $this->getProyek();
        $this->getKelasInfo();
        $this->getProyek();
    }

    public function getKelasInfo()
    {
        $this->kelasInfo = [];
        $waliKelas = WaliKelas::where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('wali_kelas.user_id', auth()->id())
            ->join('proyek', 'proyek.wali_kelas_id', 'wali_kelas.id')
            ->where('proyek.id', $this->selectedProyek)
            ->join('users', 'users.id', 'wali_kelas.user_id')
            ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'wali_kelas.tahun_ajaran_id')
            ->select(
                'wali_kelas.id',
                'proyek.judul_proyek as judul',
                'kelas.nama as nama_kelas',
                'users.name as nama_wali',
                'kelas.id as kelas_id',
                'kelas.fase',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester',
            )
            ->first();
        if ($waliKelas) {
            $this->kelasInfo['judul'] = $waliKelas['judul'];
            $this->kelasInfo['namaKelas'] = $waliKelas['nama_kelas'];
            $this->kelasInfo['fase'] = $waliKelas['fase'];
            $this->kelasInfo['tahunAjaran'] = $waliKelas['tahun'] . ' - ' . ucfirst($waliKelas['semester']);
            $this->kelasInfo['namaWaliKelas'] = $waliKelas['nama_wali'];
        }
    }

    public function getDaftarProyek()
    {
        $this->daftarProyek = [];
        $this->proyekData = [];

        if ($this->selectedKelas && $this->tahunAjaranAktif) {
            $this->daftarProyek = Proyek::query()
                ->joinAndSearchWaliKelas($this->tahunAjaranAktif, $this->selectedKelas)
                ->select(
                    'proyek.id',
                    'proyek.judul_proyek',
                )
                ->orderBy('proyek.created_at')
                ->get()
                ->toArray();

            if (count($this->daftarProyek) > 0) {
                $this->selectedProyek = $this->daftarProyek[0]['id'];
                $this->showTable && $this->getProyek();
            }
        }
    }

    public function getProyek()
    {
        $this->proyekData = [];
        if ($this->selectedKelas && $this->tahunAjaranAktif && $this->selectedProyek) {
            $this->proyek = Proyek::find($this->selectedProyek);

            $this->proyekData = Proyek::query()
                ->joinAndSearchWaliKelas($this->tahunAjaranAktif, $this->selectedKelas)
                ->where('proyek.id', '=', $this->selectedProyek)
                ->joinSubproyek()
                ->joinCapaianFase()
                ->joinSubelemen()
                ->joinElemen()
                ->joinDimensi()
                ->select(
                    'proyek.judul_proyek',
                    'capaian_fase.deskripsi as capaian_fase_deskripsi',
                    'dimensi.deskripsi as dimensi_deskripsi'
                )
                ->orderBy('capaian_fase.created_at')
                ->get()
                ->toArray();

            $this->getNilai();
        }
    }

    public function getNilai()
    {
        $this->nilaiData = [];

        if ($this->selectedKelas && $this->tahunAjaranAktif && $this->selectedProyek) {
            $nilai = Siswa::joinKelasSiswa()
                ->joinWaliKelasByKelasAndTahun($this->selectedKelas, $this->tahunAjaranAktif)
                ->searchAndJoinProyek($this->selectedProyek)
                ->joinSubproyek()
                ->leftJoinNilaiSubproyek()
                ->leftJoinCapaianFase()
                ->select(
                    'wali_kelas.id as wali_kelas_id',
                    'kelas_siswa.id as kelas_siswa_id',
                    'siswa.id as siswa_id',
                    'siswa.nama as nama_siswa',
                    'subproyek.id as subproyek_id',
                    'nilai_subproyek.id as nilai_subproyek_id',
                    'nilai_subproyek.nilai as nilai_subproyek',
                    'capaian_fase.deskripsi as capaian_fase_deskripsi'
                )
                ->orderBy('siswa.nama', 'ASC')
                ->orderBy('capaian_fase.created_at')
                ->get();

            $groupedData = $nilai->groupBy('siswa_id');
            if (count($groupedData) > 0) {
                $this->nilaiData =  NilaiSubproyek::convertNilaiData($groupedData);
                $this->waliKelasId = $nilai[0]['wali_kelas_id'];
            }
        }
    }

    public function update($dataIndex, $nilaiIndex)
    {
        $this->authorize('update', [NilaiSubproyek::class, $this->proyek]);

        // mengambil data siswa yang berubah
        $data = $this->nilaiData[$dataIndex];
        if (is_null($data['nilai']) && $data['nilai']) return;
        // mencari array sesuai index nilai yang berubah
        $updatedNilai = $data['nilai'][$nilaiIndex];

        $hasilNilai = NilaiSubproyek::updateOrCreate([
            'subproyek_id' => $updatedNilai['subproyek_id'],
            'kelas_siswa_id' => $data['kelas_siswa_id'],
        ], [
            'nilai' => $updatedNilai['nilai']
        ]);
    }
}
