<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\AlreadyFollowingException;
use App\Exceptions\FollowYourselfException;

class FollowService
{

    public function isFollowing(User $follower, User $following): bool
    {
        return $follower->following()->where('users.id', $following->id)->exists();
    }


    function follow(User $follower, User $following): void
    {
        if ($follower->id === $following->id) {
            throw new FollowYourselfException();
        }

        if ($this->isFollowing($follower, $following)) {
            throw new AlreadyFollowingException();
        }

        $follower->following()->attach($following->id);
    }

    function unfollow(User $follower, User $following): bool
    {
        return (bool) $follower->following()->detach($following->id);
    }
}