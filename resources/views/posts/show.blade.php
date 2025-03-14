@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg p-4">
        <!-- Post Title & Author -->
        <h1 class="mb-4 text-center">{{ $post->title }}</h1>
        <p class="text-muted text-center mb-4"><strong>Auteur:</strong> {{ $post->user->name }}</p>

        <!-- Post Image -->
        <div class="text-center my-4">
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-4" style="max-width: 80%; height: auto;">
            @else
                <img src="{{ asset('images/default-image.webp') }}" class="img-fluid rounded mb-4" style="max-width: 80%; height: auto;">
            @endif
        </div>

        <!-- Post Category -->
        <div class="text-center mb-3">
            <button class="btn btn-primary btn-sm post_category" data-category="{{$post->category->name}}">
                {{ $post->category ? $post->category->name : 'Uncategorized' }}
            </button>
        </div>

        <!-- Post Content -->
        <p class="mt-3">{{ $post->content }}</p>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            @if($post->user_id === auth()->id())
                <div class="d-flex gap-2">
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
                </div>
            @endif
            <button class="btn btn-outline-danger btn-sm like-btn {{$post->likes->contains('user_id', auth()->id()) ? 'liked' : ''}}" data-post-id="{{ $post->id }}">
                <i class="fas fa-heart"></i> <span class="like-count">{{ $post->likes->count() }}</span>
            </button>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="mt-5">
        <h3 class="text-center">Commentaires ({{ $comments->count() }})</h3>

        @foreach ($comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <p class="fw-bold">{{ $comment->user->name }}
                        <span class="text-muted">- {{ $comment->created_at->diffForHumans() }}</span>
                    </p>
                    <p>{{ $comment->content }}</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-danger btn-sm like-btn {{$comment->likes->contains('user_id', auth()->id()) ? 'liked' : ''}}" data-comment-id="{{ $comment->id }}">
                            <i class="fas fa-heart"></i> <span class="like-count">{{ $comment->likes->count() }}</span>
                        </button>
                        @if($comment->user_id === auth()->id())
                            <button class="btn btn-sm btn-warning edit_comment_btn" data-comment-id="{{ $comment->id }}">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer ce commentaire ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        @endif
                        <button class="btn btn-sm btn-secondary reply_comment_btn" data-comment-id="{{ $comment->id }}">
                            <i class="fa-solid fa-reply"></i> Répondre
                        </button>
                    </div>

                    <!-- Reply Form -->
                    <form id="reply-form-{{ $comment->id }}" action="{{ route('comments.reply', $comment->id) }}" method="POST" style="display:none;" class="mt-3">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="content" class="form-control" rows="3" required></textarea>
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Répondre</button>
                    </form>

                    <!-- Edit Comment Form (Hidden Initially) -->
                    <form id="edit-form-{{ $comment->id }}" action="{{ route('comments.update', $comment->id) }}" method="POST" style="display:none;" class="mt-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                        <textarea name="content" class="form-control" rows="3" required>{{ old('content', $comment->content) }}</textarea>
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Mettre à jour</button>
                    </form>

                    <!-- Recursively Show Replies Inside the Same File -->
                    @if ($comment->replies->count())
                        <div class="ms-4 mt-3 border-start ps-3">
                            @foreach ($comment->replies as $reply)
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <p class="fw-bold">{{ $reply->user->name }}
                                            <span class="text-muted">- {{ $reply->created_at->diffForHumans() }}</span>
                                        </p>
                                        <p>{{ $reply->content }}</p>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm btn-warning edit_reply_btn" data-reply-id="{{ $reply->id }}">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </button>
                                                <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer ce commentaire ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </form>

                                            </div>

                                    </div>
                                    <form id="edit-form-{{ $reply->id }}" action="{{ route('comments.update', $reply->id) }}" method="POST" style="display:none;" class="mt-3">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="comment_id" value="{{ $reply->id }}">
                                        <textarea name="content" class="form-control" rows="3" required>{{ old('content', $reply->content) }}</textarea>
                                        <button type="submit" class="btn btn-sm btn-primary mt-2">Mettre à jour</button>
                                    </form>
                                </div>
                            @endforeach
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

<!-- jQuery (Required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@vite(['resources/js/posts/show.js','resources/js/posts/index.js','resources/css/show.css'])
@endsection
