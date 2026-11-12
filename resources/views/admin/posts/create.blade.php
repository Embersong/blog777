@extends('layouts.admin')

@section('title', 'Создание поста')

@section('content')

    <h2>Создание поста</h2>

    <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="0">---</option>
                @foreach($categories as $category)
                    <option @selected(old('category_id') == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Содержание</label>
            <textarea name="content" id="content" class="form-control" rows="5">{{ old('content') }}</textarea>
        </div>
        @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary">Добавить пост</button>

    </form>
@endsection
