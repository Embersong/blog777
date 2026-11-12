<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()
            ->withCount('posts')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        Category::query()->create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Категория создана успешно');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);
        return to_route('admin.categories.index')->with('success', 'Категория успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return to_route('admin.categories.index')
                ->with('error', 'Нельзя удалить категорию, к которой привязаны посты');
        }

        try {
            $category->delete();
        } catch (\Throwable $th) {
            return to_route('admin.categories.index')->with('error', 'Ошибка при удалении категории');
        }

        return to_route('admin.categories.index')->with('success', 'Категория успешно удалена');
    }
}
