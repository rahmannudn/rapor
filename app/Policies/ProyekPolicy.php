<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Proyek;
use App\Models\WaliKelas;
use App\Helpers\FunctionHelper;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProyekPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Proyek $proyek): bool
    {
        // $tahunAjaran = FunctionHelper::getTahunAjaranAktif();
        // $waliKelas = WaliKelas::where('tahun_ajaran_id', '=', $tahunAjaran)
        //     ->where('user_id', $user->id)
        //     ->select('id')
        //     ->first();
        $waliKelas = WaliKelas::where('wali_kelas.id', '=', $proyek['wali_kelas_id'])
            ->select('wali_kelas.user_id')
            ->first();

        return ($user->id == $waliKelas['user_id']) || $user->role === 'kepsek';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool {}

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 'guru';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Proyek $proyek): bool
    {
        $tahunAjaran = FunctionHelper::getTahunAjaranAktif();
        $waliKelas = WaliKelas::where('tahun_ajaran_id', '=', $tahunAjaran)
            ->where('user_id', $user->id)
            ->select('id')
            ->first();

        return $proyek->wali_kelas_id == $waliKelas['id'];
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Proyek $proyek): bool
    {
        $tahunAjaran = FunctionHelper::getTahunAjaranAktif();
        $waliKelas = WaliKelas::where('tahun_ajaran_id', '=', $tahunAjaran)
            ->where('user_id', $user->id)
            ->select('id')
            ->first();

        return $proyek->wali_kelas_id == $waliKelas['id'];
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Proyek $proyek): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Proyek $proyek): bool
    {
        //
    }
}
