<?php

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

use App\Http\Controllers\GuruMapelSearch;
use App\Http\Controllers\MapelSearch;

use App\Models\Kepsek;
use App\Models\LingkupMateri;
use App\Models\TujuanPembelajaran;
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

Route::view('/', 'welcome');

Route::get('dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tahun_ajaran', TahunAjaranIndex::class)->middleware(['auth'])->name('tahunAjaranIndex');
Route::get('/tahun_ajaran/create', TahunAjaranCreate::class)->middleware(['auth'])->name('tahunAjaranCreate');
Route::get('/tahun_ajaran/{tahunAjaran}/edit', TahunAjaranEdit::class)->middleware(['auth'])->name('tahunAjaranEdit');

Route::get('/siswa', SiswaIndex::class)->middleware(['auth'])->name('siswaIndex');
Route::get('/siswa/create', SiswaCreate::class)->middleware(['auth'])->name('siswaCreate');
Route::get('/siswa/{siswa}/edit', SiswaEdit::class)->middleware(['auth'])->name('siswaEdit');

Route::get('/sekolah', SekolahIndex::class)->middleware(['auth'])->name('sekolahIndex');
Route::get('/sekolah/edit', SekolahEdit::class)->middleware(['auth'])->name('sekolahEdit');

Route::get('/kelas', KelasIndex::class)->middleware(['auth'])->name('kelasIndex');
Route::get('/kelas/create', KelasCreate::class)->middleware(['auth'])->name('kelasCreate');
Route::get('/kelas/{kelasData}/edit', KelasEdit::class)->middleware(['auth'])->name('kelasEdit');

Route::get('/ekskul', EkskulIndex::class)->middleware(['auth'])->name('ekskulIndex');
Route::get('/ekskul/create', EkskulCreate::class)->middleware(['auth'])->name('ekskulCreate');
Route::get('/ekskul/{ekskul}/edit', EkskulEdit::class)->middleware(['auth'])->name('ekskulEdit');

Route::get('/mapel', MapelIndex::class)->middleware(['auth'])->name('mapelIndex');
Route::get('/mapel/create', MapelCreate::class)->middleware(['auth'])->name('mapelCreate');
Route::get('/mapel/{mapel}/edit', MapelEdit::class)->middleware(['auth'])->name('mapelEdit');

Route::get('/user', UserIndex::class)->middleware(['auth'])->name('userIndex');
Route::get('/user/create', UserCreate::class)->middleware(['auth'])->name('userCreate');
Route::get('/user/{user}/edit', UserEdit::class)->middleware(['auth'])->name('userEdit');

Route::get('/wali_kelas', WaliKelasIndex::class)->middleware(['auth'])->name('waliKelasIndex');
Route::get('/wali_kelas/create', WaliKelasCreate::class)->middleware(['auth'])->name('waliKelasCreate');
Route::get('/wali_kelas/{wali_kelas}/edit', WaliKelasEdit::class)->middleware(['auth'])->name('waliKelasEdit');

Route::get('/guru_mapel', GuruMapelIndex::class)->middleware(['auth'])->name('guruMapelIndex');
Route::get('/guru_mapel/create', GuruMapelCreate::class)->middleware(['auth'])->name('guruMapelCreate');
Route::get('/guru_mapel/{guru_mapel}/edit', GuruMapelEdit::class)->middleware(['auth'])->name('guruMapelEdit');

Route::get('/materi_mapel', MateriMapelIndex::class)->middleware(['auth'])->name('materiMapelIndex');
Route::get('/materi_mapel/create', MateriMapelCreate::class)->middleware(['auth'])->name('materiMapelCreate');
Route::get('/materi_mapel/{materiMapel}/edit', MateriMapelEdit::class)->middleware(['auth'])->name('materiMapelEdit');

Route::get('/kepsek', KepsekIndex::class)->middleware(['auth'])->name('kepsekIndex');
Route::get('/kepsek/create', KepsekCreate::class)->middleware(['auth'])->name('kepsekCreate');
Route::get('/kepsek/{kepsek}/edit', KepsekEdit::class)->middleware(['auth'])->name('kepsekEdit');

Route::get('/proyek', ProyekIndex::class)->middleware(['auth'])->name('proyekIndex');
Route::get('/proyek/create', ProyekCreate::class)->middleware(['auth'])->name('proyekCreate');
Route::get('/proyek/{proyek}/edit', ProyekEdit::class)->middleware(['auth'])->name('proyekEdit');

Route::get('/dimensi', DimensiIndex::class)->middleware(['auth'])->name('dimensiIndex');
Route::get('/dimensi/create', DimensiCreate::class)->middleware(['auth'])->name('dimensiCreate');
Route::get('/dimensi/{dimensi}/edit', DimensiEdit::class)->middleware(['auth'])->name('dimensiEdit');

Route::get('/elemen', ElemenIndex::class)->middleware(['auth'])->name('elemenIndex');
Route::get('/elemen/create', ElemenCreate::class)->middleware(['auth'])->name('elemenCreate');
Route::get('/elemen/{elemen}/edit', ElemenEdit::class)->middleware(['auth'])->name('elemenEdit');

Route::get('/subelemen', SubelemenIndex::class)->middleware(['auth'])->name('subelemenIndex');
Route::get('/subelemen/create', SubelemenCreate::class)->middleware(['auth'])->name('subelemenCreate');
Route::get('/subelemen/{subelemen}/edit', SubelemenEdit::class)->middleware(['auth'])->name('subelemenEdit');

Route::get('/capaian_fase', CapaianFaseIndex::class)->middleware(['auth'])->name('capaianFaseIndex');
Route::get('/capaian_fase/create', CapaianFaseCreate::class)->middleware(['auth'])->name('capaianFaseCreate');
Route::get('/capaian_fase/{capaianFase}/edit', CapaianFaseEdit::class)->middleware(['auth'])->name('capaianFaseEdit');

Route::get('/tujuan_pembelajaran', TujuanPembelajaranIndex::class)->middleware(['auth'])
    ->name('tujuanPembelajaranIndex');
Route::get('/tujuan_pembelajaran/create', TujuanPembelajaranCreate::class)->middleware(['auth'])
    ->name('tujuanPembelajaranCreate');
Route::get('/tujuan_pembelajaran/{tujuanPembelajaran}/edit', TujuanPembelajaranEdit::class)
    ->middleware(['auth'])->name('tujuanPembelajaranEdit');

Route::get('/lingkup_materi', LingkupMateriIndex::class)->middleware(['auth'])
    ->name('lingkupMateriIndex');
Route::get('/lingkup_materi/create', LingkupMateriCreate::class)->middleware(['auth'])
    ->name('lingkupMateriCreate');
Route::get('/lingkup_materi/{lingkupMateri}/edit', LingkupMateriEdit::class)->middleware(['auth'])->name('lingkupMateriEdit');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
