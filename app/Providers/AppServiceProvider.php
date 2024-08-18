<?php

namespace App\Providers;

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Navbar;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('isKepsek', function (User $user) {
            return $user->role == 'kepsek';
        });
    }
}
