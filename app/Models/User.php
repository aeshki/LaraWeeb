<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
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

    protected function getTotalLikesAttribute()
    {
        return $this->posts()->withCount('likes')->get()->sum('likes_count');
    }

    protected function getFlagsAttribute()
    {
        $Badges = [
            'STAFF' => 1 << 0,
            'DEVELOPER' => 1 << 1,
            'STAR' => 1 << 2,
            'PRIVATE' => 1 << 3,
        ];

        $flags = 0;

        if ($this->id == 1) {
            $flags |= $Badges['DEVELOPER'];
        }

        if ($this->is_super_admin) {
            $flags |= $Badges['STAFF'];
        }
    
        if ($this->getTotalLikesAttribute() > 9 && !$this->is_private) {
            $flags |= $Badges['STAR'];
        }

        if ($this->is_private) {
            $flags |= $Badges['PRIVATE'];
        }

        return $flags;
    }

    public function scopePublic(Builder $query): void
    {
        $query->where('is_private', false);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return is_numeric($value) ? $this->where('id', $value)->firstOrFail() :  $this->where('username', $value)->firstOrFail();
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
