<?php

namespace App\Livewire\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Component;
use App\Enums\AgamaList;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
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

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.siswa.create');
    }

    public function mount()
    {
        $this->daftarKelas = Kelas::all();
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

    public function save()
    {
        $this->authorize('create', Siswa::class);
        $validated = $this->validate();
        if ($this->foto) {
            $filePath = $this->foto->store('uploads', 'public');
            $validated['foto'] = $filePath;
        }
        Siswa::create($validated);

        $this->redirectRoute('siswaIndex');
        session()->flash('success', 'Data Berhasil Ditambahkan');
    }
}
