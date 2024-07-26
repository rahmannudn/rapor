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
        $this->tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first()['id'];
        if (Gate::allows('viewAny', NilaiSubproyek::class)) {
            $this->daftarKelas = FunctionHelper::getDaftarKelasHasProyek($this->tahunAjaranAktif);

            $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')
                ->orderBy('created_at')
                ->get();
        }

        if (Gate::allows('guru')) {
        }
    }

    public function showForm()
    {
        $this->validate(
            ['selectedKelas' => 'required',],
            ['selectedKelas.required' => 'Kelas field is required.',]
        );
        if (is_null($this->selectedKelas)) return;

        $this->showTable = true;
        if (count($this->proyekData) == 0) $this->getProyek();
    }

    public function getKelasInfo()
    {
        $this->kelasInfo = [];
        $waliKelas = '';

        $waliKelas = WaliKelas::where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('wali_kelas.kelas_id', $this->selectedKelas)
            ->select('wali_kelas.id')
            ->first();

        $data = null;
        if ($this->selectedKelas && $waliKelas) {
            $data = FunctionHelper::getKelasInfo($waliKelas['id']);
        }

        if ($data) {
            $proyek = Proyek::where('wali_kelas_id', '=', $waliKelas['id'])->select('judul_proyek as judul')->first();
            $this->kelasInfo['judul'] = $proyek['judul'];
            $this->kelasInfo['namaKelas'] = $data['nama_kelas'];
            $this->kelasInfo['fase'] = $data['fase'];
            $this->kelasInfo['tahunAjaran'] = $data['tahun'] . ' - ' . ucfirst($data['semester']);
        }

        if (Gate::allows('superAdminOrKepsek') && $waliKelas) {
            $waliKelasInfo = WaliKelas::where('wali_kelas.id', $waliKelas['id'])
                ->joinUser()
                ->select('users.name as nama_wali', 'wali_kelas.id as wali_kelas_id')
                ->first();
            $this->kelasInfo['namaWaliKelas'] = $waliKelasInfo['nama_wali'];
            $this->kelasInfo['waliKelasId'] = $waliKelasInfo['wali_kelas_id'];
        }
    }

    public function getDaftarProyek()
    {
        $this->daftarProyek = [];
        $this->proyekData = [];
        $this->getKelasInfo();

        if ($this->selectedKelas && $this->tahunAjaranAktif) {
            $this->daftarProyek = Proyek::query()
                ->joinAndSearchWaliKelas($this->tahunAjaranAktif, $this->selectedKelas)
                ->select(
                    'proyek.id',
                    'proyek.judul_proyek',
                )
                ->orderBy('proyek.created_at')
                ->get();

            if (count($this->daftarProyek) > 0) {
                $this->selectedProyek = $this->daftarProyek[0]['id'];
                $this->showTable && $this->getProyek();
            }
        }
    }

    public function getProyek()
    {
        if ($this->selectedKelas && $this->tahunAjaranAktif && $this->selectedProyek) {
            $this->proyekData = [];
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
                    'capaian_fase.id as capaian_fase_id',
                    'capaian_fase.deskripsi as capaian_fase_deskripsi',
                    'dimensi.deskripsi as dimensi_deskripsi'
                )
                ->orderBy('capaian_fase.created_at')
                ->get();

            $this->getNilai();
        }
    }

    public function getNilai()
    {
        $this->nilaiData = [];

        if ($this->selectedKelas && $this->tahunAjaranAktif && $this->selectedProyek) {
            $nilai = Siswa::joinKelasSiswa()
                ->joinWaliKelasByKelasAndTahun($this->selectedKelas, $this->tahunAjaranAktif) //join tabel wali kelas dan filter berdasar kelas dan tahun ajaran
                ->searchAndJoinProyek($this->selectedProyek)
                ->joinSubproyek()
                ->leftJoinNilaiSubproyek()
                ->leftJoinCapaianFase()
                ->select(
                    'siswa.id as siswa_id',
                    'siswa.nama as nama_siswa',
                    'subproyek.id as subproyek_id',
                    'nilai_subproyek.id as nilai_subproyek_id',
                    'nilai_subproyek.nilai as nilai_subproyek',
                    'capaian_fase.id as capaian_fase_id'
                )
                ->orderBy('siswa.nama')
                ->orderBy('capaian_fase.created_at')
                ->get();

            $groupedData = $nilai->groupBy('siswa_id');
            if (count($groupedData) > 0) {
                $this->nilaiData =  NilaiSubproyek::convertNilaiData($groupedData);
            }
        }
    }
}
