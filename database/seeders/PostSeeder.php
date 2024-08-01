<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Create 10 fake posts
        Post::factory()->count(10)->create()->each(function ($post) {
            // Get random categories and attach them to the post
            $categories = PostCategory::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $post->categories()->attach($categories);
        });
    }
}

