<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $with = [
        'author'
    ];

    protected $fillable = [
        'message',
        'user_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function author()
    {   
        return $this->belongsTo(User::class, 'user_id');
    }

}
