<a @class(['active' => request()->routeIs('home')]) href="{{ route('home') }}">Главная</a>
<a @class(['active' => request()->routeIs('posts.*')]) href="{{ route('posts.index') }}">Посты</a>

@auth
    <a @class(['active' => request()->routeIs('my-posts.*')]) href="{{ route('my-posts.index') }}">Мои Посты</a>
@endauth

<a @class(['active' => request()->routeIs('about')]) href="{{ route('about') }}">О нас</a>
@auth
    @if (auth()->user()->is_admin)
        <a @class(['active' => request()->routeIs('admin.*')]) href="{{ route('admin.home') }}">Админка</a>
    @endif
    <form method="post" action="{{ route('auth.logout') }}" class="inline-form">
        <button class="btn-link" type="submit">Выйти ({{ auth()->user()->name }})</button>
    </form>
@else
    <a href="{{ route('auth.login') }}">Войти</a>
@endauth

<br>
