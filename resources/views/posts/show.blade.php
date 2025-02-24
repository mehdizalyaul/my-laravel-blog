@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow-sm p-4">
            <h1 class="mb-3">{{ $post->title }}</h1>
            <p class="text-muted"><strong>Auteur:</strong> {{ $post->user->name }}</p>
            <p class="mt-3">{{ $post->content }}</p>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>

                @if($post->user_id === auth()->id())
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier l'Article
                    </a>

                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Supprimer l'Article
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
