<?php

use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Livewire\User\Edit as UserEdit;
use App\Http\Middleware\CheckPermission;
use App\Livewire\Kelas\Edit as KelasEdit;
use App\Livewire\Mapel\Edit as MapelEdit;
use App\Livewire\Siswa\Edit as SiswaEdit;

use App\Livewire\User\Index as UserIndex;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RaporP5Controller;

use App\Livewire\Ekskul\Edit as EkskulEdit;
use App\Livewire\Elemen\Edit as ElemenEdit;

use App\Livewire\Kelas\Index as KelasIndex;
use App\Livewire\Kepsek\Edit as KepsekEdit;
use App\Livewire\Mapel\Index as MapelIndex;
use App\Livewire\Proyek\Edit as ProyekEdit;

use App\Livewire\Siswa\Index as SiswaIndex;
use App\Livewire\User\Create as UserCreate;
use App\Livewire\Dimensi\Edit as DimensiEdit;

use App\Livewire\Ekskul\Index as EkskulIndex;
use App\Livewire\Elemen\Index as ElemenIndex;
use App\Livewire\Kelas\Config as KelasConfig;

use App\Livewire\Kelas\Create as KelasCreate;
use App\Livewire\Kepsek\Index as KepsekIndex;
use App\Livewire\Mapel\Create as MapelCreate;

use App\Livewire\Proyek\Index as ProyekIndex;
use App\Livewire\Sekolah\Edit as SekolahEdit;
use App\Livewire\Siswa\Create as SiswaCreate;
use App\Livewire\SiswaDetail\Index as SiswaDetail;

use App\Http\Controllers\RaporIntraController;
use App\Livewire\Absensi\Index as AbsensiIndex;
use App\Livewire\Dimensi\Index as DimensiIndex;

use App\Livewire\Ekskul\Create as EkskulCreate;
use App\Livewire\Elemen\Create as ElemenCreate;
use App\Livewire\Kepsek\Create as KepsekCreate;

use App\Livewire\Prestasi\Edit as PrestasiEdit;
use App\Livewire\Proyek\Create as ProyekCreate;
use App\Livewire\Raporp5\Index as RaporP5Index;

use App\Livewire\Sekolah\Index as SekolahIndex;
use App\Livewire\Dimensi\Create as DimensiCreate;
use App\Livewire\GuruMapel\Edit as GuruMapelEdit;

use App\Livewire\Prestasi\Index as PrestasiIndex;
use App\Livewire\Subelemen\Edit as SubelemenEdit;
use App\Livewire\WaliKelas\Edit as WaliKelasEdit;

use App\Livewire\GuruMapel\Index as GuruMapelIndex;
use App\Livewire\Prestasi\Create as PrestasiCreate;
use App\Livewire\Prestasi\Detail as PrestasiDetail;

use App\Livewire\Subelemen\Index as SubelemenIndex;
use App\Livewire\Subproyek\Index as SubproyekIndex;
use App\Livewire\WaliKelas\Index as WaliKelasIndex;

use App\Livewire\CapaianFase\Edit as CapaianFaseEdit;
use App\Livewire\GuruMapel\Create as GuruMapelCreate;
use App\Livewire\MateriMapel\Edit as MateriMapelEdit;

use App\Livewire\NilaiEkskul\Edit as NilaiEkskulEdit;
use App\Livewire\Raporintra\Index as RaporIntraIndex;
use App\Livewire\Subelemen\Create as SubelemenCreate;

use App\Livewire\TahunAjaran\Edit as TahunAjaranEdit;
use App\Livewire\WaliKelas\Create as WaliKelasCreate;
use App\Http\Controllers\NilaiSumatifExportController;
use App\Http\Controllers\NilaiSumatifPerkelasPDFController;
use App\Http\Controllers\LaporanEkskulExportPDF;
use App\Http\Controllers\LaporanProyekExportPDF;
use App\Http\Controllers\LaporanProyeklExportPDF;
use App\Http\Controllers\RiwayatGuruMapel;
use App\Http\Controllers\RiwayatGuruMapelController;
use App\Http\Controllers\RiwayatWaliKelasController;
use App\Livewire\CapaianFase\Index as CapaianFaseIndex;
use App\Livewire\MateriMapel\Index as MateriMapelIndex;
use App\Livewire\NilaiEkskul\Index as NilaiEkskulIndex;
use App\Livewire\TahunAjaran\Index as TahunAjaranIndex;

