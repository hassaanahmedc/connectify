<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_topic');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_topic');
    }
}
