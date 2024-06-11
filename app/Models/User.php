<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'avatar',
        'username',
        'pseudo',
        'email',
        'password',
    ];

    protected $hidden = [
        'email',
        'updated_at',
        'is_super_admin',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return is_numeric($value) ? $this->where('id', $value)->firstOrFail() :  $this->where('username', $value)->firstOrFail();
    }

    public function posts()
    {   
        return $this->hasMany(Post::class);
    }
}
