<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subproyek;
use App\Models\WaliKelas;
use App\Helpers\FunctionHelper;
use App\Models\Proyek;
use Illuminate\Auth\Access\Response;

class SubproyekPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Proyek $proyek): bool
    {
        // 
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, subproyek $subproyek): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Proyek $proyek): bool
    {
        $tahunAjaran = FunctionHelper::getTahunAjaranAktif();

        $waliKelas = WaliKelas::where('tahun_ajaran_id', '=', $tahunAjaran)
            ->where('user_id', $user->id)
            ->select('id')
            ->first();

        return $proyek->wali_kelas_id == $waliKelas['id'];
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, subproyek $subproyek): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subproyek $subproyek): bool
    {
        $tahunAjaran = FunctionHelper::getTahunAjaranAktif();

        $waliKelas = WaliKelas::where('tahun_ajaran_id', '=', $tahunAjaran)
            ->where('user_id', $user->id)
            ->select('id')
            ->first();

        return $subproyek->proyek->wali_kelas_id == $waliKelas['id'];
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, subproyek $subproyek): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, subproyek $subproyek): bool
    {
        //
    }
}
