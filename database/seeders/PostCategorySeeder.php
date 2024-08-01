<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostCategory;

class PostCategorySeeder extends Seeder
{
    public function run()
    {
        // Create 10 fake post categories
        PostCategory::factory()->count(10)->create();
    }
}

