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
        try {
            $this->followService->follow($request->user(), $user);
            return response()->json(['message' => 'Follow successful.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    
    public function unfollow(Request $request, User $user)
    {
        if (!$this->followService->unfollow($request->user(), $user)) {
            return response()->json(['error' => 'You are not following this user.'], 404);
        }

        return response()->json(['message' => 'Unfollow successful.'], 200);
    }
}