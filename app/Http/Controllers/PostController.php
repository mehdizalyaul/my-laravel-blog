<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $categories = $this->getDistict();

        return view('posts.index', compact('posts','categories'));
    }

    public function show($id)
    {
        $post = Post::with('category')->find($id);
        $comments = Comment::where('post_id', $id)->get();

    return view('posts.show', compact('post', 'comments'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }


    public function store(Request $request)
{
    // Validate the request first
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category_name' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Get the category by its name
    $category = Category::where('name', $request->input('category_name'))->first();

    // Check if the category exists
    if (!$category) {
        return redirect()->back()->with('error', 'Category not found.');
    }

    // Handle the image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
    }

    // Create a new post with the correct category_id and image path
    Post::create([
        'title' => $request->input('title'),
        'content' => $request->input('content'),
        'user_id' => auth()->id(),
        'category_id' => $category->id,
        'image' => $imagePath,
    ]);

    return redirect()->route('posts.index')->with('success', 'Article créé avec succès.');
}


    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('posts.edit', compact('post','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Get the category by its name
        $category = Category::where('name', $request->input('category_name'))->first();
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found.');
        }

        // Find the post
        $post = Post::findOrFail($id);

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }
            // Store new image
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        // Update other fields
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $category->id;

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function getDistict(){

        $categories = Post::with('category')->get()->pluck('category.name')->unique();

        return $categories;

    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index');
    }
}
