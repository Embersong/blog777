<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{


    function index()
    {
        $categories = Category::all();
        $users = User::query()->orderBy('name')->get();

        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters(
                AllowedFilter::exact('category', 'category_id')->ignore(null, ''),
                AllowedFilter::exact('user', 'user_id')->ignore(null, ''),
                AllowedFilter::callback('title', function ($query, $value) {
                    $query->whereRaw('LOWER(title) LIKE ?', ['%'.mb_strtolower($value).'%']);
                })->ignore(null, ''),
            )
            ->with(['category', 'user'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    function show(Post $post)
    {
/*       $post->load(['comments' => function ($q) {
           $q->with('user')->orderBy('created_at', 'desc');
       }]);
    //если нужны допзапросы
*/


       $post->load('comments.user');

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    function category(Category $category)
    {

        $categories = Category::all();
        $users = User::query()->orderBy('name')->get();
        $posts = $category->posts()->with('category')->latest()->paginate(10)->withQueryString();


        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'users' => $users,
        ]);
    }
}
