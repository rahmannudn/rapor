<?php

namespace App\Livewire\MateriMapel;

use App\Models\DetailGuruMapel;
use App\Models\MateriMapel;
use Livewire\Component;
use Livewire\Attributes\Locked;

class Edit extends Component
{
    public MateriMapel $materiMapel;

    public $lingkupMateri;
    public $tujuanPembelajaran;
    public $namaMapel;
    public $namaKelas;

    public function render()
    {
        return view('livewire.materi-mapel.edit');
    }

    public function mount()
    {
        $this->lingkupMateri = $this->materiMapel['lingkup_materi'];
        $this->tujuanPembelajaran = $this->materiMapel['tujuan_pembelajaran'];

        $data = $this->getMapelAndKelas();
        $this->namaMapel = $data->nama_mapel;
        $this->namaKelas = $data->nama_kelas;
    }

    public function getMapelAndKelas()
    {
        $data = MateriMapel::join('detail_guru_mapel', 'materi_mapel.detail_guru_mapel_id', '=', 'detail_guru_mapel.id')
            ->join('mapel', 'detail_guru_mapel.mapel_id', '=', 'mapel.id')
            ->join('kelas', 'detail_guru_mapel.kelas_id', '=', 'kelas.id')
            ->where('materi_mapel.id', '=', $this->materiMapel['id'])
            ->select('mapel.nama_mapel', 'kelas.nama as nama_kelas')
            ->first();

        return $data;
    }

    public function update(MateriMapel $materiMapel)
    {
        $this->authorize('update', MateriMapel::class);

        if (
            $this->lingkupMateri === $this->materiMapel['lingkup_materi'] &&
            $this->tujuanPembelajaran === $this->materiMapel['tujuan_pembelajaran']
        ) {
            session()->flash('gagal', 'Tidak Ada Perubahan Data');
            $this->redirectRoute('materiMapelEdit', ['materiMapel' => $this->materiMapel]);
            return;
        }

        $validated = $this->validate([
            'lingkupMateri' => 'required|string|min:3|max:224',
            'tujuanPembelajaran' => 'required|string|min:3',
        ]);

        $materiMapel->update([
            'tujuan_pembelajaran' => $validated['tujuanPembelajaran'],
            'lingkup_materi' => $validated['lingkupMateri'],
        ]);

        session()->flash('success', 'Data Berhasil Diubah');
        $this->redirectRoute('materiMapelIndex');
    }
}
