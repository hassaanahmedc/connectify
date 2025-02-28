<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
    ];

    public function postImages()
    {
        return $this->hasMany(PostImage::class, 'posts_id');
    }

    public function likes()
    {
        return $this->hasMany(Likes::class, 'posts_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'posts_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
