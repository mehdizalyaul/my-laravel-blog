<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        return response()->json(Comment::all());
    }

    /**
     * Store a newly created comment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::create($request->all());

        return response()->json($comment, 201);
    }

    /**
     * Display a specific comment.
     */
    public function show(Comment $comment)
    {
        return response()->json($comment);
    }

    /**
     * Update an existing comment.
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'sometimes|string|max:500',
        ]);

        $comment->update($request->only('content'));

        return response()->json($comment);
    }

    /**
     * Remove a comment.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
