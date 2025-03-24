<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function like($slug, Request $request)
{
    $likeableType = $request->likeable_type;

    // Check if the likeable type is 'post'
    if ($likeableType == 'post') {
        // Use slug to find the actual post being liked
        $post = Post::where('slug', $slug)->firstOrFail();

        // Create a like for the post
        $post->likes()->create([
            'user_id' => Auth::id(),
            'likeable_id' => $post->id, // Set likeable_id to the post's ID
            'likeable_type' => 'App\Models\Post', // Set likeable_type to the model's full class name
        ]);

        return response()->json([
            'like_count' => $post->likes()->count(),
            'message' => 'Post liked successfully.',
        ]);
    }
    // Check if the likeable type is 'comment'
    else if ($likeableType == 'comment') {
        // Use slug to find the actual comment being liked
        $comment = Comment::where('slug', $slug)->firstOrFail();

        // Create a like for the comment
        $comment->likes()->create([
            'user_id' => Auth::id(),
            'likeable_id' => $comment->id, // Set likeable_id to the comment's ID
            'likeable_type' => 'App\Models\Comment', // Set likeable_type to the model's full class name
        ]);

        return response()->json([
            'like_count' => $comment->likes()->count(),
            'message' => 'Comment liked successfully.',
        ]);
    }

    // Return error if likeable_type is neither Post nor Comment
    return response()->json([
        'message' => 'Invalid likeable type.',
    ], 400);
}



    public function unlike($slug,Request $request)
    {

        $likeableType = $request->likeable_type;


          // Check if the likeable type is 'Post'
    if ($likeableType == 'post') {
        // Use likeable_id to find the actual post being liked
        $post = Post::where('slug', $slug)->firstOrFail();  // Corrected here
        $post->likes()->where('user_id', Auth::id())->delete();

          // Return the updated like count
          return response()->json([
            'like_count' => $post->likes()->count(),
            'message' => 'Like removed successfully.',
        ]);

    } else if ($likeableType == 'comment') {
        // Use likeable_id to find the actual comment being liked
        $comment = Comment::where('slug', $slug)->firstOrFail();  // Corrected here
        $comment->likes()->where('user_id', Auth::id())->delete();

         // Return the updated like count
         return response()->json([
            'like_count' => $comment->likes()->count(),
            'message' => 'Like removed successfully.',
        ]);
    }
      // Return error if likeable_type is neither Post nor Comment
      return response()->json([
        'message' => 'Invalid likeable type.',
    ], 400);


    }


}
