<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Register routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Routes liées au profil de l'utilisateur (connexion requise)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes protégées pour gérer les articles (création, modification, suppression)
    Route::resource('posts', PostController::class)->except(['index', 'show']);
});

// Routes accessibles sans authentification
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
// Show post with comments

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

// Store a new comment
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// Show edit form for a comment
Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');

// Update a comment
Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');

// Delete a comment
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Ensure Breeze's authentication routes are included
require __DIR__.'/auth.php';
