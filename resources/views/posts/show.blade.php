@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm p-4">
        <!-- Post Title & Author -->
        <h1 class="mb-3">{{ $post->title }}</h1>
        <p class="text-muted"><strong>Auteur:</strong> {{ $post->user->name }}</p>

        <!-- Post Image -->
    <div class="text-center my-3">

        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-3" style="max-width: 50%; height: 50%;">
        @else
            <span class="text-muted">Aucune image</span>
        @endif
    </div>
        <!-- Post Category -->
        <button class="btn btn-primary btn-sm mb-3">
            {{ $post->category ? $post->category->name : 'Uncategorized' }}
        </button>

        <!-- Post Content -->
        <p class="mt-3">{{ $post->content }}</p>

        <!-- Action Buttons -->
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
                    <p class="fw-bold">{{ $comment->user->name }} <span class="text-muted">- {{ $comment->created_at->diffForHumans() }}</span></p>
                    <p>{{ $comment->content }}</p>

                    @if($comment->user_id === auth()->id())
                        <div class="d-flex gap-2">
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-warning" onclick="toggleEditForm({{ $comment->id }})">
                                <i class="fas fa-edit"></i> Modifier
                            </button>

                            <!-- Delete button -->
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer ce commentaire ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>

                        <!-- Edit Comment Form (Hidden Initially) -->
                        <form id="edit-form-{{ $comment->id }}" action="{{ route('comments.update', $comment->id) }}" method="POST" style="display:none;" class="mt-3">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <textarea name="content" class="form-control" rows="3" required>{{ old('content', $comment->content) }}</textarea>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Mettre à jour</button>
                        </form>
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
                <textarea name="content" class="form-control mb-3" rows="3" placeholder="Écrivez votre commentaire..." required></textarea>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-comment"></i> Publier
                </button>
            </form>
        </div>
    @endauth

    @guest
        <p class="mt-3 text-muted">Vous devez être connecté pour ajouter un commentaire.</p>
    @endguest
</div>

<!-- JavaScript to Toggle Edit Form -->
<script>
    function toggleEditForm(commentId) {
        var form = document.getElementById('edit-form-' + commentId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection
