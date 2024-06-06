<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
