<?php

namespace App\Models;

use App\Enums\UserBadges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'avatar',
        'banner',
        'banner_color',
        'pseudo',
        'username',
        'bio',
        'favorite_anime',
        'favorite_manga',
        'favorite_webtoon',
        'email',
        'password',
        'is_private'
    ];

    protected $hidden = [
        'active',
        'email',
        'updated_at',
        'is_super_admin',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected $appends = [
        'flags',
        'total_likes'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_private' => 'boolean'
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if (is_numeric($value)) {
            return $this->where('id', $value)->firstOrFail();
        } else {
            return $value === '@me' ? Auth::user()->makeVisible([ 'email' ]) : $this->where('username', $value)->firstOrFail();
        }
    }

    protected function getTotalLikesAttribute()
    {
        return $this->posts()->withCount('likes')->get()->sum('likes_count');
    }

    protected function getFlagsAttribute()
    {
        $flags = 0;

        if ($this->id == 1) {
            $flags |= UserBadges::DEVELOPER->value;
        }

        if ($this->is_super_admin) {
            $flags |= UserBadges::STAFF->value;
        }

        return $flags;
    }

    public function scopePublic(Builder $query): void
    {
        $query->where('is_private', false);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function posts()
    {   
        return $this->hasMany(Post::class);
    }
}
