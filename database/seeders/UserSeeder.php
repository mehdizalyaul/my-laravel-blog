<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crée 10 utilisateurs avec des articles associés
        User::factory(10)->create()->each(function ($user) {
            Post::factory(3)->create(['user_id' => $user->id]); // Chaque utilisateur a 3 articles
        });

        // Crée un utilisateur spécifique pour les tests
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
