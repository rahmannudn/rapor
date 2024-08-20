<?php

namespace App\Livewire\Sekolah;

use App\Helpers\FunctionHelper;
use App\Models\Sekolah;

use Livewire\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    #[Locked]
    public $originalLogo;

    #[Locked]
    public $id;
    public $npsn;
    public $namaSekolah;
    public $alamat;
    public $kodePos;
    public $kelurahan;
    public $kecamatan;
    public $kota;
    public $provinsi;
    public $email;
    public $nss;

    #[Validate('nullable|sometimes|image|max:3000')] // 3MB Max
    public $logo;

    public function mount()
    {
        $dataSekolah = Sekolah::find(1);

        $this->setData($dataSekolah);
    }

    public function render()
    {
        return view('livewire.sekolah.edit');
    }

    public function update()
    {
        $this->authorize('update', Sekolah::class);

        $validated = $this->validate();
        $dataSekolah = Sekolah::find($this->id);
        $updatedData = [
            'npsn' => $validated['npsn'],
            'nama_sekolah' => $validated['namaSekolah'],
            'alamat_sekolah' => $validated['alamat'],
            'kode_pos' => $validated['kodePos'],
            'kelurahan' => $validated['kelurahan'],
            'kecamatan' => $validated['kecamatan'],
            'kota' => $validated['kota'],
            'provinsi' => $validated['provinsi'],
            'email' => $validated['email'],
            'nss' => $validated['nss'],
        ];
        if ($this->logo) {
            $filePath = $this->logo->store('uploads', 'public');
            $updatedData['logo_sekolah'] = $filePath;
            FunctionHelper::setCacheInfoSekolah();
        }

        $dataSekolah->update($updatedData);

        session()->flash('success', 'Data Berhasil Diubah');
        $this->redirectRoute('sekolahIndex');
    }

    public function setData($data)
    {
        $this->id = $data->id;
        $this->npsn = $data->npsn;
        $this->namaSekolah = $data->nama_sekolah;
        $this->alamat = $data->alamat_sekolah;
        $this->kodePos = $data->kode_pos;
        $this->kelurahan = $data->kelurahan;
        $this->kecamatan = $data->kecamatan;
        $this->kota = $data->kota;
        $this->provinsi = $data->provinsi;
        $this->email = $data->email;
        $this->nss = $data->nss;
        $this->logo = $data->logo_sekolah;
        $this->originalLogo = $data->logo_sekolah;
    }

    public function rules()
    {
        return [
            'npsn' => 'required|string|max:8',
            'namaSekolah' => 'required|string|min:5|max:50',
            'alamat' => 'required|string|min:10|max:80',
            'kodePos' => 'required|string|max:5',
            'kelurahan' => 'required|string|min:5|max:50',
            'kecamatan' => 'required|string|min:5|max:50',
            'kota' => 'required|string|min:5|max:50',
            'provinsi' => 'required|string|min:5|max:80',
            'email' => 'required|string|min:5|max:80',
            'nss' => 'required|string|max:5',
        ];
    }
}
