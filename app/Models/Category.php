<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Specify the fillable fields to allow mass assignment
    protected $fillable = ['name', 'description'];

    // Optionally, define relationships if necessary
    // For example, if Category has many posts:
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
