<?php

namespace App\Livewire\Subproyek;

use App\Models\Kelas;
use App\Models\Elemen;
use App\Models\Dimensi;
use Livewire\Component;
use App\Models\Subelemen;
use App\Models\Subproyek;
use App\Models\CapaianFase;
use App\Models\TahunAjaran;
use App\Helpers\FunctionHelper;
use App\Models\Proyek;
use Livewire\Attributes\Locked;

class Form extends Component
{
    public $proyekId;

    #[Locked]
    public $tahunAjaranAktifId;

    public $forms;

    public $daftarDimensi;

    public function render()
    {
        $this->tahunAjaranAktifId = FunctionHelper::getTahunAjaranAktif();

        return view('livewire.subproyek.form');
    }

    public function mount()
    {
        $subproyekData = Subproyek::searchAndJoinProyek($this->proyekId)
            ->joinCapaianFase()
            ->joinSubelemen()
            ->joinElemen()
            ->select(
                'capaian_fase.deskripsi as capaian_fase_deskripsi',
                'subproyek.capaian_fase_id',
                'subproyek.id as subproyek_id',
                'capaian_fase.subelemen_id',
                'subelemen.elemen_id',
                'elemen.dimensi_id',
            )
            ->get();

        $this->daftarDimensi = Dimensi::select('deskripsi', 'id')->orderBy('created_at')->get();

        // Tambahkan satu form kosong jika belum ada subproyek
        count($subproyekData) < 1 && $this->addForm();

        // Jika ada data awal, loop data tersebut dan tambahkan ke forms
        if (!empty($subproyekData)) {
            foreach ($subproyekData as $data) {
                $form = [
                    'selectedDimensi' => $data['dimensi_id'] ?? '',
                    'selectedElemen' => $data['elemen_id'] ?? '',
                    'selectedSubelemen' => $data['subelemen_id'] ?? '',
                    'capaianFase' => $data['capaian_fase_deskripsi'] ?? '',
                    'capaianFaseId' => $data['capaian_fase_id'] ?? '',
                    'subproyekId' => $data['subproyek_id'] ?? '',
                ];

                // Load daftar elemen jika selectedDimensi ada
                if (!empty($form['selectedDimensi'])) {
                    $form['daftarElemen'] = Elemen::select('deskripsi', 'id')
                        ->where('dimensi_id', $form['selectedDimensi'])
                        ->orderBy('created_at')
                        ->get();
                }

                // Load daftar subelemen jika selectedElemen ada
                if (!empty($form['selectedElemen'])) {
                    $form['daftarSubelemen'] = Subelemen::select('deskripsi', 'id')
                        ->where('elemen_id', $form['selectedElemen'])
                        ->orderBy('created_at')
                        ->get();
                }

                $this->forms[] = $form;
            }
        }
    }

    public function addForm()
    {
        $this->forms[] = [
            'selectedDimensi' => '',
            'selectedElemen' => '',
            'selectedSubelemen' => '',
            'capaianFase' => '',
            'subproyekId' => '',
        ];
    }

    public function removeForm($index)
    {
        if ($this->forms[$index]['subproyekId'] !== "") {
            $subproyekId = $this->forms[$index]['subproyekId'];
            $subproyek = Subproyek::find($subproyekId);
            $this->authorize('delete', [Subproyek::class, $subproyek]);
            if (!$subproyek) {
                $this->dispatch('showNotif', title: 'Gagal', description: 'Data Tidak Ditemukan', icon: 'success');
            }
            $subproyek->delete();
        }

        unset($this->forms[$index]);
        $this->forms = array_values($this->forms); // Re-index array
    }

    public function getElemen($index)
    {
        if ($this->forms[$index]['selectedDimensi']) {
            // Reset elemen, subelemen, dan capaian fase
            $this->forms[$index]['selectedElemen'] = '';
            $this->forms[$index]['selectedSubelemen'] = '';
            $this->forms[$index]['capaianFase'] = '';

            // Ambil data elemen berdasarkan dimensi yang dipilih
            $this->forms[$index]['daftarElemen'] = Elemen::select('deskripsi', 'id')
                ->where('dimensi_id', $this->forms[$index]['selectedDimensi'])
                ->orderBy('created_at')
                ->get();
        }
    }

    public function getSubelemen($index)
    {
        if ($this->forms[$index]['selectedDimensi'] && $this->forms[$index]['selectedElemen']) {
            // Reset subelemen dan capaian fase
            $this->forms[$index]['selectedSubelemen'] = '';
            $this->forms[$index]['capaianFase'] = '';

            // Ambil data subelemen berdasarkan elemen yang dipilih
            $this->forms[$index]['daftarSubelemen'] = Subelemen::select('deskripsi', 'id')
                ->where('elemen_id', $this->forms[$index]['selectedElemen'])
                ->orderBy('created_at')
                ->get();
        }
    }

    public function getCapaianFase($index)
    {
        if ($this->forms[$index]['selectedDimensi'] && $this->forms[$index]['selectedElemen'] && $this->forms[$index]['selectedSubelemen']) {
            $fase = Kelas::joinWaliKelas($this->tahunAjaranAktifId)
                ->joinProyek()
                ->where('proyek.id', '=', $this->proyekId)
                ->select('kelas.fase')
                ->first();

            $data = CapaianFase::where('subelemen_id', '=', $this->forms[$index]['selectedSubelemen'])
                ->where('fase', '=', $fase['fase'])
                ->select('deskripsi', 'id')->first();

            $this->forms[$index]['capaianFase'] = $data['deskripsi'] ?? '';
            $this->forms[$index]['capaianFaseId'] = $data['id'] ?? '';
        }
    }


    public function save()
    {
        $proyek = Proyek::find($this->proyekId);
        $this->authorize('create', [Subproyek::class, $proyek]);

        foreach ($this->forms as $value) {
            // jika capaian fase tidak ada
            if (!$value['capaianFaseId']) continue;
            Subproyek::updateOrCreate([
                'id' => $value['subproyekId'],
                'proyek_id' => $this->proyekId
            ], [
                'proyek_id' => $this->proyekId,
                'capaian_fase_id' => $value['capaianFaseId']
            ]);
        }

        session()->flash('success', 'Data Berhasil Disimpan');
        $this->redirectRoute('subproyekIndex', ['proyek' => $this->proyekId]);
    }
}
