@extends('layouts.admin')

@section('title', 'crud posts')

@section('content')
    <h2>CRUD постов</h2>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Создать пост</a><br>
    @if ($posts->isEmpty())
        <p>Постов пока нет.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>№</th>
                <th>Заголовок</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->title }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">


                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary">Правка</a>


                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post">
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
        {{ $posts->links('components.minimal') }}
    @endif
@endsection
