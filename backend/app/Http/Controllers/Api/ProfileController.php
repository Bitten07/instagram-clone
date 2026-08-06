<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FollowService;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\AvatarProfileRequest;

class ProfileController extends Controller {
    public function __construct(protected FollowService $followService, protected ProfileService $profileService) {}

    public function me(Request $request): JsonResponse 
    {
        $user = $request->user();

        $user->loadCount(['followers', 'following', 'posts']);
        
        $response = [
            'avatar_path' =>$user->avatar_path,
            'name' => $user->name,
            'username' => $user->username,
            'bio' => $user->bio,
            'email' => $user->email,
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count,
            'posts_count' => $user->posts_count
        ];

        return response()->json($response, 200);
    }

    public function show(Request $request, User $user): JsonResponse 
    {
        $userRequest = $request->user();

        $user->loadCount(['followers', 'following', 'posts']);

        $response = [
            'avatar_path' => $user->avatar_path,
            'name' => $user->name,
            'username' => $user->username,
            'bio' => $user->bio,
            'followers_count' => $user->followers_count,
            'following_count' => $user->following_count,
            'is_following' => $this->followService->isFollowing($userRequest, $user),
            'posts_count' => $user->posts_count
        ];

        return response()->json($response, 200);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $user->fill($request->validated());
        $user->save();

        return response()->json(['message' => 'Profile updated successfully.', 'user' => $user], 200);
    }

    public function avatar(AvatarProfileRequest $request)
    {
        $user = $request->user();

        $avatar = $this->profileService->updateAvatar($user, $request->file('avatar'));

        return response()->json(['message' => 'Avatar profile updated successfully.','user' => $avatar], 200);
    }
}