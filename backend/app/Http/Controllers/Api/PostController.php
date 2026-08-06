<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Services\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;



class PostController extends Controller
{
    public function __construct(protected PostService $postService){}

    public function store(StorePostRequest $request){

            $image = $request->file('image');
            $caption = $request->input('caption');

            $post = $this->postService->store($request->user(), $image, $caption);

            return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);        
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $posts = $this->postService->index($user);
        return response()->json($posts);
    }

    public function show(Post $post, Request $request) {
        $user = $request->user();
        $post = $this->postService->show($post, $user);
        return response()->json($post);
    }

    public function destroy(Post $post, Request $request)
    {
        try {
            $this->postService->delete($post, $request->user());
            return response()->noContent();
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
}