<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{

    use HasFactory;

    protected $fillable = ['user_id', 'image_path', 'caption'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likedBy() {
        return $this->belongsToMany(User::class, 'post_user');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
