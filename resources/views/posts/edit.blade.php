@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow-sm p-4">
            <h2 class="mb-3"><i class="fas fa-edit"></i> Modifier l'Article</h2>

            <form action="{{ route('posts.update', $post->id) }}" method="POST">
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

                <!-- Contenu -->
                <div class="mb-3">
                    <label for="content" class="form-label"><strong>Contenu</strong></label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
@endsection

