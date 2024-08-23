<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RaporP5Controller;
use App\Http\Middleware\CheckPermission;
use App\Livewire\TahunAjaran\Index as TahunAjaranIndex;
use App\Livewire\TahunAjaran\Create as TahunAjaranCreate;
use App\Livewire\TahunAjaran\Edit as TahunAjaranEdit;

use App\Livewire\Siswa\Index as SiswaIndex;
use App\Livewire\Siswa\Create as SiswaCreate;
use App\Livewire\Siswa\Edit as SiswaEdit;

use App\Livewire\Sekolah\Index as SekolahIndex;
use App\Livewire\Sekolah\Edit as SekolahEdit;

use App\Livewire\Kelas\Index as KelasIndex;
use App\Livewire\Kelas\Create as KelasCreate;
use App\Livewire\Kelas\Edit as KelasEdit;
use App\Livewire\Kelas\Config as KelasConfig;

use App\Livewire\Ekskul\Index as EkskulIndex;
use App\Livewire\Ekskul\Create as EkskulCreate;
use App\Livewire\Ekskul\Edit as EkskulEdit;

use App\Livewire\Mapel\Index as MapelIndex;
use App\Livewire\Mapel\Create as MapelCreate;
use App\Livewire\Mapel\Edit as MapelEdit;

use App\Livewire\User\Index as UserIndex;
use App\Livewire\User\Create as UserCreate;
use App\Livewire\User\Edit as UserEdit;

use App\Livewire\WaliKelas\Index as WaliKelasIndex;
use App\Livewire\WaliKelas\Create as WaliKelasCreate;
use App\Livewire\WaliKelas\Edit as WaliKelasEdit;

use App\Livewire\GuruMapel\Index as GuruMapelIndex;
use App\Livewire\GuruMapel\Create as GuruMapelCreate;
use App\Livewire\GuruMapel\Edit as GuruMapelEdit;

use App\Livewire\MateriMapel\Index as MateriMapelIndex;
use App\Livewire\MateriMapel\Create as MateriMapelCreate;
use App\Livewire\MateriMapel\Edit as MateriMapelEdit;

use App\Livewire\Kepsek\Index as KepsekIndex;
use App\Livewire\Kepsek\Create as KepsekCreate;
use App\Livewire\Kepsek\Edit as KepsekEdit;

use App\Livewire\Proyek\Index as ProyekIndex;
use App\Livewire\Proyek\Create as ProyekCreate;
use App\Livewire\Proyek\Edit as ProyekEdit;

use App\Livewire\Dimensi\Index as DimensiIndex;
use App\Livewire\Dimensi\Create as DimensiCreate;
use App\Livewire\Dimensi\Edit as DimensiEdit;

use App\Livewire\Elemen\Index as ElemenIndex;
use App\Livewire\Elemen\Create as ElemenCreate;
use App\Livewire\Elemen\Edit as ElemenEdit;

use App\Livewire\Subelemen\Index as SubelemenIndex;
use App\Livewire\Subelemen\Create as SubelemenCreate;
use App\Livewire\Subelemen\Edit as SubelemenEdit;

use App\Livewire\CapaianFase\Index as CapaianFaseIndex;
use App\Livewire\CapaianFase\Create as CapaianFaseCreate;
use App\Livewire\CapaianFase\Edit as CapaianFaseEdit;

use App\Livewire\TujuanPembelajaran\Index as TujuanPembelajaranIndex;
use App\Livewire\TujuanPembelajaran\Create as TujuanPembelajaranCreate;
use App\Livewire\TujuanPembelajaran\Edit as TujuanPembelajaranEdit;

use App\Livewire\LingkupMateri\Index as LingkupMateriIndex;
use App\Livewire\LingkupMateri\Create as LingkupMateriCreate;
use App\Livewire\LingkupMateri\Edit as LingkupMateriEdit;

use App\Livewire\CatatanProyek\Index as CatatanProyekIndex;
use App\Livewire\CatatanProyek\Edit as CatatanProyekEdit;

use App\Livewire\Subproyek\Index as SubproyekIndex;

use App\Livewire\NilaiSubproyek\Index as NilaiSubproyekIndex;

use App\Livewire\Raporp5\Index as RaporP5Index;

use App\Models\Kelas;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome')->name('welcomePage');

Route::get('dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
})->middleware(['auth', 'verified'])->name('dashboard');

// admin 
Route::get('/siswa', SiswaIndex::class)->middleware(['auth'])->name('siswaIndex')->lazy();

Route::middleware(['auth', 'check_permission:superAdminOrAdmin'])->group(function () {
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
        Route::get('/', UserIndex::class)->name('Index')->lazy();
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
        Route::get('/', ProyekIndex::class)->name('Index')->lazy();
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

    Route::get('/raporp5', RaporP5Index::class)->name('raporP5Index');
    Route::get('/raporp5/{siswa}/download', [RaporP5Controller::class, 'cetak'])->name('cetakRaporP5');
    Route::get('/raporp5/{siswa}/view', [RaporP5Controller::class, 'view'])->name('viewRaporP5');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
