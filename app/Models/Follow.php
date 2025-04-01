<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['following_id', 'followed_id'];
    //フォローしている
    public function followingUser() {
        return $this->belongsTo(User::class, 'following_id');

    }
    //フォロワー
    public function followedUser() {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
