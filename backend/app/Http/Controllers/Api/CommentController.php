<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Auth\Access\AuthorizationException;

class CommentController extends Controller
{
    public function __construct(protected CommentService $commentService) {}

    public function store(StoreCommentRequest $request, Post $post){
        
        $comment = $this->commentService->store($request->user(), $post, $request->input('body'));
        
        return response()->json(['message' => 'Comment created successfully.', 'comment' => $comment], 201);
    }

    public function index(Post $post){
        $comment = $this->commentService->index($post);
        return response()->json($comment, 200);
    }

    public function destroy(Comment $comment, Request $request)
    {
        $this->commentService->delete($request->user(), $comment);
        return response()->noContent();
    }
}
