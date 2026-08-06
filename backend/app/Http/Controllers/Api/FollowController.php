<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FollowService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct(protected FollowService $followService) {}

    public function follow(Request $request, User $user)
    {
        $this->followService->follow($request->user(), $user);        
        return response()->json(["message" => "Follow user successfully."], 201);
    }
    
    public function unfollow(Request $request, User $user)
    {
        if (!$this->followService->unfollow($request->user(), $user)) {
            return response()->json(['error' => 'You are not following this user.'], 404);
        }

        return response()->json(['message' => 'Unfollow successful.'], 200);
    }
}