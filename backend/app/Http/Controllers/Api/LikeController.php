<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LikeService;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function __construct(protected LikeService $likeService){}

    public function like(Request $request, Post $post){
        $this->likeService->like($request->user(), $post);
        return response()->json(["message" => "Post liked successfully."], 201);
    }

    public function unlike(Request $request, Post $post) {
        if (!$this->likeService->unlike($request->user(), $post)){
            return response()->json(['error' => 'You have not liked this post yet.'], 404);
        }
        return response()->json(['message' => 'Unliked successful.'], 200);
    }
}
