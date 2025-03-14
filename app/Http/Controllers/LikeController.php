<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function like($likeId,Request $request)
{

    $likeableType = $request->likeable_type;

    // Check if the likeable type is 'Post'
    if ($likeableType == 'post') {
        // Use likeable_id to find the actual post being liked
        $post = Post::find($likeId);  // Corrected here
        $post->likes()->create([
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'like_count' => $post->likes()->count(),
            'message' => 'Post liked successfully.',
        ]);

    } else if ($likeableType == 'comment') {
        // Use likeable_id to find the actual comment being liked
        $comment = Comment::find($likeId);  // Corrected here
        $comment->likes()->create([
            'user_id' => Auth::id(),
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


    public function unlike($likeId,Request $request)
    {

        $likeableType = $request->likeable_type;


          // Check if the likeable type is 'Post'
    if ($likeableType == 'post') {
        // Use likeable_id to find the actual post being liked
        $post = Post::find($likeId);  // Corrected here
        $post->likes()->where('user_id', Auth::id())->delete();

          // Return the updated like count
          return response()->json([
            'like_count' => $post->likes()->count(),
            'message' => 'Like removed successfully.',
        ]);

    } else if ($likeableType == 'comment') {
        // Use likeable_id to find the actual comment being liked
        $comment = Comment::find($likeId);  // Corrected here
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
