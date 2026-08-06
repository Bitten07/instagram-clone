<?php

namespace App\Services;

use App\Models\User;
use \Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function updateAvatar(User $user, UploadedFile $image): User
    {
        $path = Storage::disk('public')->putFile('avatars', $image);

        $user->avatar_path = $path;
        $user->save();
        return $user;
    }
}