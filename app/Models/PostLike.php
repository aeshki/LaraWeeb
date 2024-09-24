<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostLike extends Pivot
{
    protected $fillable = [
        'user_id',
        'post_id'
    ];

    public function posts()
    {   
        return $this->hasMany(Post::class);
    }

    public function users()
    {   
        return $this->hasMany(User::class);
    }
}
