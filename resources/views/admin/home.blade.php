@extends('layouts.admin')

@section('title', 'Админка')

@section('content')
    <h2>Добро пожаловать в админку</h2>

    <h3>Статистика</h3>
    <p>Всего категорий: {{ $posts_categories_count }}</p>
    <p>Всего постов: {{ $posts_count }}</p>

    @if ($postsByCategory->isEmpty())
        <p>Категорий пока нет.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Категория</th>
                <th>Количество постов</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($postsByCategory as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->posts_count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
