<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $posts_count = Post::count();
        $posts_categories_count = Category::count();
        $postsByCategory = Category::query()
            ->has('posts')
            ->withCount('posts')
            ->get();

        return view('admin.home', [
            'posts_count' => $posts_count,
            'posts_categories_count' => $posts_categories_count,
            'postsByCategory' => $postsByCategory,
        ]);
    }
}
