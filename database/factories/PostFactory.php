<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(5),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}

