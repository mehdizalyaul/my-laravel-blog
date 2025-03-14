<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
    $comments = Comment::whereNull('parent_id')->with('replies')->get();
    return response()->json($comments);
    }

    /* Store a newly created comment.*/

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:500',
        ]);

        // Create the comment with the authenticated user's ID
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

       // Redirect back to the post page
    return redirect()->route('posts.show', ['id' => $request->post_id])
    ->with('success', 'Your comment has been posted!');
    }

    /**
     * Update an existing comment.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Find the comment by ID
        $comment = Comment::findOrFail($id);
        // Ensure the user is the author of the comment
        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'You are not authorized to update this comment.');
        }

        // Update the comment's content
        $comment->content = $request->content;
        $comment->save();

        // Redirect back with a success message
        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Your comment has been updated!');
    }

    /**
     * Remove a comment.
     */
    public function destroy($id)
    {
        $comment= Comment::find($id);
        $comment->delete();

        return back()->with('success', 'Your comment has been deleted!');;

    }


    public function reply(Comment $comment, Request $request){

        $comment->replies()->create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
            'parent_id' =>$comment->id,
        ]);
        return redirect()->route('posts.show',$request->post_id);
    }
}
