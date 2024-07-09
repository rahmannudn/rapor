<?php

namespace App\Policies;

use App\Models\TujuanPembelajaran;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TujuanPembelajaranPolicy
{
    public function before(User $user): bool
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
    public function view(User $user, TujuanPembelajaran $tujuanPembelajaran): bool
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
    public function update(User $user, TujuanPembelajaran $tujuanPembelajaran): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TujuanPembelajaran $tujuanPembelajaran): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TujuanPembelajaran $tujuanPembelajaran): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TujuanPembelajaran $tujuanPembelajaran): bool
    {
        //
    }
}
