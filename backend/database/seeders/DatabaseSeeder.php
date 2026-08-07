<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = User::factory()->count(10)->create();

        foreach ($users as $user) {
            Post::factory()->count(rand(2, 5))->for($user)->create();
        }

        $posts = Post::all();

        foreach ($posts as $post) {
            Comment::factory()->count(rand(0, 3))->for($post)->for($users->random())->create();
        }

        foreach ($posts as $post) {
            $likers = $users->random(rand(0, 5)); 
            
            foreach ($likers as $liker) {
                $liker->likedPosts()->attach($post->id);
            }
        }

        foreach ($users as $user) {
            $others = $users->reject(fn($u) => $u->id === $user->id);
            $following = $others->random(rand(1, 5)); 
            
            foreach ($following as $target) {
                $user->following()->attach($target->id);
            }
        }
    }
}
