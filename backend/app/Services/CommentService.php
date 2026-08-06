<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Collection;
use \Illuminate\Auth\Access\AuthorizationException;


class CommentService
{
    public function store(User $user, Post $post, string $body): Comment
    {
        return Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => $body
        ]);
    }

    public function index(Post $post): Collection
    {
        return $post->comments()->with('user')->get();
    }

    public function delete(User $user, Comment $comment): void
    {
        if ($comment->user_id !== $user->id) 
            {
                throw new AuthorizationException('You are not authorized to delete this comment');
            }

        $comment->delete();
    }
}