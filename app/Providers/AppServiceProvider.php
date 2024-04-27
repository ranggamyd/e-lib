<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Gate::define('manager', function (User $user) {
            if ($user->role == 'manager') {
                return $user->role;
            }
        });
        Gate::define('administrator', function (User $user) {
            if ($user->role == 'administrator') {
                return $user->role;
            }
        });
        Gate::define('staff', function (User $user) {
            if ($user->role == 'staff') {
                return $user->role;
            }
        });

        Gate::define('member', function (Member $member) {
            return $member;
        });
    }
}
