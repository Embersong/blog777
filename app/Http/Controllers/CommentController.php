<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'comment' => $validated['comment'],
        ]);

        return to_route('posts.show', $post)->with('success', 'Комментарий добавлен');
    }
}
