<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function like(Post $post)
    {

        $isLiked = $post->likes()->where('user_id', Auth::id())->where('post_id',$post->id)->exists();

    if($isLiked){
        return response()->json(['message' => 'You already liked this post.'], 400);
    }

    $post->likes()->create([
        'user_id' => Auth::id(),
        'post_id' => $post->id,
    ]);

    return response()->json([
        'like_count' => $post->likes()->count(),  // Count how many people liked the post
        'message' => 'Post liked successfully.',   // Send a success message
    ]);

    }

    public function unlike(Post $post)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();


    if (!$like) {
            return response()->json(['message' => 'You have not liked this post.'], 400);
        }

        // Delete the like
        $like->delete();

        // Return the updated like count
        return response()->json([
            'like_count' => $post->likes()->count(),
            'message' => 'Like removed successfully.',
        ]);
    }


}
