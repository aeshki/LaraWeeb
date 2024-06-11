<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'message',
        'user_id'
    ];

    protected $hidden = [
        'user_id',
        'updated_at'
    ];

    public function author()
    {   
        return $this->belongsTo(User::class, 'user_id');
    }
}
