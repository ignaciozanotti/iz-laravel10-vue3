<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

require __DIR__.'/auth.php';

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'token' => session('token'),
        ]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/blog/posts', function () {
        return Inertia::render('Blog/Posts/Index', [
            'isAdmin' => auth()->user()?->role === 'admin',
        ]);
    })->name('blog.posts.index');

    Route::get('/blog/posts/{id}/show', function ($id) {
        return Inertia::render('Blog/Posts/Show', ['id' => $id]);
    })->name('blog.posts.show');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function () {
            return Inertia::render('Dashboard', ['message' => 'Admin Only Area']);
        })->name('admin');

        // Categories management routes
        Route::get('/blog/categories', function () {
            return Inertia::render('Blog/Categories/Index');
        })->name('blog.categories.index');

        Route::get('/blog/categories/create', function () {
            return Inertia::render('Blog/Categories/Create');
        })->name('blog.categories.create');

        Route::get('/blog/categories/{id}/edit', function ($id) {
            return Inertia::render('Blog/Categories/Edit', ['id' => $id]);
        })->name('blog.categories.edit');

        // Posts management routes
        Route::get('/blog/posts/create', function () {
            return Inertia::render('Blog/Posts/Create');
        })->name('blog.posts.create');

        Route::get('/blog/posts/{id}/edit', function ($id) {
            return Inertia::render('Blog/Posts/Edit', ['id' => $id]);
        })->name('blog.posts.edit');

    });
});