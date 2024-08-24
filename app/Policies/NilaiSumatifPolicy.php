<?php

namespace App\Policies;

use App\Models\NilaiSumatif;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NilaiSumatifPolicy
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
    public function view(User $user, NilaiSumatif $nilaiSumatif): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, $user_id): bool {}

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, $user_id): bool
    {
        return $user->id === $user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NilaiSumatif $nilaiSumatif): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NilaiSumatif $nilaiSumatif): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NilaiSumatif $nilaiSumatif): bool
    {
        //
    }
}
