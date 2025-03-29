<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'username',
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

    /** フォロー中（自分がフォローしているユーザー）*/
    public function followings()
    {
        //return $this->hasMany(Follow::class, 'following_id');
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }

    /** フォロワー（自分をフォローしているユーザー）*/
    public function followers()
    {
        //return $this->hasMany(Follow::class, 'followed_id');
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
    }
    /**　フォローしているかの判定 */
    public function isFollowing($userId)
    {
        return $this->followings()->where('followed_id', $userId)->exists();
    }

    // フォロー中の数を取得
    public function getFollowingCount()
    {
        return $this->followings()->count();
    }

    //フォロワー数を取得
    public function getFollowerCount()
    {
        return $this->followers()->count();
    }

    //投稿を取得
    public function posts()
{
    return $this->hasMany(Post::class, 'user_id');
}
}
