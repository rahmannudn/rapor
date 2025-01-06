<?php

namespace App\Livewire\NilaiEkskul;

use App\Models\Siswa;
use App\Models\Ekskul;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\WaliKelas;
use App\Models\KelasSiswa;
use App\Models\NilaiEkskul;
use App\Models\TahunAjaran;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Form extends Component
{
    public $tahunAjaranAktif;
    public $siswaData;

    #[Locked]
    public $waliKelasId;

    public $daftarEkskul;

    public $eskuls;
    public $kelasId;
    public $daftarTahunAjaran;
    public $daftarKelas;
    public $selectedKelas;

    public function render()
    {
        if (Gate::allows('isWaliKelas')) {
            $dataKelas = KelasSiswa::where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
                ->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.id')
                ->where('wali_kelas.user_id', Auth::id())
                ->join('kelas', 'kelas.id', 'wali_kelas.kelas_id')
                ->select('kelas.nama', 'kelas.id as kelas_id')
                ->first();

            $this->kelasId = $dataKelas['kelas_id'];
        }

        $namaKelas = $dataKelas['nama'] ?? '';

        return view('livewire.nilai-ekskul.form', ['namaKelas' => $namaKelas]);
    }

    public function mount()
    {
        $this->tahunAjaranAktif = Cache::get('tahunAjaranAktif');

        $this->daftarEkskul = Ekskul::select('id', 'nama_ekskul')
            ->orderBy('created_at')
            ->get()
            ->toArray();

        $this->waliKelasId = WaliKelas::where('tahun_ajaran_id', $this->tahunAjaranAktif)
            ->where('user_id', Auth::id())
            ->select('wali_kelas.user_id')
            ->first()?->user_id;

        if (Gate::allows('isKepsek')) {
            $this->daftarTahunAjaran = TahunAjaran::all(['id', 'tahun', 'semester']);
            $this->getDaftarKelas();
        }

        $this->getSiswaData();
    }

    public function getSiswaData()
    {
        $query = Siswa::join('kelas_siswa', 'kelas_siswa.siswa_id', 'siswa.id')
            ->where('kelas_siswa.tahun_ajaran_id', $this->tahunAjaranAktif)
            ->leftJoin('wali_kelas', 'wali_kelas.kelas_id', 'kelas_siswa.kelas_id')
            ->leftJoin('nilai_ekskul', 'nilai_ekskul.kelas_siswa_id', 'kelas_siswa.id')
            ->select(
                'siswa.id as siswa_id',
                'siswa.nama as nama_siswa',
                'kelas_siswa.id as kelas_siswa_id',
                'nilai_ekskul.ekskul_id',
                'nilai_ekskul.deskripsi',
            );
        if (Gate::allows('isWaliKelas')) {
            $query->where('wali_kelas.user_id', Auth::id());
        }
        if (Gate::allows('isKepsek')) {
            $query->join('kelas', 'kelas.id', 'kelas_siswa.kelas_id')
                ->addSelect('kelas.nama as nama_kelas');
        }
        if (!empty($this->selectedKelas)) {
            $query->where('kelas_siswa.kelas_id', $this->selectedKelas);
        }
        $siswaData = $query->orderBy('siswa.nama', 'ASC')->get();
        $groupedDataSiswa = $siswaData->groupBy('siswa_id');

        $this->siswaData = $this->generateDataSiswa($groupedDataSiswa);
    }

    public function getDaftarKelas()
    {
        $this->daftarKelas = Kelas::where('kelas.tahun_ajaran_id', $this->tahunAjaranAktif)->join('wali_kelas', 'wali_kelas.kelas_id', 'kelas.id')->select('kelas.nama', 'kelas.id')->get();
    }

    public function filterDataByTahunAjaran()
    {
        $this->getSiswaData();
        $this->daftarKelas = '';
        $this->getDaftarKelas();
    }

    public function update(int $dataIndex, int $ekskulIndex, $field)
    {
        // mencari array sesuai index nilai yang berubah
        $data = $this->siswaData[$dataIndex];

        // mencari array sesuai index nilai yang berubah
        $updatedNilai = $data['nilai_ekskul'][$ekskulIndex];
        if (!$updatedNilai[$field]) {
            session()->flash('gagal', 'data tidak ditemukan');
            return;
        }

        // Ambil nilai ekskul_id dan deskripsi_ekskul dari data siswa
        $ekskulId = $this->siswaData[$dataIndex]['nilai_ekskul'][$ekskulIndex]['ekskul_id'] ?? null;
        $deskripsiEkskul = $this->siswaData[$dataIndex]['nilai_ekskul'][$ekskulIndex]['deskripsi'] ?? null;

        // Validasi jika salah satu field berubah
        $validated = $this->validate([
            "siswaData.$dataIndex.nilai_ekskul.$ekskulIndex.ekskul_id" => [
                'nullable', // Tidak wajib diisi
                'integer',
                Rule::in(array_column($this->daftarEkskul, 'id')), // Validasi ekskul_id harus ada di daftarEkskul
                function ($attribute, $value, $fail) use ($deskripsiEkskul) {
                    if ($value !== null && empty($deskripsiEkskul)) {
                        $fail('Deskripsi tidak boleh kosong');
                    }
                },
            ],
            "siswaData.$dataIndex.nilai_ekskul.$ekskulIndex.deskripsi" => [
                'nullable', // Tidak wajib diisi
                'string',
                function ($attribute, $value, $fail) use ($ekskulId) {
                    if ($value !== null && empty($ekskulId)) {
                        $fail('Ekskul tidak boleh kosong');
                    }
                },
            ],
        ]);

        $hasilNilai = NilaiEkskul::updateOrCreate([
            'kelas_siswa_id' => $data['kelas_siswa_id'],
            'ekskul_id' => $updatedNilai['ekskul_id'],
            'deskripsi' => $updatedNilai['deskripsi'],
        ], [
            $field => $updatedNilai[$field],
        ]);
    }

    public function generateDataSiswa($data)
    {
        $results = [];
        foreach ($data as $siswa) {
            $dataSiswa = [
                'siswa_id' => (int)$siswa->first()->siswa_id,
                'nama_siswa' => $siswa->first()->nama_siswa,
                'kelas_siswa_id' => $siswa->first()->kelas_siswa_id
            ];
            if (Gate::allows('isKepsek')) {
                $dataSiswa['nama_kelas'] = $siswa->first()->nama_kelas;
            }

            $nilaiEkskul = [];
            for ($i = 0; $i < 4; $i++) {
                $nilaiEkskul[$i] = [
                    'ekskul_id' => $siswa[$i]['ekskul_id'] ?? null,
                    'deskripsi' => $siswa[$i]['deskripsi'] ?? null
                ];
            }
            $dataSiswa['nilai_ekskul'] = $nilaiEkskul;
            $results[] = $dataSiswa;
        }
        return $results;
    }

    public function simpan()
    {
        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('nilaiEkskulIndex');
    }
}
