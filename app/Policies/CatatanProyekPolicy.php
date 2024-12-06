<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Proyek;
use App\Models\WaliKelas;
use App\Models\CatatanProyek;
use App\Helpers\FunctionHelper;
use Illuminate\Auth\Access\Response;

class CatatanProyekPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // return $user->role == 'admin' || $user->role == 'kepsek';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CatatanProyek $catatanProyek): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
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
    public function delete(User $user, CatatanProyek $catatanProyek): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CatatanProyek $catatanProyek): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CatatanProyek $catatanProyek): bool
    {
        //
    }
}
