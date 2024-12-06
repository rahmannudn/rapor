<?php

namespace App\Livewire\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Component;
use App\Enums\AgamaList;
use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use Livewire\WithFileUploads;
use App\Helpers\FunctionHelper;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rules\Enum;

class Edit extends Component
{
    use WithFileUploads;

    public Siswa $siswa;

    #[Locked]
    public $originKelas;

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
    public $kelas_id;
    public $daftarKelas;
    public $tahun_lulus;
    public $daftarSemester;
    public $tahunAjaranAktif;

    #[Validate('nullable|image|max:1536')] // 1,5MB Max
    public $foto;

    public function render()
    {
        return view('livewire.siswa.edit');
    }

    public function mount()
    {
        $this->tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();

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
        $this->tahun_lulus = $this->siswa['tahun_lulus'];
        $this->hp_ortu = $this->siswa['hp_ortu'];
        $this->daftarKelas = Kelas::all();
        $this->daftarSemester = TahunAjaran::all();

        $kelas = KelasSiswa::where('siswa_id', $this->siswa['id'])->where('tahun_ajaran_id', $this->tahunAjaranAktif)
            ->select('kelas_id as id')
            ->get();

        $this->kelas_id = $kelas->first()['id'] ?? null;
        $this->originKelas = $this->kelas_id;
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
        $this->authorize('update', Siswa::class);
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

        if ($this->kelas_id !== $this->originKelas) {
            $targetKelas = KelasSiswa::firstOrCreate([
                'siswa_id' => $this->siswa['id'],
                'tahun_ajaran_id' => $this->tahunAjaranAktif
            ], ['kelas_id' => $this->kelas_id]);
            $targetKelas->kelas_id = $this->kelas_id;
            $targetKelas->save();
        }

        $siswa->fill($validated);

        if ($this->foto === null) {
            $siswa['foto'] = $this->siswa['foto'];
        } else {
            $filePath = $this->foto->store('uploads', 'public');
            $siswa['foto'] = $filePath;
        }

        $siswa->save();
        $this->redirectRoute('siswaIndex');
        session()->flash('success', 'Data Berhasil Diubah');
    }
}