use App\Livewire\CapaianFase\Create as CapaianFaseCreate;

use App\Livewire\CatatanProyek\Edit as CatatanProyekEdit;

use App\Livewire\LingkupMateri\Edit as LingkupMateriEdit;

use App\Livewire\MateriMapel\Create as MateriMapelCreate;

use App\Livewire\NilaiEkskul\Create as NilaiEkskulCreate;

use App\Livewire\NilaiSumatif\Index as NilaiSumatifIndex;
use App\Livewire\TahunAjaran\Create as TahunAjaranCreate;
use App\Livewire\CatatanProyek\Index as CatatanProyekIndex;

use App\Livewire\LingkupMateri\Index as LingkupMateriIndex;
use App\Livewire\NilaiFormatif\Index as NilaiFormatifIndex;
use App\Livewire\LingkupMateri\Create as LingkupMateriCreate;
use App\Livewire\NilaiSubproyek\Index as NilaiSubproyekIndex;

use App\Livewire\TujuanPembelajaran\Edit as TujuanPembelajaranEdit;

use App\Livewire\TujuanPembelajaran\Index as TujuanPembelajaranIndex;
use App\Livewire\TujuanPembelajaran\Create as TujuanPembelajaranCreate;

use App\Livewire\LaporanSumatifPerkelas\Index as LaporanSumatifPerkelas;

use App\Livewire\User\Detail as UserDetail;

use App\Livewire\Proyek\Detail as ProyekDetail;

use App\Livewire\LaporanEkskul\Index as LaporanEkskulIndex;

use App\Livewire\HomePage\Index as HomePageIndex;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomePageIndex::class)->name('homePage');

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

// admin 
Route::get('/siswa', SiswaIndex::class)->middleware(['auth'])->name('siswaIndex')->lazy();

Route::middleware(['auth', 'check_permission:isAdmin'])->group(function () {
    Route::name('sekolah')->prefix('sekolah')->group(function () {
        Route::get('/', SekolahIndex::class)->name('Index');
        Route::get('/edit', SekolahEdit::class)->name('Edit');
    });

    Route::name('siswa')->prefix('siswa')->group(function () {
        Route::get('/create', SiswaCreate::class)->name('Create');
        Route::get('/{siswa}/edit', SiswaEdit::class)->name('Edit');
    });

    Route::name('ekskul')->prefix('ekskul')->group(function () {
        Route::get('/', EkskulIndex::class)->name('Index')->lazy();
        Route::get('/create', EkskulCreate::class)->name('Create');
        Route::get('/{ekskul}/edit', EkskulEdit::class)->name('Edit');
    });

    Route::name('mapel')->prefix('mapel')->group(function () {
        Route::get('/', MapelIndex::class)->name('Index')->lazy();
        Route::get('/create', MapelCreate::class)->name('Create');
        Route::get('/{mapel}/edit', MapelEdit::class)->name('Edit');
    });

    Route::name('user')->prefix('user')->group(function () {
        Route::get('/create', UserCreate::class)->name('Create');
        Route::get('/{user}/edit', UserEdit::class)->name('Edit');
    });

    Route::name('kepsek')->prefix('kepsek')->group(function () {
        Route::get('/', KepsekIndex::class)->name('Index')->lazy();
        Route::get('/create', KepsekCreate::class)->name('Create');
        Route::get('/{kepsek}/edit', KepsekEdit::class)->name('Edit');
    });

    Route::name('tahunAjaran')->prefix('tahun_ajaran')->group(function () {
        Route::get('/', TahunAjaranIndex::class)->name('Index')->lazy();
        Route::get('/create', TahunAjaranCreate::class)->name('Create');
        Route::get('/{tahunAjaran}/edit', TahunAjaranEdit::class)->name('Edit');
    });
});

