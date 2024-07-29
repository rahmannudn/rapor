<?php

namespace App\Livewire\Kepsek;

use App\Models\User;
use App\Models\Kepsek;
use Livewire\Component;
use App\Rules\IsValidYear;
use App\Models\TahunAjaran;
use Livewire\Attributes\Locked;

class Create extends Component
{
    public $daftarTahunAjaran;
    public $daftarKepsek;

    public $periodeAwal;
    public $periodeAkhir;
    public $selectedKepsek;
    public $aktif;

    public $confirmModal;
    #[Locked]
    public $validatedData;

    public function render()
    {
        return view('livewire.kepsek.create');
    }

    public function mount()
    {
        $this->daftarTahunAjaran = TahunAjaran::select('tahun', 'semester', 'aktif', 'id')
            ->orderBy('tahun')
            ->get();
        $this->daftarKepsek = User::where('role', '=', 'kepsek')
            ->select('id', 'name', 'email', 'jk', 'jenis_pegawai')
            ->orderBy('name')
            ->get();
    }

    public function create($id = null)
    {
        if ($id) {
            $kepsekAktif = Kepsek::find($id);
            if ($kepsekAktif) {
                $kepsekAktif['aktif'] = 0;
                $kepsekAktif->save();
            }
        }

        $data = [
            'user_id' => $this->validatedData['selectedKepsek'],
            'awal_menjabat' => $this->validatedData['periodeAwal'],
            'aktif' => $this->validatedData['aktif']
        ];

        if (array_key_exists('periodeAkhir', $this->validatedData))
            $data += ['akhir_menjabat' => $this->validatedData['periodeAkhir']];

        Kepsek::create($data);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('kepsekIndex');
    }

    public function save()
    {
        $this->authorize('create', Kepsek::class);

        $validated = $this->validate([
            'selectedKepsek' => 'required',
            'periodeAwal' => 'required',
            'aktif' => 'required',
        ], [
            'selectedKepsek.required' => 'Kepsek field is required.',
            'periodeAwal.required' => 'Periode Awal field is required.',
        ]);

        if ($this->periodeAkhir) {
            $additionalValidated = $this->validate([
                'periodeAwal' => [new IsValidYear($this->periodeAkhir)],
                'periodeAkhir' => 'integer',
            ]);

            $validated = array_merge($validated, $additionalValidated);
        }

        $this->validatedData = $validated;

        // jika aktif bernilai 0
        if ($validated['aktif'] === 0) {
            $this->create();
            return;
        }

        // jika aktif bernilai 1
        $kepsekAktif = Kepsek::join('users', 'kepsek.user_id', 'users.id')
            ->where('kepsek.aktif', '=', 1)
            ->select('users.name as nama_kepsek', 'kepsek.id as kepsek_id')
            ->first();

        // jika tidak ditemukan kepsek yang aktif
        if (!$kepsekAktif) {
            $this->create();
            return;
        }

        // jika semester aktif bernilai 1 dan ditemukan sudah ada semester yang aktif
        session()->flash('confirmDialog', [
            'message' => "Kepsek aktif saat ini {$kepsekAktif['nama_kepsek']}. Yakin ingin mengubah?",
            'id' => $kepsekAktif['kepsek_id']
        ]);
        $this->confirmModal = true;
    }
}
