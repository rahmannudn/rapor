<?php

namespace App\Policies;

use App\Models\Ekskul;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EkskulPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ekskul $ekskul): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ekskul $ekskul): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ekskul $ekskul): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ekskul $ekskul): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ekskul $ekskul): bool
    {
        //
    }
}
