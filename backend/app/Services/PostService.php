<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Services\LikeService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Auth\Access\AuthorizationException;



class PostService
{
    public function __construct(protected LikeService $likeService) {}

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

    public function index(User $user): LengthAwarePaginator
    {
        $userId = $user->id;

        $response = Post::with('user')->withCount(['likedBy', 'comments'])->withExists(['likedBy as liked_by_me' => function ($query) use ($userId) {
            $query->where('users.id', $userId);
        }])->paginate(10);

        return $response;
    }

    public function show(Post $post, User $user): Post
    {
        $response = $post->loadCount(['likedBy', 'comments']);
        $response->liked_by_me = $this->likeService->isLiked($user, $post);
        return $response;

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