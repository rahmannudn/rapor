<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Auth\Access\Response;

class TahunAjaranPolicy
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
    public function view(User $user, TahunAjaran $TahunAjaran): bool
    {
        return $user->role == 'kepsek';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 'kepsek';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TahunAjaran $TahunAjaran): bool
    {
        return $user->role == 'kepsek';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TahunAjaran $TahunAjaran): bool
    {
        return $user->role == 'kepsek';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TahunAjaran $TahunAjaran): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TahunAjaran $TahunAjaran): bool
    {
        //
    }
}
