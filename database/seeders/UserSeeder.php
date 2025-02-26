<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::query()->delete();
        Post::query()->delete();
        Comment::query()->delete();
        // Crée un utilisateur spécifique pour les tests en premier
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Avoid duplicate admin
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Crée 10 utilisateurs avec des articles associés
        User::factory(10)->create()->each(function ($user) {
            Post::factory(3)->create(['user_id' => $user->id]);
        });
    }
}
