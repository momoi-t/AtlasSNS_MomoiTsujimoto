<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    //postカラムに値を挿入
    protected $fillable = ['post','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
