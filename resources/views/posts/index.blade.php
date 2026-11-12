@extends('layouts.main')

@section('title', 'Пост')

@section('content')
    <h2>Категории</h2>
    @foreach($categories as $category)
        <a href="{{ route('posts.category', $category->slug) }}" title="{{ $category->description }}">
            {{ $category->name }}&nbsp;
        </a>
    @endforeach
    <h2>Фильтр</h2>

    <form action="{{ route('posts.index') }}" method="get">
        <div class="form-group">
            <label for="title">Поиск по заголовку</label>
            <input type="search" name="filter[title]" id="title" class="form-control" value="{{ request('filter.title') }}">
        </div>

        <div class="form-group">
            <label for="category">Категория</label>
            <select name="filter[category]" id="category" class="form-control">
                <option value="">Все категории</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('filter.category') === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="user">Автор</label>
            <select name="filter[user]" id="user" class="form-control">
                <option value="">Все авторы</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected((string) request('filter.user') === (string) $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Применить</button>
        <a href="{{ route('posts.index') }}" class="btn">Сбросить</a>
    </form>

    <h2>Все посты</h2>
    @forelse ($posts as $post)
        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
        Категория: {{ $post->category->name ?? '-' }}
        <br>
    @empty
        <p>Нет постов</p>
    @endforelse
    {{ $posts->links('components.minimal') }}
@endsection
