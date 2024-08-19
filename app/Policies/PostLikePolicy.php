<?php

namespace App\Policies;

use App\Models\User;

class PostLikePolicy
{
    public function update(User $user): bool
    {
        return $user->id === auth()->id();
    }

    public function delete(User $user): bool
    {
        return $user->id === auth()->id();
    }
}
