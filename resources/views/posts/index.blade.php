@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Liste des Articles</h1>
        <div class="d-flex flex-wrap">
            @foreach($posts as $post)

            @endforeach
        </div>     <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="categories-carousel">
            <button class="left-btn disable">&lt;</button>
            <div class="categories-carousel__container">

                    <?php
                    $index=0;
                    $start = 0;
                    $end = 12;

                    foreach ($categories as $category) {
                        if ($start > $end) {

                            echo '<button class="btn btn-primary m-1 inactive hidden" data-index="' . $start . '">' . htmlspecialchars($category) . '</button>';

                            $start++;

                        }else{
                            if($index == $start){

                            echo '<button class="btn btn-primary m-1 hidden" data-index="' . $start . '">' . 'All' . '</button>';

                            }else{

                                echo '<button class="btn btn-primary m-1 inactive hidden" data-index="' . $start . '">' . htmlspecialchars($category) . '</button>';

                            };


                            $start++;
                        }

                    }
                ?>

            </div>
            <button class="right-btn">&gt;</button>

        </div>


        <!-- Create New Post Button -->
        <br>
        <br>

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
                <tbody>
                    @foreach($posts as $post)
                        <tr>
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
                                <button class="btn btn-primary m-1">
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

    @vite(['resources/js/posts/index.js'])
    @endsection
