@extends('layouts.admin')

@section('title', 'CRUD категорий')

@section('content')
    <h2>CRUD категорий</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Создать категорию</a><br>

    @if ($categories->isEmpty())
        <p>Категорий пока нет.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>№</th>
                <th>Название</th>
                <th>Slug</th>
                <th>Описание</th>
                <th>Постов</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>{{ $category->posts_count }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Правка</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $categories->links('components.minimal') }}
    @endif
@endsection
