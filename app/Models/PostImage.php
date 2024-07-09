<?php

namespace App\Models;
use App\Http\Requests\Post\CreatePostRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'posts_id',
        'path',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }    
}