Route::middleware(['auth', 'check_permission:isAdminOrKepsek'])->group(function () {
    Route::name('kelas')->prefix('kelas')->group(function () {
        Route::get('/', KelasIndex::class)->name('Index')->lazy();
        Route::get('/create', KelasCreate::class)->name('Create');
        Route::get('/{kelasData}/edit', KelasEdit::class)->name('Edit');
    });

    Route::get('/{kelasData}/config', KelasConfig::class)->name('kelasConfig')->middleware('check_permission:isKepsek');

    Route::name('prestasi')->prefix('prestasi')->group(function () {
        Route::get('/', PrestasiIndex::class)->name('Index')->lazy();
        Route::get('/create', PrestasiCreate::class)->name('Create');
        Route::get('/{prestasiData}/edit', PrestasiEdit::class)->name('Edit');
        Route::get('/{prestasiData}/detail', PrestasiDetail::class)->name('Detail');
    });
});


// kepsek
Route::middleware(['auth', 'check_permission:isKepsek'])->group(function () {
    // Route::name('waliKelas')->prefix('wali_kelas')->group(function () {
    //     Route::get('/', WaliKelasIndex::class)->name('Index')->lazy();
    //     Route::get('/create', WaliKelasCreate::class)->name('Create');
    //     Route::get('/{wali_kelas}/edit', WaliKelasEdit::class)->name('Edit');
    // });

    // Route::name('guruMapel')->prefix('guru_mapel')->group(function () {
    //     Route::get('/', GuruMapelIndex::class)->name('Index')->lazy();
    //     Route::get('/create', GuruMapelCreate::class)->name('Create');
    //     Route::get('/{guru_mapel}/edit', GuruMapelEdit::class)->name('Edit');
    // });
});

// guru kelas
Route::middleware(['auth', 'check_permission:isWaliKelas'])->group(function () {
    Route::name('dimensi')->prefix('dimensi')->group(function () {
        Route::get('/', DimensiIndex::class)->name('Index')->lazy();
        Route::get('/create', DimensiCreate::class)->name('Create');
        Route::get('/{dimensi}/edit', DimensiEdit::class)->name('Edit');
    });

    Route::name('elemen')->prefix('elemen')->group(function () {
        Route::get('/', ElemenIndex::class)->name('Index')->lazy();
        Route::get('/create', ElemenCreate::class)->name('Create');
        Route::get('/{elemen}/edit', ElemenEdit::class)->name('Edit');
    });

    Route::name('subelemen')->prefix('subelemen')->group(function () {
        Route::get('/', SubelemenIndex::class)->name('Index')->lazy();
        Route::get('/create', SubelemenCreate::class)->name('Create');
        Route::get('/{subelemen}/edit', SubelemenEdit::class)->name('Edit');
    });

    Route::name('capaianFase')->prefix('capaian_fase')->group(function () {
        Route::get('/', CapaianFaseIndex::class)->name('Index')->lazy();
        Route::get('/create', CapaianFaseCreate::class)->name('Create');
        Route::get('/{capaianFase}/edit', CapaianFaseEdit::class)->name('Edit');
    });
});

Route::middleware(['auth', 'check_permission:isWaliKelas'])->group(function () {
    Route::name('proyek')->prefix('proyek')->group(function () {
        Route::get('/create', ProyekCreate::class)->name('Create');
        Route::get('/{proyek}/edit', ProyekEdit::class)->name('Edit')->middleware('check_proyek_permission');
    });

    Route::name('catatanProyek')->prefix('catatan_proyek')->group(function () {
        Route::get('/', CatatanProyekIndex::class)
            ->name('Index');
        Route::get('/edit', CatatanProyekEdit::class)
            ->name('Edit');
    });

    Route::get('/subproyek/{proyek}', SubproyekIndex::class)
        ->name('subproyekIndex');

    Route::get('/nilai_proyek', NilaiSubproyekIndex::class)
        ->name('nilaiSubproyekIndex')->lazy();

    Route::get('/absensi', AbsensiIndex::class)->name('absensiIndex');

    Route::name('nilaiEkskul')->prefix('nilai_ekskul')->group(function () {
        Route::get('/{data}/edit', NilaiEkskulEdit::class)->name('Edit');
        Route::get('/create', NilaiEkskulCreate::class)->name('Create');
    });
});

