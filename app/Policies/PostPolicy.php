<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(User $user)
    {
        return $user->is_super_admin
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function view(User $user, Post $model)
    {
        return $model->author->is_private && $user->id !== $model->author->id
            ? Response::denyAsNotFound()
            : Response::allow();
    }

    public function update(User $user, Post $model)
    {
        return $user->id === $model->author->id;
    }

    public function delete(User $user, Post $model)
    {
        return $user->id === $model->author->id;
    }
}
