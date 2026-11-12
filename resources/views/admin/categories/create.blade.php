@extends('layouts.admin')

@section('title', 'Создание категории')

@section('content')

    <h2>Создание категории</h2>

    <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Добавить категорию</button>

    </form>
@endsection