Route::middleware(['auth', 'check_permission:isKepsekOrWaliKelas'])->group(function () {
    Route::get('/raporp5', RaporP5Index::class)->name('raporP5Index');
    Route::get('/raporp5/download/{siswa}/{kelasSiswa?}', [RaporP5Controller::class, 'cetak'])->name('cetakRaporP5');

    Route::get('/raporintra', RaporIntraIndex::class)->name('raporIntraIndex');

    Route::get('/raporintra/{siswa}/{kelasSiswa}/sampul/download', [RaporIntraController::class, 'cetakSampul'])
        ->name('cetakSampulRapor');

    Route::get('/raporintra/{siswa}/{kelasSiswa}/rapor/download', [RaporIntraController::class, 'cetakRapor'])
        ->name('cetakRaporIntra');
});

// guru mapel
Route::middleware(['auth', 'check_permission:isGuru'])->group(function () {
    Route::name('tujuanPembelajaran')->prefix('tujuan_pembelajaran')->group(function () {
        Route::get('/', TujuanPembelajaranIndex::class)
            ->name('Index')->lazy();
        Route::get('/create', TujuanPembelajaranCreate::class)
            ->name('Create');
        Route::get('/{tujuanPembelajaran}/edit', TujuanPembelajaranEdit::class)
            ->name('Edit');
    });

    Route::name('lingkupMateri')->prefix('lingkup_materi')->group(function () {
        Route::get('/', LingkupMateriIndex::class)
            ->name('Index')->lazy();
        Route::get('/create', LingkupMateriCreate::class)
            ->name('Create');
        Route::get('/{lingkupMateri}/edit', LingkupMateriEdit::class)->name('Edit');
    });

    Route::get('/nilai_sumatif', NilaiSumatifIndex::class)
        ->name('nilaiSumatifIndex')->lazy();

    Route::get('/nilai_formatif', NilaiFormatifIndex::class)
        ->name('nilaiFormatifIndex')->lazy();
});

Route::get('/nilai_sumatif_permapel', [NilaiSumatifExportController::class, 'cetak_permapel'])->middleware(['auth'])
    ->name('cetak_sumatif_permapel')->lazy();

Route::get('/laporan_sumatif_kelas', LaporanSumatifPerkelas::class)
    ->middleware(['auth', 'check_permission:isKepsekOrWaliKelas'])
    ->name('laporan_sumatif_kelas')->lazy();

Route::get('/laporan_sumatif_kelas/{kelas}', [NilaiSumatifPerkelasPDFController::class, 'printNilai'])
    ->middleware(['auth', 'check_permission:isKepsekOrWaliKelas'])
    ->name('laporan_sumatif_kelas_pdf')->lazy();

Route::get('/siswa/{siswa}', SiswaDetail::class)
    ->middleware(['auth'])
    ->name('detail_siswa')->lazy();

Route::middleware(['auth'])->group(function () {
    Route::name('user')->prefix('user')->group(function () {
        Route::get('/', UserIndex::class)
            ->name('Index')
            ->lazy();

        Route::get('/detail/{user}', UserDetail::class)
            ->name('Detail')
            ->lazy();
    });

    Route::get('/laporan_export_ekskul/{tahunAjaran}/{kelas?}', LaporanEkskulExportPDF::class)
        ->name('laporan_ekskul_pdf');

    Route::get('/laporan_ekskul', LaporanEkskulIndex::class)
        ->name('laporanEkskulIndex');

    Route::get('/riwayat_wali_kelas', RiwayatWaliKelasController::class)
        ->name('laporanRiwayatWaliKelas');

    Route::get('/riwayat_guru_mapel', RiwayatGuruMapelController::class)
        ->name('laporanRiwayatGuruMapel');

    Route::get('/proyek', ProyekIndex::class)->name('proyekIndex')->middleware(['check_permission:isKepsekOrWaliKelas'])->lazy();
    Route::get('/proyek/{proyek}', ProyekDetail::class)->name('proyekDetail')
        ->middleware(['check_permission:isKepsekOrWaliKelas', 'check_proyek_permission'])->lazy();

    Route::get('/laporan_proyek/{tahunAjaran?}/{query?}', LaporanProyekExportPDF::class)->name('laporanProyek')
        ->middleware(['check_permission:isKepsek'])->lazy();

    Route::get('/nilai_ekskul', NilaiEkskulIndex::class)->middleware(['check_permission:isKepsekOrWaliKelas'])
        ->name('nilaiEkskulIndex');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
