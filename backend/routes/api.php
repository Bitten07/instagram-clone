<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/follow/{user}', [FollowController::class, 'follow']);
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow']);

    Route::get('/profile', [ProfileController::class, 'me']);
    Route::get('/users/{user}', [ProfileController::class, 'show']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::patch('/profile/avatar', [ProfileController::class, 'avatar']);

    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    Route::post('/like/{post}', [LikeController::class, 'like']);
    Route::delete('/like/{post}', [LikeController::class, 'unlike']);

    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    Route::get('/search', [SearchController::class, 'search']);
});