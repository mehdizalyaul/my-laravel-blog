<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', compact('posts','categories'));
    }

    public function show($id)
    {
    $post = Post::findOrFail($id); // Fetch the post or return 404
    $comments = Comment::where('post_id', $id)->get(); // Fetch related comments

    return view('posts.show', compact('post', 'comments'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }


    public function store(Request $request)
    {
        // Get the category by its name
        $category = Category::where('name', $request->input('category_name'))->first();

        // Check if the category exists
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found.');
        }

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_name' => 'required|string',
        ]);

        // Create a new post
        Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
            'category_id' => $category->id, // Use the category id
        ]);

        return redirect()->route('posts.index')->with('success', 'Article créé avec succès.');
    }


    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index');
    }
}
