@extends('layouts.admin')

@section('title', 'Изменение категории')

@section('content')
    <h2>Изменение категории</h2>

    <form action="{{ route('admin.categories.update', $category) }}" method="post">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}">
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Изменить категорию</button>
    </form>
@endsection
