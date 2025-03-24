<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $category1 = Category::create(['name' => 'Tech']);
        $category2 = Category::create(['name' => 'Lifestyle']);

        Post::create(['title' => 'Tech Post 1', 'content' => 'Content about tech.', 'category_id' => $category1->id]);
        Post::create(['title' => 'Life Post 1', 'content' => 'Content about life.', 'category_id' => $category2->id]);
    }
}