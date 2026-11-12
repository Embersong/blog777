<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MyPostController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Post::class);

        $posts = $request->user()->posts()->with('category')->latest()->paginate(15);

        return view('my-posts.index', compact('posts'));
    }

    public function create(): View
    {
        Gate::authorize('create', Post::class);

        return view('my-posts.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        Gate::authorize('create', Post::class);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = $request->user()->posts()->create($data);


        return to_route('posts.show', $post->id)->with('success', 'Пост создан успешно');
    }

    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);

        return view('my-posts.edit', [
            'post' => $post,
            'categories' => Category::all(),
        ]);
    }

    public function update(StorePostRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image);
            $data['image'] = $request->file('image')->store('posts', 'public');
        }


        $post->update($data);

        return to_route('my-posts.index')->with('success', 'Пост успешно обновлен');
    }

    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return to_route('my-posts.index')->with('success', 'Пост успешно удален');
    }

}
