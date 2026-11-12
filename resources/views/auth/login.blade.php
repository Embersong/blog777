@extends('layouts.main')

@section('title', 'Войти')

@section('content')
    <h2>Вход</h2>

    <form action="" method="POST" class="form">
        @csrf

        <div class="form-group">
            <label>email<br>
                <input class="form-control" type="text" name="email" value="{{ old('email', 'admin@admin.ru') }}" autofocus>
            </label>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group">
            <label>Пароль<br>
                <input class="form-control" type="password" name="password" value="123">
            </label>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="remember"> Запомнить меня
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
@endsection
