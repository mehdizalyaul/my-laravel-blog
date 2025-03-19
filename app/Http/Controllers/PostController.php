<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class   PostController extends Controller
{
    public function index(Request $request)
    {
        // Get the search value (defaults to an empty string if not set)
        $searchValue = strtolower($request->input('search_value', ''));

        // Check if it's an AJAX request (Apply search only for AJAX)
        if ($request->ajax()) {
            // Fetch filtered posts based on title, content, or author's name
            $posts = Post::with(['user', 'category', 'likes'])
                ->where(function ($query) use ($searchValue) {
                    $query->whereRaw('LOWER(title) LIKE ?', ["%{$searchValue}%"])
                        ->orWhereRaw('LOWER(content) LIKE ?', ["%{$searchValue}%"])
                        ->orWhereHas('user', function ($query) use ($searchValue) {
                            $query->whereRaw('LOWER(name) LIKE ?', ["%{$searchValue}%"]);
                        });
                })
                ->get();

            return response()->json(['success' => true, 'posts' => $posts]);
        }

        // Normal page load (No search applied)
        $posts = Post::with(['user', 'category', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch distinct categories for filtering
        $categories = $this->getDistinctCategories(); // Ensure this function exists

        // Return the view with posts, categories, and search value
        return view('posts.index', compact('posts', 'categories', 'searchValue'));
    }



    public function show($id)
    {
        $post = Post::with(['user', 'category','likes'])->find($id);
        $comments = Comment::where('post_id', $id)->whereNull('parent_id')->with('replies')->get();



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
        'user_id' => auth()->id,
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

    public function getDistinctCategories(){

        $categories = Post::with('category')->get()->pluck('category.name')->unique();

        return $categories;

    }

    public function getByCategoryName($categoryName)
    {
        // Retrieve posts filtered by category name
        $posts = Post::with(['user', 'category'])
                     ->whereHas('category', function ($query) use ($categoryName) {
                         $query->where('name', $categoryName);
                     })
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);

        // Fetch distinct categories (if needed for category selection on the view)
        $categories = $this->getDistinctCategories();

        // Return Blade view with posts and categories
        return view('posts.index', compact('posts', 'categories'));
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index');
    }
}
