@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Liste des Articles</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Create New Post Button -->
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Créer un Article
        </a>

        <!-- Posts Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Auteur</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
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
@endsection
