<?php
namespace App\Policies;

use App\Models\User;

class WatcherPolicy
{

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'manager']);
    }

    public function update(User $user, $watcher)
    {
        return in_array($user->role, ['admin', 'manager']);
    }
}
