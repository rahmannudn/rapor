<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Kelas;
use App\Helpers\FunctionHelper;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Cache;

class KelasPolicy
{

    public function before(User $user)
    {
        // return $user->role === 'superadmin';
    }
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
    public function view(User $user): bool
    {
        if ($user->role === 'admin' || $user->role === 'kepsek') return true;
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'kepsek' || $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Kelas $kelas): bool
    {
        $tahunAjaranAktif = FunctionHelper::getTahunAjaranAktif();
        return $user->role === 'kepsek' && $kelas['tahun_ajaran_id'] === $tahunAjaranAktif;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Kelas $kelas): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Kelas $kelas): bool
    {
        //
    }
}
