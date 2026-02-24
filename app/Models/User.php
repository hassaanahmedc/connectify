<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'cover',
        'avatar',
        'bio',
        'location',
        'website',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function comment()
    {
        return $this->hasMany(Post::class);
    }

    public function tokens(): MorphMany
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id');
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    public function follow(User $user)
    {
        if ($this->id === $user->id) return false;
        return $this->following()->syncWithoutDetaching([$user->id]);
    }

    public function unfollow(User $user)
    {
        return $this->following()->detach($user->id);
    }

    public function avatarUrl(): Attribute 
    {
        return Attribute::make(
            get: function () {
                if (!$this->avatar) {
                    return 'https://api.dicebear.com/7.x/adventurer/svg?seed=default';
                }

                return str_starts_with($this->avatar, 'http') 
                    ? $this->avatar 
                    : asset('storage/' . $this->avatar);
                },
        );
    }

    public function coverUrl(): Attribute 
    {
        return Attribute::make(
            get: function () {
                if (!$this->cover) {
                    return 'https://picsum.photos/1200/300';
                }
    
                return str_starts_with($this->cover, 'http') 
                    ? $this->cover 
                    : asset('storage/' . $this->cover);
                },
        );
    }

    public function topics() 
    {
        return $this->belongsToMany(Topic::class, 'user_topic');
    }
}
 