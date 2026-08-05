<?php

namespace App\Services;

use App\Models\User;

class FollowService
{

    public function isFollowing(User $follower, User $following): bool
    {
        return $follower->following()->where('users.id', $following->id)->exists();
    }


    function follow(User $follower, User $following): void
    {
        if ($follower->id === $following->id) {
            throw new \Exception("You cannot follow yourself.");
        }

        if ($this->isFollowing($follower, $following)) {
            throw new \Exception("You are already following this user.");
        }

        $follower->following()->attach($following->id);
    }

    function unfollow(User $follower, User $following): bool
    {
        return (bool) $follower->following()->detach($following->id);
    }
}