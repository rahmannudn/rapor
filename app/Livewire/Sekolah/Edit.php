<?php

namespace App\Livewire\Sekolah;

use App\Models\Sekolah;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;

class Edit extends Component
{
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

    public function mount()
    {
        $dataSekolah = Sekolah::find(1);

        $this->setData($dataSekolah);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.sekolah.edit');
    }

    public function update()
    {
        $validated = $this->validate();
        $data = Sekolah::find($this->id);
        $data->update([
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
        ]);

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
