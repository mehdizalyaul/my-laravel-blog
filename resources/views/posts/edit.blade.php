@extends('layouts.app')

@section('content')
<div class="search_results">
    <div class="container">
        <div class="card shadow-sm p-4">
            <h2 class="mb-3"><i class="fas fa-edit"></i> Modifier l'Article</h2>

            <form action="{{ route('posts.update', $post->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="mb-3">
                    <label for="title" class="form-label"><strong>Titre</strong></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if ($post->image)
                        <div class="text-left my-3">
                            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded shadow-sm" style="width: 200px; height: 200px;">
                        </div>
                 @else
                        <div class="text-left my-3">
                            <img src="{{ asset('images/default-image.webp') }}" class="img-fluid rounded shadow-sm" style="width: 200px; height: 200px;">
                        </div>
                @endif

                <div class="form-group mb-3">
                    <label for="image" class="form-label"><strong>Image</strong></label>
                    <input type="file" name="image" class="form-control-file border p-2">
                </div>

                <!-- Contenu -->
                <div class="mb-3">
                    <label for="content" class="form-label"><strong>Contenu</strong></label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category Selection -->
            <div class="form-group mb-3">
                <label for="category_name" class="form-label"><strong>Categorie</strong></label>
                <select class="form-select" name="category_name" aria-label="Default select example" required>
                    <option disabled selected>{{ $post->category->name }}</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->name }}"
                            {{ $category->name == $post->category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

            </div>

                <!-- Boutons -->
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    let currentUserId = {{ auth()->id() }};
</script>
<!-- jQuery (Required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@vite(['resources/js/posts/header.js','resources/css/app.css'])
@endsection

