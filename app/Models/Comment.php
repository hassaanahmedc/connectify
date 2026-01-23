<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'posts_id',
        'user_id',
        'content',
    ];

    public function commentImages()
    {
        return $this->hasMany(CommentImages::class, 'comments_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
