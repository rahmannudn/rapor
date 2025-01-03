<?php

namespace App\Livewire\Proyek;

use App\Exports\DaftarProyekExport;
use App\Helpers\FunctionHelper;
use App\Models\Kelas;
use App\Models\Proyek;
use Livewire\Component;
use App\Models\TahunAjaran;
use App\Models\WaliKelas;
use App\Policies\ProyekPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Excel;

class Table extends Component
{
    use WithPagination;

    public $show = 10;
    public $searchQuery;
    public $selectedTahunAjaran;
    public $selectedKelas;

    public $daftarTahunAjaran;
    public $daftarKelas;

    public function mount()
    {
        $this->selectedTahunAjaran = Cache::get('tahunAjaranAktif');

        if (Gate::allows('isWaliKelas')) {
            $this->selectedKelas = WaliKelas::where('wali_kelas.tahun_ajaran_id', '=', $this->selectedTahunAjaran)
                ->where('user_id', '=', Auth::id())
                ->join('kelas', 'wali_kelas.kelas_id', 'kelas.id')
                ->select('kelas.nama', 'kelas.id as id_kelas')
                ->first()
                ->toArray();

            $this->daftarTahunAjaran = FunctionHelper::getDaftarTahunAjaranByWaliKelas();
        }
        if (Gate::allows('isKepsek')) {
            $this->daftarTahunAjaran = TahunAjaran::join('wali_kelas', 'wali_kelas.tahun_ajaran_id', 'tahun_ajaran.id')
                ->select('tahun_ajaran.id', 'tahun_ajaran.tahun', 'tahun_ajaran.semester')
                ->distinct()
                ->get();
        }
    }

    #[On('updateData')]
    public function render()
    {
        $daftarProyek = Proyek::query()
            ->search($this->searchQuery)
            ->joinWaliKelas()
            ->joinKelasByWaliKelas()
            ->joinUsers()
            ->filterTahunAjaran($this->selectedTahunAjaran)
            ->select(
                'proyek.id',
                'proyek.judul_proyek',
                'proyek.deskripsi',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester'
            )
            ->orderBy('proyek.created_at', 'DESC')
            ->paginate($this->show);

        return view('livewire.proyek.table', compact('daftarProyek'));
    }

    public function exportExcel(Excel $excel)
    {
        // $data = Proyek::query()
        //     ->joinWaliKelas()
        //     ->joinKelasByWaliKelas()
        //     ->joinUsers()
        //     ->filterTahunAjaran($this->selectedTahunAjaran)
        //     ->select(
        //         'proyek.id',
        //         'proyek.judul_proyek',
        //         'proyek.deskripsi',
        //         'kelas.nama as nama_kelas',
        //         'users.name as nama_guru',
        //         'tahun_ajaran.tahun',
        //         'tahun_ajaran.semester'
        //     )
        //     ->orderBy('proyek.created_at', 'DESC')
        //     ->get();

        // return $excel->download(new DaftarProyekExport([$data]), 'daftar_proyek.xlsx');
        if (Gate::allows('isWaliKelas')) {
            return (new DaftarProyekExport($this->selectedTahunAjaran))->download('daftar_proyek.xlsx', Excel::XLSX);
        }
    }

    public function downloadLaporan()
    {
        $data = $this->getSubproyekInfo();
        return view('template-laporan-proyek', ['data' => $this->getSubproyekInfo()]);
    }

    public function getSubproyekInfo()
    {
        $data = Proyek::query()
            ->search($this->searchQuery)
            ->joinWaliKelas()
            ->joinKelasByWaliKelas()
            ->joinUsers()
            ->filterTahunAjaran($this->selectedTahunAjaran)
            ->join('subproyek', 'subproyek.proyek_id', 'proyek.id')
            ->join('capaian_fase', 'capaian_fase.id', 'subproyek.capaian_fase_id')
            ->join('subelemen', 'subelemen.id', 'capaian_fase.subelemen_id')
            ->join('elemen', 'elemen.id', 'subelemen.elemen_id')
            ->join('dimensi', 'dimensi.id', 'elemen.dimensi_id')
            ->select(
                'wali_kelas.id as wali_kelas_id',
                'proyek.id as proyek_id',
                'proyek.judul_proyek',
                'proyek.deskripsi as proyek_deskripsi',
                'subproyek.id as subproyek_id',
                'capaian_fase.deskripsi as capaian_fase_deskripsi',
                'subelemen.deskripsi as subelemen_deskripsi',
                'elemen.deskripsi as elemen_deskripsi',
                'dimensi.deskripsi as dimensi_deskripsi',
                'kelas.nama as nama_kelas',
                'users.name as nama_guru',
                'tahun_ajaran.id as tahun_ajaran_id',
                'tahun_ajaran.tahun',
                'tahun_ajaran.semester'
            )
            ->orderBy('proyek.created_at', 'DESC')
            ->orderBy('tahun_ajaran.id')
            ->orderBy('kelas.nama')
            ->get();

        return $this->formatSubproyekData($data);
    }

    private function formatSubproyekData($data)
    {
        $formattedData = [];

        foreach ($data as $item) {
            $proyekId = $item['proyek_id'];

            // Jika proyek belum ada di array hasil, tambahkan
            if (!isset($formattedData[$proyekId])) {
                $formattedData[$proyekId] = [
                    "wali_kelas_id" => $item["wali_kelas_id"],
                    "proyek_id" => $item["proyek_id"],
                    "judul_proyek" => $item["judul_proyek"],
                    "proyek_deskripsi" => $item["proyek_deskripsi"],
                    "nama_kelas" => $item["nama_kelas"],
                    "nama_guru" => $item["nama_guru"],
                    "tahun_ajaran_id" => $item["tahun_ajaran_id"],
                    "tahun" => $item["tahun"],
                    "semester" => $item["semester"],
                    "subproyek" => []
                ];
            }

            // Tambahkan data subproyek ke dalam proyek
            $formattedData[$proyekId]["subproyek"][] = [
                "subproyek_id" => $item["subproyek_id"],
                "capaian_fase_deskripsi" => $item["capaian_fase_deskripsi"],
                "subelemen_deskripsi" => $item["subelemen_deskripsi"],
                "elemen_deskripsi" => $item["elemen_deskripsi"],
                "dimensi_deskripsi" => $item["dimensi_deskripsi"]
            ];
        }

        // Reset keys to make the array sequential
        return array_values($formattedData);
    }
}
