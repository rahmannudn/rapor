<?php

namespace App\Livewire\CatatanProyek;

use App\Helpers\FunctionHelper;
use App\Models\Siswa;
use App\Models\Proyek;
use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\CatatanProyek;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Gate;

class Edit extends Component
{
    public $daftarKelas;
    public $daftarTahunAjaran;
    public $tahunAjaranAktif;
    public $selectedKelas;

    public $formCreate;
    public $proyekData;
    public $catatanSiswa;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.catatan-proyek.edit');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first()['id'];
        if (Gate::allows('viewAny', CatatanProyek::class)) {
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
            ['selectedKelas' => 'required'],
            ['selectedKelas.required' => 'Kelas field is required.',]
        );
        if (is_null($this->selectedKelas)) return;

        $this->formCreate = true;
    }

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

                // mengconvert collection yang memiliki id siswa yang sama menjadi satu array array dan memasukkan beberapa catatan ke dalam array tersebut
                $this->catatanSiswa = CatatanProyek::convertProyekData($groupedData);
                // dump($this->catatanSiswa[0]);
            }
        }
    }

    public function update(int $siswaIndex, string $proyekIndex)
    {
        $this->authorize('update', CatatanProyek::class);
        $data = $this->catatanSiswa[$siswaIndex]['catatan_proyek'][$proyekIndex];
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
