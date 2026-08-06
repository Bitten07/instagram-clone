<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FollowService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProfileController extends Controller {
    public function __construct(protected FollowService $followService) {}

    public function me(Request $request): JsonResponse {
        $user = $request->user();

        $user->loadCount(['followers', 'following']);
        
        $response = [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count,
        ];

        return response()->json($response, 200);
    }

    public function show(Request $request, User $user): JsonResponse {
        $userRequest = $request->user();

        $user->loadCount(['followers', 'following']);

        $response = [
            'name' => $user->name,
            'username' => $user->username,
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count,
            'is_following' => $this->followService->isFollowing($userRequest, $user),
        ];

        return response()->json($response, 200);
    }
}