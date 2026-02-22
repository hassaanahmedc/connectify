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

    public function post()
    {
        return $this->belongsToMany(Post::class, 'posts_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
