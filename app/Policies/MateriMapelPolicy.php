<?php

namespace App\Policies;

use App\Models\MateriMapel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MateriMapelPolicy
{
    public function before(User $user)
    {
        if ($user->role == 'superadmin') return true;
        return false;
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
    public function view(User $user, MateriMapel $materiMapel): bool
    {
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
    public function update(User $user, MateriMapel $materiMapel): bool
    {
        // return $materiMapel->detailGuruMapel()->guru
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MateriMapel $materiMapel): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MateriMapel $materiMapel): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MateriMapel $materiMapel): bool
    {
        //
    }
}
