@extends('layouts.app')

@section('content')
<div class="category-carousel owl-carousel">
    @foreach($categories as $category)
        <div class="category-item" data-category="{{ $category }}">
            <span class="category-tag">{{ $category }}</span>
        </div>
    @endforeach
</div>
        <h1 class="mb-4">Liste des Articles</h1>
           <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="search_results">
        <!-- Create New Post Button -->
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Créer un Article
        </a>
        <!-- Posts Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Auteur</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table_container">
                    @foreach($posts as $post)
                        <tr class="post_item" data-post-id="{{$post->id}}">
                            <td>
                                @if ($post->image)
                                    <div class="text-center my-3">
                                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded shadow-sm" style="width: 60px; height: 60px;">
                                    </div>
                                @else
                                    <div class="text-center my-3">
                                        <img src="{{ asset('images/default-image.webp') }}" class="img-fluid rounded shadow-sm" style="width: 60px; height: 60px;">
                                    </div>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary m-1 post_category" data-category={{ $post->category->name }}>
                                    {{ $post->category ? $post->category->name : 'Uncategorized' }}
                                </button>
                                {{ $post->title }}
                            </td>
                            <td>{{ $post->user->name }}</td>
                            <td class="text-left">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Voir
                                </a>

                                @if($post->user_id === auth()->id())
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                @endif
                                <button class="btn btn-outline-danger btn-sm like-btn {{$post->likes->contains('user_id', auth()->id()) ? 'liked' : ''}}"
                                    data-post-id="{{ $post->id }}">
                                    <i class="fas fa-heart"></i>
                                    <span class="like-count">{{ $post->likes->count() }}</span>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $posts->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
        <script>
            let currentUserId = {{ auth()->id() }};
        </script>
<!-- jQuery (Required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    @vite(['resources/js/posts/index.js','resources/js/posts/header.js','resources/css/app.css'])
    @endsection
