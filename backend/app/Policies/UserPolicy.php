<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function view(User $actor, User $target): bool
    {
        return $actor->is($target);
    }

    public function update(User $actor, User $target): bool
    {
        return $actor->is($target);
    }
}
