@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Categories</h1>

        <!-- Link to Create a new Category -->
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>
    @if(count($categories) > 0)
    <!-- Delete Form -->
    <form action="{{ route('categories.clear') }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete all categories?')">Delete</button>
    </form>
    @endif
        <!-- Display Categories List -->
        <ul class="list-group">
            @if(count($categories) > 0)
                @foreach ($categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <!-- Link to Category Details -->
                        <p  class="text-decoration-none">{{ $category->name }}</p>

                        <div>
                            <!-- Edit Link -->
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>

                            <!-- Delete Form -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            @else
            <li class="list-group-item d-flex justify-content-between align-items-center">No category is available</li>

            @endif
        </ul>
    </div>
@endsection
