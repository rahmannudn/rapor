<?php

namespace App\Livewire\Kepsek;

use App\Models\User;
use App\Models\Kepsek;
use Livewire\Component;
use App\Rules\IsValidYear;
use App\Models\TahunAjaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Illuminate\Database\Query\JoinClause;

class Edit extends Component
{
    public Kepsek $kepsek;
    public $daftarTahunAjaran;

    public $periodeAwal;
    public $periodeAkhir;
    public $selectedKepsek;
    public $aktif;

    public $confirmModal;
    #[Locked]
    public $validatedData;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.kepsek.edit');
    }

    public function mount($kepsek)
    {
        $this->daftarTahunAjaran = TahunAjaran::select('tahun', 'semester', 'aktif', 'id')
            ->orderBy('tahun')
            ->get();
        $this->periodeAwal = $this->kepsek['awal_menjabat'];
        $this->periodeAkhir = $this->kepsek['akhir_menjabat'];
        $this->aktif = $this->kepsek['aktif'];
    }

    public function saveData($id = null)
    {
        if ($id) {
            $kepsekAktif = Kepsek::find($id);
            if ($kepsekAktif) {
                $kepsekAktif['aktif'] = 0;
                $kepsekAktif->save();
            }
        }

        $data = [
            'awal_menjabat' => $this->validatedData['periodeAwal'],
            'aktif' => $this->validatedData['aktif'],
        ];
        if (array_key_exists('periodeAkhir', $this->validatedData)) $data += ['akhir_menjabat' => $this->validatedData['periodeAkhir']];

        $kepsek = $this->kepsek;
        $kepsek->update($data);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('kepsekIndex');
    }

    public function update($id)
    {
        $this->authorize('update', Kepsek::class);

        if (
            $this->periodeAwal == $this->kepsek['awal_menjabat']
            && $this->periodeAkhir == $this->kepsek['akhir_menjabat']
            && $this->aktif == $this->kepsek['aktif']
        ) {
            session()->flash('gagal', 'Tidak Ada Perubahan Data');
            $this->redirectRoute('kepsekEdit', ['kepsek' => $this->kepsek]);
            return;
        }

        $kepsek = Kepsek::find($id);
        if (!$kepsek) {
            session()->flash('gagal', 'Data Tidak Ditemukan');
            $this->redirectRoute('kepsekEdit', ['kepsek' => $this->kepsek]);
            return;
        }

        $validated = $this->validate([
            'periodeAwal' => 'required',
            'aktif' => 'boolean'
        ]);

        if ($this->periodeAkhir) {
            $additionalValidated = $this->validate([
                'periodeAwal' => 'integer',
                'periodeAkhir' => 'integer',
            ]);

            $validated = array_merge($validated, $additionalValidated);
        }

        $this->validatedData = $validated;

        // jika aktif bernilai 0
        if ($validated['aktif'] == 0) {
            $this->saveData();
            return;
        }
        // jika aktif bernilai 1
        $kepsekAktif = Kepsek::where('kepsek.aktif', '=', 1)
            ->join('users', function (JoinClause $query) {
                $query->on('kepsek.user_id', '=', 'users.id')
                    ->where('users.role', '=', 'kepsek');
            })
            ->select('kepsek.id', 'users.name as nama_kepsek')
            ->first();

        // jika tidak terdapat kepsek yang aktif
        if (!$kepsekAktif) {
            $this->saveData();
            return;
        }

        // jika ada kepsek yang aktif
        session()->flash('confirmDialog', [
            'message' => "Kepsek aktif saat ini {$kepsekAktif['nama_kepsek']}. Yakin ingin mengubah?",
            'id' => $kepsekAktif['id']
        ]);
        $this->confirmModal = true;
    }
}
