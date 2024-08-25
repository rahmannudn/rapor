<?php

namespace App\Policies;

use App\Models\KelasSiswa;
use App\Models\NilaiEkskul;
use App\Models\User;
use App\Models\WaliKelas;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Cache;

class NilaiEkskulPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NilaiEkskul $nilaiEkskul): bool
    {
        // 
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, $siswaId): bool
    {
        $tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $kelas = KelasSiswa::where('tahun_ajaran_id', $tahunAjaranAktif)
            ->where('siswa_id', $siswaId)
            ->select('kelas_siswa.kelas_id')
            ->first();
        $waliKelas = WaliKelas::where('tahun_ajaran_id', $tahunAjaranAktif)
            ->where('user_id', $user->id)
            ->select('wali_kelas.kelas_id')
            ->first();

        return $kelas['kelas_id'] === $waliKelas['kelas_id'];
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NilaiEkskul $nilaiEkskul): bool
    {
        $tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $kelas = NilaiEkskul::where('nilai_ekskul.id', $nilaiEkskul['id'])
            ->join('kelas_siswa', 'kelas_siswa.id', 'nilai_ekskul.kelas_siswa_id')
            ->where('kelas_siswa.tahun_ajaran_id', $tahunAjaranAktif)
            ->select('kelas_siswa.kelas_id')
            ->first();
        $waliKelas = WaliKelas::where('tahun_ajaran_id', $tahunAjaranAktif)
            ->where('user_id', $user->id)
            ->select('wali_kelas.kelas_id')
            ->first();

        return $kelas['kelas_id'] === $waliKelas['kelas_id'];
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, $nilaiEkskul): bool
    {
        $tahunAjaranAktif = Cache::get('tahunAjaranAktif');
        $kelas = NilaiEkskul::where('nilai_ekskul.id', $nilaiEkskul)
            ->join('kelas_siswa', 'kelas_siswa.id', 'nilai_ekskul.kelas_siswa_id')
            ->where('kelas_siswa.tahun_ajaran_id', $tahunAjaranAktif)
            ->select('kelas_siswa.kelas_id')
            ->first();
        $waliKelas = WaliKelas::where('tahun_ajaran_id', $tahunAjaranAktif)
            ->where('user_id', $user->id)
            ->select('wali_kelas.kelas_id')
            ->first();

        return $kelas['kelas_id'] === $waliKelas['kelas_id'];
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NilaiEkskul $nilaiEkskul): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NilaiEkskul $nilaiEkskul): bool
    {
        //
    }
}
