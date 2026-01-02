<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        \App\Models\Watcher::class => \App\Policies\WatcherPolicy::class,
    ];

    public function boot(): void
    {
        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });
        Gate::define('access-manager', fn(User $user) => $user->role === 'manager');
    }
}
