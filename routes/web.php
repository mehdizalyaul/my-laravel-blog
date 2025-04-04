<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;


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
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/categories', [CategoryController::class, 'clear'])->name('categories.clear');

    Route::post('/posts/{slug}/like', [LikeController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{slug}/like', [LikeController::class, 'unlike'])->name('posts.unlike');
    Route::post('/posts/search', [PostController::class, 'getBySearchValue'])->name('posts.getBySearchValue');


    Route::post('/comments/{slug}/like', [LikeController::class, 'like'])->name('comments.like');
    Route::delete('/comments/{slug}/like', [LikeController::class, 'unlike'])->name('comments.unlike');

    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');

    // Routes protégées pour gérer les articles (création, modification, suppression)
    Route::resource('posts', PostController::class)->except(['index', 'show','getByCategoryName','getBySearchValue','destroy','update']);
    Route::put('/posts/{slug}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{slug}', [PostController::class, 'destroy'])->name('posts.destroy');

});

Route::get('/posts/category/{categoryName}', [PostController::class, 'getByCategoryName']);


// Routes accessibles sans authentification
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
// Show post with comments

Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

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
