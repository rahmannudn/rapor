<?php

namespace App\Policies;

use App\Models\Proyek;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProyekPolicy
{
    public function before(User $user)
    {
        return $user->role == 'superadmin';
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Proyek $proyek): bool
    {
        if ($user->role == 'kepsek' || $user->role == 'guru') return true;
        return false;
    }

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
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Proyek $proyek): bool
    {
        //
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
