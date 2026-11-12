@extends('layouts.main')

@section('title', 'Создание поста')

@section('content')
    <h2>Создание поста</h2>

    @include('my-posts._form', [
    'post' => null
])

@endsection
