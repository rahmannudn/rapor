<?php

namespace App\Providers;

use App\Helpers\FunctionHelper;
use App\Models\User;
use App\Models\Proyek;
use Livewire\Livewire;
use App\Livewire\Navbar;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use App\Policies\ProyekPolicy;
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
        FunctionHelper::setCacheTahunAjaran();

        Gate::define('isSuperAdmin', function (User $user) {
            return $user->role == 'superadmin';
        });
        Gate::define('superAdminOrKepsek', function (User $user) {
            if ($user->role == 'superadmin' || $user->role == 'kepsek') return true;
            return false;
        });
        Gate::define('superAdminOrAdmin', function (User $user) {
            if ($user->role == 'superadmin' || $user->role == 'admin') return true;
            return false;
        });
        Gate::define('isAdminOrKepsek', function (User $user) {
            if ($user->role == 'admin' || $user->role == 'superadmin' || $user->role == 'kepsek') return true;
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
            $waliKelas = WaliKelas::where('user_id', '=', Auth::id())->where('tahun_ajaran_id', '=', $tahunAjaran)->get();
            return count($waliKelas) > 0 || $user->role == 'kepsek';
        });
        Gate::define('isKepsek', function (User $user) {
            return $user->role == 'kepsek';
        });
    }
}
