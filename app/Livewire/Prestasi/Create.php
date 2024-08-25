<?php

namespace App\Livewire\Prestasi;

use App\Models\Kelas;
use App\Models\Prestasi;
use App\Models\Siswa;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $daftarKelas;
    public $selectedKelas;
    public $tahunAjaranAktif;
    public $daftarSiswa;
    public $selectedSiswa;
    public $namaPrestasi;
    public $tglPrestasi;
    public $penyelenggara;
    public $deskripsi;
    public $nilaiPrestasi;

    #[Validate('file|mimes:jpeg,png,jpg,gif,svg,pdf|max:3000')]
    public $bukti;

    public function render()
    {
        return view('livewire.prestasi.create');
    }

    public function mount()
    {
        $this->daftarKelas = Kelas::select('nama', 'id')->get();
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');
    }

    public function getSiswa()
    {
        $this->daftarSiswa = '';
        $this->selectedSiswa = '';

        $this->daftarSiswa = Siswa::join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('kelas_siswa.kelas_id', $this->selectedKelas)
            ->select('siswa.nama', 'siswa.id')
            ->orderBy('siswa.nama', 'ASC')
            ->get()
            ->toArray();
        $this->selectedSiswa = $this->daftarSiswa[0]['id'];
    }

    public function save()
    {
        $validated = $this->validate([
            'selectedSiswa' => 'required',
            'namaPrestasi' => 'required|min:5|max:200',
            'tglPrestasi' => 'required|date',
            'penyelenggara' => 'required|min:5|max:200',
            'deskripsi' => 'nullable|min:5|max:200',
            'nilaiPrestasi' => 'nullable|string|min:3|max:5',
        ]);

        $this->authorize('create', Prestasi::class);

        if ($this->bukti !== null) {
            $filePath = $this->bukti->store('uploads', 'public');
            $this->bukti = $filePath;
        }

        $prestasi = Prestasi::create(
            [
                'siswa_id' => $validated['selectedSiswa'],
                'nama_prestasi' => $validated['namaPrestasi'],
                'tgl_prestasi' => $validated['tglPrestasi'],
                'penyelenggara' => $validated['penyelenggara'],
                'deskripsi' => $validated['deskripsi'],
                'bukti' => $this->bukti,
                'nilai_prestasi' => $validated['nilaiPrestasi'],
            ]
        );

        $this->redirectRoute('prestasiIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
