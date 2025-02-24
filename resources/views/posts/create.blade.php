@extends('layouts.app')

@section('content')
    <h1>Créer un Article</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Enregistrer</button>
    </form>
@endsection
