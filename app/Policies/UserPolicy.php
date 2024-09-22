<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->is_super_admin) {
            return true;
        }
     
        return null;
    }

    public function viewAny(User $user)
    {
        return $user->is_super_admin
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model)
    {
        return $user->id === $model->id;
    }
}
