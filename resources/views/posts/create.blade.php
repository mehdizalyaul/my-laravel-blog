@extends('layouts.app')

@section('content')
    <h1>Créer un Article</h1>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label>Image:</label>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label for="categories">Categorie</label>

            <select class="form-select" name="category_name" aria-label="Default select example">
                <option selected>Open this select menu</option>

                @foreach($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>



        </div>

        <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
    </form>
@endsection
