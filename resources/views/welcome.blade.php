@extends('layouts.app')

@section('content')
<div class="search_results">
    <div class="container text-center mt-5">
        <h1 class="display-4">Bienvenue sur Mon Blog</h1>
        <p class="lead">Découvrez les derniers articles et mises à jour.</p>

        <a href="{{ route('posts.index') }}" class="btn btn-primary btn-lg mt-3">Voir les Articles</a>
    </div>
</div>
    <script>
        let currentUserId = {{ auth()->id() }};
    </script>

@vite(['resources/js/posts/header.js','resources/css/app.css'])
@endsection
