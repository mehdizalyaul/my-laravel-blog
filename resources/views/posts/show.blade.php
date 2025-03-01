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

        <!-- Comments Section -->
        <div class="mt-5">
            <h3>Commentaires ({{ $comments->count() }})</h3>

            @foreach ($comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <p><strong>{{ $comment->user->name }}</strong> - <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span></p>
                        <p>{{ $comment->content }}</p>

                        @if($comment->user_id === auth()->id())
                            <div class="d-flex gap-2">
                                <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>

                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer ce commentaire ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Add Comment Form -->
        @auth
            <div class="mt-4">
                <h4>Ajouter un commentaire</h4>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="mb-3">
                        <textarea name="content" class="form-control" rows="3" placeholder="Écrivez votre commentaire..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-comment"></i> Publier le commentaire
                    </button>
                </form>
            </div>
        @endauth

        @guest
            <p class="mt-3 text-muted">Vous devez être connecté pour ajouter un commentaire.</p>
        @endguest

    </div>
@endsection
