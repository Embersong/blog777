<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\MyPostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');


Route::controller(PostController::class)
    ->prefix('posts')
    ->name('posts.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{post}', 'show')->whereNumber('id')->name('show');
        Route::get('/category/{category:slug}', 'category')->name('category');
    });

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->whereNumber('post')
    ->middleware('auth')
    ->name('comments.store');

Route::view('/about', 'about')->name('about');

//TODO AdminHomeController сделайте контроллер с одним метдом invoke
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'is_admin'])
    ->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');
    Route::resource('posts', AdminPostController::class)->except('show');
    Route::resource('categories', AdminCategoryController::class)->except('show');


});

Route::middleware('auth')->group(function () {
    Route::resource('my-posts', MyPostController::class)
        ->except('show')
        ->parameter('my-posts', 'post');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout')->middleware('auth');
