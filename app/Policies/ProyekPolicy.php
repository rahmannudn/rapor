<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Proyek;
use App\Models\WaliKelas;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProyekPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {}

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        // dd($user);
        $tahunAjaran = Cache::get('tahunAjaranAktif');
        $waliKelas = WaliKelas::where('user_id', '=', Auth::id())->where('tahun_ajaran_id', '=', $tahunAjaran)->get();
        return count($waliKelas) > 0 || $user->role == 'kepsek';
        // return true;
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
