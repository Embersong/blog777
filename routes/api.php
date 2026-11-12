<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/posts/{post}/like', [PostController::class, 'like'])
    ->whereNumber('post')
    ->name('api.posts.like');
