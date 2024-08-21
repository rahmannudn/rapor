<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Proyek;
use App\Models\WaliKelas;
use App\Models\NilaiProyek;
use App\Helpers\FunctionHelper;
use Illuminate\Auth\Access\Response;

class NilaiSubproyekPolicy
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
    public function view(User $user, NilaiProyek $nilaiProyek): bool
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
    public function delete(User $user, NilaiProyek $nilaiProyek): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NilaiProyek $nilaiProyek): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NilaiProyek $nilaiProyek): bool
    {
        //
    }
}
