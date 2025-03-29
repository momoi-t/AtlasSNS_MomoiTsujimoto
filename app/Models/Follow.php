<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['following_id', 'followed_id'];
    //フォローしている
    public function following_id() {
        return $this->belongsTo(User::class, 'following_id');
    }
    //フォロワー
    public function followed() {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
