<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Seeders\PostSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the seeders
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
