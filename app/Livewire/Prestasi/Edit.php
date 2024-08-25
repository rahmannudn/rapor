<?php

namespace App\Livewire\Prestasi;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\Prestasi;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Cache;

class Edit extends Component
{
    use WithFileUploads;

    public Prestasi $prestasiData;

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
    public $originBukti;

    #[Validate('file|mimes:jpeg,png,jpg,gif,svg,pdf|max:3000')]
    public $bukti;

    public function render()
    {
        return view('livewire.prestasi.edit');
    }

    public function mount()
    {
        $this->daftarKelas = Kelas::select('nama', 'id')->get();
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');

        $siswa = Siswa::where('siswa.id', $this->prestasiData['siswa_id'])
            ->join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
            ->select('siswa.nama as nama_siswa', 'kelas.nama as nama_kelas', 'kelas.id as id_kelas')
            ->first();

        $this->selectedKelas = $siswa['id_kelas'];
        $this->getSiswa();
        $this->selectedSiswa = $this->prestasiData['siswa_id'];
        $this->tglPrestasi = Carbon::parse($this->prestasiData['tgl_prestasi'])->translatedFormat('d F Y');
        $this->namaPrestasi = $this->prestasiData['nama_prestasi'];
        $this->penyelenggara = $this->prestasiData['penyelenggara'];
        $this->deskripsi = $this->prestasiData['deskripsi'];
        $this->nilaiPrestasi = $this->prestasiData['nilai_prestasi'];
        $this->bukti = $this->prestasiData['bukti'];
        $this->originBukti = $this->prestasiData['bukti'];
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

    public function update(Prestasi $prestasi)
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

        if ($this->bukti !== null && $this->bukti !== $this->originBukti) {
            $filePath = $this->bukti->store('uploads', 'public');
            $this->bukti = $filePath;
        }

        $validated['tglPrestasi'] = Carbon::createFromFormat('d F Y', $validated['tglPrestasi'])->format('Y-m-d');
        $prestasi->update([
            'siswa_id' => $validated['selectedSiswa'],
            'nama_prestasi' => $validated['namaPrestasi'],
            'tgl_prestasi' => $validated['tglPrestasi'],
            'penyelenggara' => $validated['penyelenggara'],
            'deskripsi' => $validated['deskripsi'],
            'bukti' => $this->bukti,
            'nilai_prestasi' => $validated['nilaiPrestasi'],
        ]);

        $this->redirectRoute('prestasiIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
