@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Créer un Article</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title Field -->
            <div class="form-group mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <!-- Content Field -->
            <div class="form-group mb-3">
                <label for="content" class="form-label">Contenu</label>
                <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div class="form-group mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" class="form-control-file border p-2">
            </div>

            <!-- Category Selection -->
            <div class="form-group mb-3">
                <label for="category_name" class="form-label">Categorie</label>
                <select class="form-select" name="category_name" aria-label="Default select example" required>
                    <option selected disabled>Open this select menu</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
        </form>
    </div>
@endsection
