<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostLikePolicy
{
    public function update(User $user): bool
    {
        return $user->id === Auth::id();
    }

    public function delete(User $user): bool
    {
        return $user->id === Auth::id();
    }
}
