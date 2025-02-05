<?php

namespace App\Livewire\TahunAjaran;

use App\Models\Kepsek;
use Livewire\Component;
use App\Rules\IsValidYear;
use WireUi\Traits\Actions;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Livewire\Attributes\Title;
use App\Helpers\FunctionHelper;
use Livewire\Attributes\Locked;
use App\Models\TahunAjaran as TA;
use Illuminate\Support\Facades\Cache;

class Create extends Component
{
    use Actions;

    public $years = [];

    public $tahunAwal;
    public $tahunAkhir;
    public $semester;
    public $semesterAktif;
    public $confirmModal;
    public $daftarTahunAjaran;
    public $prevTahunAjaran;
    public $tglRapor;
    public $daftarKepsek;
    public $selectedKepsek;

    #[Locked]
    public $validatedData;

    public function render()
    {
        return view('livewire.tahun-ajaran.create');
    }

    public function mount()
    {
        $this->reset();

        $this->daftarTahunAjaran = TahunAjaran::select('id', 'tahun', 'semester')->get()->toArray();
        // mengambil data tahun sekarang
        $this->years = FunctionHelper::getDynamicYear();
        $this->daftarKepsek = Kepsek::join('tahun_ajaran', 'tahun_ajaran.kepsek_id', 'kepsek.id')
            ->join('users', 'users.id', 'kepsek.user_id')
            ->select('users.name as nama_kepsek', 'kepsek.id')
            ->distinct()
            ->get();

        $tahunAjaran = TahunAjaran::where('id', Cache::get('tahunAjaranAktif'))
            ->select('id', 'kepsek_id')
            ->first();

        $this->selectedKepsek = Kepsek::where('id', $tahunAjaran['kepsek_id'])
            ->select('id')
            ->first()?->id;
    }

    public function rules()
    {
        return [
            'tahunAwal' => ['required', new IsValidYear($this->tahunAkhir)],
            'tahunAkhir' => ['required',],
            'semester' => ['required', 'string'],
            'semesterAktif' => ['required', 'boolean'],
            'prevTahunAjaran' => ['nullable', 'string'],
            'tglRapor' => ['nullable', 'date'],
            'selectedKepsek' => ['required'],
        ];
    }

    public function create($id = null)
    {
        $this->authorize('update', TahunAjaran::class);

        if ($id) {
            $semesterSedangAktif = TahunAjaran::find($id);
            if ($semesterSedangAktif) {
                $semesterSedangAktif['aktif'] = 0;
                $semesterSedangAktif->save();
            }
        }

        TA::create([
            'tahun' => TA::concatTahunAjaran($this->validatedData['tahunAwal'], $this->validatedData['tahunAkhir']),
            'semester' => $this->validatedData['semester'],
            'aktif' => $this->validatedData['semesterAktif'],
            'prev_tahun_ajaran_id' => $this->validatedData['prevTahunAjaran'],
            'tgl_rapor' => $this->validatedData['tglRapor'],
            'kepsek_id' => $this->validatedData['selectedKepsek'],
        ]);

        $this->validatedData['semesterAktif'] ?? FunctionHelper::setCacheInfoSekolah();

        session()->flash('success', 'Data Berhasil Ditambahkan');
        $this->redirectRoute('tahunAjaranIndex');
    }

    public function resetData()
    {
        $this->confirmModal = false;
        $this->validatedData = null;
    }

    public function save(Request $request)
    {
        $validated = $this->validate();

        if ($validated['semesterAktif'] === '0') {
            $this->validatedData = $validated;
            $this->create();
            return;
        }

        // jika semester aktif bernilai 1
        $semesterSedangAktif = TahunAjaran::firstWhere('aktif', 1);

        // jika tidak ditemukan semester yang sedang aktif
        // if (!$semesterSedangAktif) {
        //     $this->validatedData = $validated;
        //     $this->create();
        //     return;
        // }

        // jika semester aktif bernilai 1 dan ditemukan sudah ada semester yang aktif
        session()->flash('confirmDialog', ['message' => "Tahun ajaran aktif saat ini {$semesterSedangAktif['tahun']} {$semesterSedangAktif['semester']}. Perubahan tahun ajaran aktif dapat menimbulkan error pada penginputan nilai", 'id' => $semesterSedangAktif['id']]);
        $this->confirmModal = true;
        $this->validatedData = $validated;
    }
}
