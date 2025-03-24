<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(),
            'category_id' => Category::factory(),
        ];
    }
}
