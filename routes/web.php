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

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
