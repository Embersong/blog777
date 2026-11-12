<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function like(Post $post): JsonResponse
    {
        $post->increment('likes');

        return response()->json([
            'success' => true,
            'likes' => $post->likes
        ]);
    }
}
