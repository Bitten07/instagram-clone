<?php

namespace App\Services;

use App\Models\User;
use App\Models\Post;
use App\Exceptions\AlreadyLikedException;

class LikeService
{
    public function isLiked(User $user, Post $post): bool
    {
        return $user->likedPosts()->where('posts.id', $post->id)->exists();
    }


    function like(User $user, Post $post): void
    {
        if ($this->isLiked($user, $post)) {
            throw new AlreadyLikedException();
        }

        $user->likedPosts()->attach($post->id);
    }

    function unlike(User $user, Post $post): bool
    {
        return (bool) $user->likedPosts()->detach($post->id);
    }
}