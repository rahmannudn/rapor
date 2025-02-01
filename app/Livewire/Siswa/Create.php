<?php

namespace App\Livewire\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Component;
use App\Enums\AgamaList;
use App\Models\KelasSiswa;
use App\Helpers\FunctionHelper;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;

class Create extends Component
{
    use WithFileUploads;

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

    #[Validate('nullable|sometimes|image|max:1536')] // 1,5MB Max
    public $foto;

    public function render()
    {
        return view('livewire.siswa.create');
    }

    public function mount()
    {
        $tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();
        $this->daftarKelas = Kelas::where('tahun_ajaran_id', $tahunAjaranAktif)->select('nama', 'id')->get();
    }

    public function rules()
    {
        return [
            'nisn' => ['required', 'size:10', 'unique:' . Siswa::class],
            'nidn' => ['required', 'max:10', 'unique:' . Siswa::class],
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

    public function messages()
    {
        return [
            'kelas_id.required' => 'The kelas field is required.',
            'jk.required' => 'The jenis kelamin field is required.',
        ];
    }

    public function save()
    {
        $this->authorize('create', Siswa::class);
        $validated = $this->validate();
        $validated['tempat_lahir'] = Str::lower($validated['tempat_lahir']);
        if ($this->foto) {
            $filePath = $this->foto->store('uploads', 'public');
            $validated['foto'] = $filePath;
        }
        $siswa = Siswa::create($validated);
        KelasSiswa::create([
            'siswa_id' => $siswa['id'],
            'kelas_id' => $validated['kelas_id'],
            'tahun_ajaran_id' => FunctionHelper::getTahunAjaranAktif(),
        ]);

        $this->redirectRoute('siswaIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
