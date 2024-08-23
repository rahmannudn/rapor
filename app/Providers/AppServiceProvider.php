<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Kepsek;
use App\Models\Proyek;
use Livewire\Livewire;
use App\Livewire\Navbar;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Policies\ProyekPolicy;
use App\Helpers\FunctionHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isSuperAdmin', function (User $user) {
            return $user->role == 'superadmin';
        });
        Gate::define('superAdminOrKepsek', function (User $user) {
            $isKepsekAktif = $user->role == 'kepsek' && Cache::get('kepsekAktif') === Auth::id();
            if ($user->role == 'superadmin' || $isKepsekAktif) return true;
            return false;
        });
        Gate::define('superAdminOrAdmin', function (User $user) {
            if ($user->role == 'superadmin' || $user->role == 'admin') return true;
            return false;
        });
        Gate::define('isAdminOrKepsek', function (User $user) {
            $isKepsekAktif = $user->role == 'kepsek' && Cache::get('kepsekAktif') === Auth::id();

            if ($user->role == 'admin' || $user->role == 'superadmin' || $isKepsekAktif) return true;
            return false;
        });
        Gate::define('isAdmin', function (User $user) {
            return $user->role == 'admin';
        });
        Gate::define('isGuru', function (User $user) {
            return $user->role == 'guru';
        });
        Gate::define('isWaliKelas', function (User $user) {
            $tahunAjaran = Cache::get('tahunAjaranAktif');
            $waliKelas = WaliKelas::where('user_id', '=', $user->id)->where('tahun_ajaran_id', '=', $tahunAjaran)->get();

            return count($waliKelas) > 0;
        });
        Gate::define('isKepsek', function (User $user) {
            $isKepsekAktif = $user->role == 'kepsek' && Cache::get('kepsekAktif') === $user->id;
            return $isKepsekAktif;
        });
    }
}
