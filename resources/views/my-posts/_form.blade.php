<form action="{{ $post ? route('my-posts.update', $post) : route('my-posts.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($post ?? null)
        @method('put')
    @endif

    <div class="form-group">
        <label for="title">Заголовок</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post?->title) }}">
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="category_id">Категория</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="0">---</option>
            @foreach ($categories as $category)
                <option @selected(old('category_id', $post?->category_id) == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="content">Содержание</label>
        <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', $post?->content) }}</textarea>
        @error('content')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="image">Изображение</label>
        @if($post?->image)
            <div>
                <img  src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" style="max-width: 100px; display: block; margin-bottom: 8px;">
            </div>
        @endif
        <input type="file" name="image" id="image" class="form-control">
        @error('image')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ $post ? 'Изменить пост' : 'Добавить пост' }}</button>
</form>
