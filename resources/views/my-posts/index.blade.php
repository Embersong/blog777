@extends('layouts.main')

@section('title', 'Мои посты')

@section('content')
    <h2>Мои посты</h2>

    @can('create', App\Models\Post::class)
        <a href="{{ route('my-posts.create') }}" class="btn btn-primary">Создать пост</a><br>
    @endcan

    @if ($posts->isEmpty())
        <p>У вас пока нет постов.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>№</th>
                <th>Заголовок</th>
                <th>Категория</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category->name ?? '-' }}</td>
                    <td>{{ $post->created_at?->format('d.m.Y H:i') ?? '-' }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Просмотр</a>

                            @can('update', $post)
                                <a href="{{ route('my-posts.edit', $post) }}" class="btn btn-primary">Правка</a>
                            @endcan

                            @can('delete', $post)
                                <form action="{{ route('my-posts.destroy', $post) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $posts->links('components.minimal') }}
    @endif

@endsection
