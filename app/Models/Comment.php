<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = ['content', 'post_id', 'user_id', 'parent_id','slug'];

      /**
     * Configure the options for the sluggable field.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('comment') // Generate slug from 'comment'
            ->saveSlugsTo('slug') // Save in 'slug' column
            ->usingSeparator('-')
            ->doNotGenerateSlugsOnUpdate(); // Prevent updating on edits
    }

     /**
     * Boot method to update slug after creation.
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            $comment->slug = $comment->id . '-' . Str::slug($comment->comment, '-');
            $comment->save();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }


    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }


}
