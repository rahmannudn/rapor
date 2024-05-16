<?php

namespace App\Livewire\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Enums\AgamaList;
use App\Models\TahunAjaran;
use Illuminate\Validation\Rules\Enum;

class Edit extends Component
{
    public Siswa $siswa;

    public $nisn;
    public $nidn;
    public $nama;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jk;
    public $agama;
    public $alamat;
    public $kelurahan;
    public $kecamatan;
    public $kota;
    public $provinsi;
    public $nama_ayah;
    public $nama_ibu;
    public $hp_ortu;
    public $foto;
    public $kelas_id;
    public $daftarKelas;
    public $tahun_lulus;
    public $daftarSemester;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.siswa.edit');
    }

    public function mount()
    {
        $this->nisn = $this->siswa['nisn'];
        $this->nidn = $this->siswa['nidn'];
        $this->nama = $this->siswa['nama'];
        $this->tempat_lahir = $this->siswa['tempat_lahir'];
        $this->tanggal_lahir = $this->siswa['tanggal_lahir'];
        $this->jk = $this->siswa['jk'];
        $this->agama = $this->siswa['agama'];
        $this->alamat = $this->siswa['alamat'];
        $this->kelurahan = $this->siswa['kelurahan'];
        $this->kecamatan = $this->siswa['kecamatan'];
        $this->kota = $this->siswa['kota'];
        $this->provinsi = $this->siswa['provinsi'];
        $this->nama_ayah = $this->siswa['nama_ayah'];
        $this->nama_ibu = $this->siswa['nama_ibu'];
        $this->kelas_id = $this->siswa['kelas_id'];
        $this->tahun_lulus = $this->siswa['tahun_lulus'];
        $this->hp_ortu = $this->siswa['hp_ortu'];

        $this->daftarKelas = Kelas::all();
        $this->daftarSemester = TahunAjaran::all();
    }

    public function rules()
    {
        return [

            'nama' => ['required', 'string', 'min:3', 'max:80'],
            'tempat_lahir' => ['required', 'string', 'min:3', 'max:80'],
            'tanggal_lahir' => ['required', 'date'],
            'jk' => ['required', 'in:l,p'],
            'agama' => ['required', new Enum(AgamaList::class)],
            'alamat' => ['required', 'string'],
            'kelas_id' => ['required'],
            'kelurahan' => ['required', 'string', 'min:3', 'max:80'],
            'kecamatan' => ['required', 'string', 'min:3', 'max:80'],
            'kota' => ['required', 'string', 'min:3', 'max:80'],
            'provinsi' => ['required', 'string', 'min:3', 'max:80'],
            'nama_ayah' => ['required', 'string', 'min:3', 'max:80'],
            'nama_ibu' => ['required', 'string', 'min:3', 'max:80'],
            'hp_ortu' => ['required', 'min:11', 'max:13'],
        ];
    }

    public function save(Siswa $siswa)
    {
        $validated = $this->validate();

        if ($this->tahun_lulus) $validated += $this->validate(['tahun_lulus' => 'required']);
        // membandingkan inputan nisn dengan data nisn yg sdh ada
        if ($this->nisn !== $siswa->nisn) {
            $validated += $this->validate(['nisn' => ['required', 'size:10', 'unique:' . Siswa::class]]);
        }
        // membandingkan inputan nidn dengan data nidn yg sdh ada
        if ($this->nidn !== $siswa->nidn) {
            $validated += $this->validate(['nidn' => ['required', 'max:10', 'unique:' . Siswa::class]]);
        }

        $siswa->update($validated);
        $this->redirectRoute('siswaIndex');
        session()->flash('success', 'Data Berhasil Diubah');
    }
}
