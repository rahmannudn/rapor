<?php

namespace App\Livewire\CatatanProyek;

use App\Models\Siswa;
use App\Models\Proyek;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Models\CatatanProyek;
use App\Helpers\FunctionHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Edit extends Component
{
    public $kelasNama;
    public $namaWaliKelas;

    public $daftarKelas;
    public $daftarTahunAjaran;
    public $tahunAjaranAktif;
    public $selectedKelas;

    public $formCreate;
    public $proyekData;
    public $catatanSiswa;

    public function render()
    {
        return view('livewire.catatan-proyek.edit');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();

        $waliKelas = WaliKelas::join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
            ->where('tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('user_id', auth()->id())
            ->join('users', 'wali_kelas.user_id', 'users.id')
            ->select(
                'wali_kelas.id as wali_kelas_id',
                'wali_kelas.kelas_id as kelas_id',
                'kelas.nama as nama_kelas',
                'users.name as nama_wali'
            )
            ->first();

        $this->kelasNama = $waliKelas['nama_kelas'];
        $this->namaWaliKelas = $waliKelas['nama_wali'];
        $this->selectedKelas = $waliKelas['kelas_id'];

        $this->getCatatan();
    }

    // public function showForm()
    // {
    //     $this->validate(
    //         ['selectedKelas' => 'required'],
    //         ['selectedKelas.required' => 'Kelas field is required.',]
    //     );
    //     if (is_null($this->selectedKelas)) return;

    //     $this->formCreate = true;
    // }

    public function getCatatan()
    {
        $this->proyekData = '';
        $this->catatanSiswa = '';
        if ($this->selectedKelas && $this->tahunAjaranAktif) {
            $this->proyekData = Proyek::joinWaliKelas()
                ->where('wali_kelas.tahun_ajaran_id', $this->tahunAjaranAktif)
                ->where('wali_kelas.kelas_id', $this->selectedKelas)
                ->select(
                    'proyek.id',
                    'proyek.judul_proyek',
                )
                ->orderBy('proyek.created_at')
                ->get();

            if (count($this->proyekData) >= 1) {
                $catatanData = Siswa::joinKelasSiswa()
                    ->joinWaliKelasByKelasAndTahun($this->selectedKelas, $this->tahunAjaranAktif) //join tabel wali kelas dan filter berdasar kelas dan tahun ajaran
                    ->leftJoinProyek()
                    ->leftJoin('catatan_proyek', function ($join) {
                        $join->on('siswa.id', '=', 'catatan_proyek.siswa_id')
                            ->on('proyek.id', '=', 'catatan_proyek.proyek_id');
                    })
                    ->select(
                        'siswa.id as siswa_id',
                        'siswa.nama as nama_siswa',
                        'catatan_proyek.catatan',
                        'catatan_proyek.id as catatan_id',
                        'proyek.id as proyek_id',
                    )
                    ->orderBy('siswa.nama')
                    ->orderBy('proyek.created_at')
                    ->get();

                $groupedData = $catatanData->groupBy('siswa_id');

                if (count($catatanData) > 0) {
                    // mengconvert collection yang memiliki id siswa yang sama menjadi satu array array dan memasukkan beberapa catatan ke dalam array tersebut
                    $this->catatanSiswa = CatatanProyek::convertProyekData($groupedData);
                }
            }
        }
    }

    public function update(int $siswaIndex, string $proyekIndex)
    {
        $data = $this->catatanSiswa[$siswaIndex]['catatan_proyek'][$proyekIndex];
        $proyek = Proyek::find($data['proyek_id']);

        $this->authorize('update', [CatatanProyek::class, $proyek]);
        if (is_null($data['catatan']) && $data['catatan']) return;
        $siswaId = $this->catatanSiswa[$siswaIndex]['siswa_id'];

        CatatanProyek::updateOrCreate(
            [
                'proyek_id' => $data['proyek_id'],
                'siswa_id' => $siswaId,
            ],
            [
                'catatan' => $data['catatan'],
            ]
        );
    }

    public function save()
    {
        session()->flash('success', 'Data Berhasil Diubah');
        redirect()->route('catatanProyekIndex');
    }
}
