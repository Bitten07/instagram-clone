<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Http\UploadedFile;

class PostService
{
    public function store(User $user, UploadedFile $image, ?string $caption): Post
    {
        $path = Storage::disk('public')->putFile('images', $image);

        $post = Post::create([
            'user_id' => $user->id,
            'image_path' => $path,
            'caption' => $caption
        ]);

        return $post;
    }

    public function index(): LengthAwarePaginator
    {
        return Post::with('user')->paginate(10);
    }

    public function show(Post $post): Post
    {
        return $post->load('user');
    }

    public function delete(Post $post, User $user): void 
    {
        if ($post->user_id !== $user->id)
        {
            throw new AuthorizationException('You are not authorized to delete this post.');
        }

        $post->delete();
    }
}