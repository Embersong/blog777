@extends('layouts.main')

@section('title', 'Посты')

@section('content')
    <h2>{{ $post->title }}</h2>
    <p><strong>Категория:</strong> {{ $post->category->name ?? '-' }}</p>
    <p><strong>Автор:</strong> {{ $post->user->name ?? '-' }}</p>

    @if ($post->image)
        <img style="width: 200px" src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="post-image">
    @endif

    <p>{{ $post->content }}</p>

    <p>
        <button id="like-button" data-url="{{ route('api.posts.like', $post) }}">
            Like: <span id="like-count">{{ $post->likes }}</span>
        </button>
    </p>

    <h3>Комментарии ({{ $post->comments->count() }})</h3>

    @forelse ($post->comments as $comment)
        <div>
            <p>
                <strong>{{ $comment->user->name ?? 'Аноним' }}</strong>
                <small>{{ $comment->created_at->format('d.m.Y H:i') }}</small>
            </p>
            <p>{{ $comment->comment }}</p>
        </div>
    @empty
        <p>Комментариев пока нет.</p>
    @endforelse

    @auth
        <h3>Оставить комментарий</h3>

        <form action="{{ route('comments.store', $post) }}" method="post">
            @csrf

            <div class="form-group">
                <label for="comment">Комментарий</label>
                <textarea name="comment" id="comment" class="form-control" rows="4">{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    @else
        <p><a href="{{ route('auth.login') }}">Войдите</a>, чтобы оставить комментарий.</p>
    @endauth
    <script>
        document.getElementById('like-button').addEventListener('click',
         async (event) => {
            const button = event.currentTarget;
            button.disabled = true;

            try {
                const response = await fetch(button.dataset.url, {
                    method: 'POST',
                    headers: {'Accept': 'application/json'}
                });

                if (response.ok) {
                    const data = await response.json();
                    document.getElementById('like-count').textContent = data.likes;

                }
            } finally {
                button.disabled = false;
            }
        });
    </script>
@endsection
