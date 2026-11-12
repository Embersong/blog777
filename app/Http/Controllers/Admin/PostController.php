<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    // CRUD posts показываем все посты


    public function index()
    {
        $posts = Post::query()->orderBy('id', 'desc')->paginate(15);

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        try {
            $validated = $request->validated();
            $validated['user_id'] = auth()->id();
            Post::query()->create($validated);

        } catch (\Exception $th) {
            return to_route('admin.posts.create')->with('error', 'Ошибка создания поста');
        }
        return to_route('admin.posts.index')->with('success', 'Пост создан успешно');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $validated = $request->validated();
        $validated['user_id'] = 1;
        $post->update($validated);

        return to_route('admin.posts.index')->with('success', 'Пост успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.posts.index')->with('error', 'Ошибка при удалении поста');
        }

        return to_route('admin.posts.index')->with('success', 'Пост успешно удален');
    }
}
